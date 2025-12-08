<?php

namespace App\Http\Controllers;

use App\Models\TravelDocument;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TrackingController extends Controller
{
    /**
     * Menampilkan halaman tracking dengan daftar pengiriman aktif
     */
    public function index(Request $request)
    {
        // Hitung jumlah
        $totalActive = TravelDocument::whereRaw("LOWER(status) LIKE '%sedang%'")->count();
        $totalDelivered = TravelDocument::where('status', 'Terkirim')->count();

        // Ambil data (batasi 5 masing-masing)
        $activeShippings = TravelDocument::whereRaw("LOWER(status) LIKE '%sedang%'")
            ->select('id', 'no_travel_document', 'send_to', 'project', 'date_no_travel_document')
            ->orderBy('date_no_travel_document', 'desc')
            ->limit(5)
            ->get();

        $deliveredShippings = TravelDocument::where('status', 'Terkirim')
            ->select('id', 'no_travel_document', 'send_to', 'project', 'date_no_travel_document')
            ->orderBy('date_no_travel_document', 'desc')
            ->limit(5)
            ->get();

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('shippings.index')],
            ['label' => 'Tracking Pengiriman', 'url' => '#']
        ];

        return view('General.tracker', compact(
            'breadcrumbs',
            'activeShippings',
            'deliveredShippings',
            'totalActive',
            'totalDelivered'
        ));
    }

    /**
     * Cari tracking berdasarkan no_travel_document (dipanggil via AJAX)
     */
    public function search(Request $request)
    {
        $request->validate([
            'no_travel_document' => 'required|string|max:100'
        ]);

        // Ambil travel document + relasi trackingSystems
        $travelDocument = TravelDocument::where('no_travel_document', $request->no_travel_document)
            ->with('trackingSystems')
            ->first();

        if (!$travelDocument || $travelDocument->trackingSystems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengiriman tidak ditemukan atau belum memiliki tracking'
            ]);
        }

        // Ekstrak lokasi dari tabel `location` berdasarkan track_id
        $locations = $this->extractLocations($travelDocument);

        if (empty($locations)) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada data lokasi yang direkam untuk pengiriman ini'
            ]);
        }

        return response()->json([
            'success' => true,
            'locations' => $locations
        ]);
    }

    /**
     * Ambil rute dari OpenRouteService (via backend agar API key aman)
     */
    public function getRoute(Request $request)
    {
        $request->validate([
            'start' => 'required|array|size:2',
            'end' => 'required|array|size:2',
            'start.0' => 'numeric|between:-90,90',
            'start.1' => 'numeric|between:-180,180',
            'end.0' => 'numeric|between:-90,90',
            'end.1' => 'numeric|between:-180,180',
        ]);

        $apiKey = env('OPENROUTE_SERVICE_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'API key rute tidak dikonfigurasi'], 500);
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders(['Authorization' => $apiKey])
                ->get('https://api.openrouteservice.org/v2/directions/driving-car', [
                    'start' => implode(',', [$request->start[1], $request->start[0]]),
                    'end' => implode(',', [$request->end[1], $request->end[0]]),
                    'geometry_format' => 'geojson'
                ]);

            if ($response->successful() && !empty($response->json('features'))) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Tidak dapat menghasilkan rute'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal terhubung ke layanan rute'], 500);
        }
    }

    // --- HELPERS ---

    /**
     * Ekstrak semua lokasi dari tabel `location` berdasarkan track_id
     */
    private function extractLocations(TravelDocument $travelDocument): array
    {
        $locations = [];

        foreach ($travelDocument->trackingSystems as $ts) {
            // Ambil semua lokasi untuk track_id ini, urutkan berdasarkan time_stamp
            $locRecords = Location::where('track_id', $ts->track_id)
                ->orderBy('time_stamp', 'asc')
                ->get(['latitude', 'longitude', 'time_stamp']);

            foreach ($locRecords as $loc) {
                if ($loc->latitude && $loc->longitude) {
                    $locations[] = [
                        'latitude' => (float) $loc->latitude,
                        'longitude' => (float) $loc->longitude,
                        'timestamp' => $loc->time_stamp
                    ];
                }
            }
        }

        // Urutkan seluruh array berdasarkan timestamp (jika ada multi track)
        usort($locations, fn($a, $b) => strtotime($a['timestamp']) - strtotime($b['timestamp']));

        // Hapus duplikat dalam radius 10 meter
        $filtered = [];
        foreach ($locations as $loc) {
            $isDup = false;
            foreach ($filtered as $f) {
                $dist = $this->calculateDistance($f['latitude'], $f['longitude'], $loc['latitude'], $loc['longitude']);
                if ($dist < 0.01) { // 0.01 km = 10 meter
                    $isDup = true;
                    break;
                }
            }
            if (!$isDup) {
                $filtered[] = $loc;
            }
        }

        return $filtered;
    }

    /**
     * Hitung jarak antar dua koordinat (Haversine)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $R = 6371; // Radius bumi dalam km
        $latDiff = deg2rad($lat2 - $lat1);
        $lonDiff = deg2rad($lon2 - $lon1);
        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDiff / 2) * sin($lonDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }

    private function getReverseGeocode($latitude, $longitude)
    {
        try {
            $response = Http::timeout(5)->get('https://nominatim.openstreetmap.org/reverse', [
                'format' => 'jsonv2',
                'lat' => $latitude,
                'lon' => $longitude,
                'zoom' => 18,
                'addressdetails' => 1,
                'accept-language' => 'id'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['display_name'])) {
                    return $data['display_name'];
                }
            }
        } catch (\Exception $e) {
            Log::warning('Geocode error: ' . $e->getMessage());
        }

        return "Lokasi tidak dikenali";
    }
}
