<?php

namespace App\Http\Controllers;

use App\Models\TrackingSystem;
use App\Models\TravelDocument;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Show tracking page
     */
    public function index(Request $request)
    {
        if ($request->has(['status', 'message'])) {
            session()->flash($request->status, $request->message);
        }

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('shippings.index')],
            ['label' => 'Tracking Pengiriman', 'url' => '#']
        ];

        return view('General.tracker', compact('breadcrumbs'));
    }

    /**
     * Show tracker with specific track_id
     */
    public function show($track_id)
    {
        $trackingSystem = TrackingSystem::with('track')
            ->where('track_id', $track_id)
            ->firstOrFail();

        $locations = TrackingSystem::where('track_id', $track_id)
            ->get(['latitude', 'longitude']);

        $initialLocation = $locations->isNotEmpty()
            ? [$locations->first()->latitude, $locations->first()->longitude]
            : [0, 0];

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('shippings.index')],
            ['label' => 'Tracking Pengiriman', 'url' => route('tracking.index')],
            ['label' => 'Detail Tracking', 'url' => '#']
        ];

        return view('General.tracker', compact('trackingSystem', 'locations', 'initialLocation', 'breadcrumbs'));
    }

    /**
     * Search tracking by travel document number
     */
    public function search(Request $request)
    {
        $request->validate([
            'no_travel_document' => 'required|string'
        ]);

        $noTravelDocument = $request->query('no_travel_document');

        $travelDocument = TravelDocument::where('no_travel_document', $noTravelDocument)
            ->with(['trackingSystems.track.locations'])
            ->first();

        if (!$travelDocument) {
            return $this->errorResponse('Travel Document tidak ditemukan');
        }

        $locations = $this->extractLocations($travelDocument);

        if (empty($locations)) {
            return $this->errorResponse('Lokasi tidak ditemukan');
        }

        return response()->json([
            'success' => true,
            'locations' => $locations,
        ]);
    }

    // ========================================
    // HELPER METHODS (PRIVATE)
    // ========================================

    /**
     * Extract locations from travel document
     */
    private function extractLocations(TravelDocument $travelDocument): array
    {
        $locations = [];

        foreach ($travelDocument->trackingSystems as $trackingSystem) {
            foreach ($trackingSystem->track->locations as $location) {
                $locations[] = [
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                ];
            }
        }

        return $locations;
    }

    /**
     * Return error response
     */
    private function errorResponse(string $message)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 404);
        }

        return redirect()->back()->with('error', $message);
    }
}
