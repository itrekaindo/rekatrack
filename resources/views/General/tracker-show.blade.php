@extends('layouts.app')

@section('title', 'Detail Tracking | RekaTrack')
@php($pageName = 'Detail Tracking')

@section('content')
<div class="row">
  <!-- Info Panel -->
  <div class="col-12 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <h5 class="mb-3">Informasi Tracking</h5>
            <table class="table table-borderless table-sm">
              <tr>
                <td width="150"><strong>Track ID</strong></td>
                <td>: {{ $trackingSystem->track_id }}</td>
              </tr>
              <tr>
                <td><strong>Status</strong></td>
                <td>: <span class="badge badge-success">Active</span></td>
              </tr>
              <tr>
                <td><strong>Total Lokasi</strong></td>
                <td>: {{ $locations->count() }} titik</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <h5 class="mb-3">Lokasi Terakhir</h5>
            <table class="table table-borderless table-sm">
              <tr>
                <td width="150"><strong>Latitude</strong></td>
                <td>: {{ $locations->last()->latitude ?? '-' }}</td>
              </tr>
              <tr>
                <td><strong>Longitude</strong></td>
                <td>: {{ $locations->last()->longitude ?? '-' }}</td>
              </tr>
              <tr>
                <td><strong>Waktu</strong></td>
                <td>: {{ $trackingSystem->updated_at->format('d/m/Y H:i:s') }}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="mt-3">
          <a href="{{ route('tracking.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Map -->
  <div class="col-12">
    <div class="card">
      <div class="card-body p-0" style="height: 600px; position: relative;">
        <div id="map" class="w-100 h-100"></div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <style>
    #map {
      height: 100%;
      width: 100%;
      border-radius: 0.5rem;
    }
    .leaflet-container {
      z-index: 1;
    }
  </style>
@endpush

@push('scripts')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <script>
    // Data lokasi dari controller
    const locations = @json($locations);
    const initialLocation = @json($initialLocation);

    // Inisialisasi peta
    var map = L.map("map").setView(initialLocation, 13);

    L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 18,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Tambahkan marker untuk setiap lokasi
    locations.forEach((loc, index) => {
      const isLast = index === locations.length - 1;

      const icon = isLast
        ? L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
          })
        : null;

      const marker = icon
        ? L.marker([loc.latitude, loc.longitude], { icon: icon })
        : L.marker([loc.latitude, loc.longitude]);

      marker.addTo(map)
        .bindPopup(`
          <strong>${isLast ? 'Lokasi Terakhir' : 'Titik ' + (index + 1)}</strong><br>
          Lat: ${loc.latitude}<br>
          Lng: ${loc.longitude}
        `);

      if (isLast) {
        marker.openPopup();
      }
    });

    // Jika ada lebih dari 1 titik, gambar rute
    if (locations.length > 1) {
      const latLngs = locations.map(loc => [loc.latitude, loc.longitude]);
      const start = latLngs[0];
      const end = latLngs[latLngs.length - 1];
      const apiKey = '5b3ce3597851110001cf6248b4c0aaa51d204cea888ada05975d8638';

      fetch(`https://api.openrouteservice.org/v2/directions/driving-car?api_key=${apiKey}&start=${start[1]},${start[0]}&end=${end[1]},${end[0]}`)
        .then(response => response.json())
        .then(data => {
          if (data.features && data.features[0]) {
            const route = data.features[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);
            L.polyline(route, { color: '#1572e8', weight: 4, opacity: 0.7 }).addTo(map);
            map.fitBounds(L.latLngBounds(route));
          }
        })
        .catch(err => {
          console.warn('Failed to fetch route, showing direct line:', err);
          // Fallback: buat garis langsung
          L.polyline(latLngs, { color: '#6c757d', weight: 2, dashArray: '5,5' }).addTo(map);
          map.fitBounds(L.latLngBounds(latLngs));
        });
    }
  </script>
@endpush
