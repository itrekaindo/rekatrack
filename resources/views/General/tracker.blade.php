@extends('layouts.app')

@section('title', 'Tracking | RekaTrack')
@php($pageName = 'Tracking')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Cari Lokasi Pengiriman</h4>
      </div>
      <div class="card-body">
        <div class="d-flex flex-column flex-md-row gap-2">
          <input
            type="text"
            id="search"
            placeholder="Cari Berdasarkan Surat Jalan..."
            class="form-control"
          />
          <button
            onclick="searchTracking()"
            class="btn btn-primary"
          >
            <i class="fas fa-search me-1"></i> Cari
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 mt-4">
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
    // Inisialisasi peta
    var center = [-7.61617286255246, 111.52143728913316];
    var map = L.map("map").setView(center, 10);

    L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 18,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker(center).addTo(map).bindPopup("Lokasi Default");

    // Fungsi notifikasi ala Kaiadmin
    function showToast(type, message) {
      // Gunakan notifikasi bawaan Kaiadmin (berbasis Bootstrap)
      $.notify({
        icon: type === 'success' ? 'fas fa-check' :
              type === 'error' ? 'fas fa-times' :
              type === 'warning' ? 'fas fa-exclamation-triangle' : 'fas fa-info',
        title: type.charAt(0).toUpperCase() + type.slice(1),
        message: message,
      }, {
        type: type,
        placement: {
          from: "top",
          align: "right"
        },
        time: 5000,
        delay: 0,
        animate: {
          enter: 'animated fadeInDown',
          exit: 'animated fadeOutUp'
        }
      });
    }

    function searchTracking() {
      var searchQuery = document.getElementById("search").value.trim();

      if (!searchQuery) {
        showToast('warning', 'Masukkan nomor surat jalan');
        return;
      }

      fetch(`/search-travel-document?no_travel_document=${encodeURIComponent(searchQuery)}`)
        .then(response => response.json())
        .then(data => {
          if (data.success && data.locations && data.locations.length > 0) {
            updateMapWithLocations(data.locations);
          } else {
            showToast('error', 'Data tidak ditemukan');
          }
        })
        .catch(error => {
          console.error("Error:", error);
          showToast('error', 'Gagal mengambil data');
        });
    }

    function updateMapWithLocations(locations) {
      // Hapus semua marker dan polyline lama
      map.eachLayer(function (layer) {
        if (layer instanceof L.Marker || layer instanceof L.Polyline) {
          map.removeLayer(layer);
        }
      });

      const latLngs = locations.map(loc => [loc.latitude, loc.longitude]);
      const lastLocation = locations[locations.length - 1];
      const lastLatLng = [lastLocation.latitude, lastLocation.longitude];

      // Tambahkan marker terakhir
      L.marker(lastLatLng)
        .addTo(map)
        .bindPopup(`Lokasi: ${lastLocation.latitude}, ${lastLocation.longitude}`)
        .openPopup();

      // Jika ada lebih dari 1 titik, ambil rute dari OpenRouteService
      if (latLngs.length > 1) {
        const start = latLngs[0];
        const end = latLngs[latLngs.length - 1];
        const apiKey = '5b3ce3597851110001cf6248b4c0aaa51d204cea888ada05975d8638';

        fetch(`https://api.openrouteservice.org/v2/directions/driving-car?api_key=${apiKey}&start=${start[1]},${start[0]}&end=${end[1]},${end[0]}`)
          .then(response => response.json())
          .then(data => {
            if (data.features && data.features[0]) {
              const route = data.features[1].geometry.coordinates.map(coord => [coord[1], coord[0]]);
              L.polyline(route, { color: 'blue', weight: 4, opacity: 0.7 }).addTo(map);
              map.fitBounds(L.latLngBounds(route));
            }
          })
          .catch(err => {
            console.warn('Failed to fetch route, showing direct line:', err);
            // Fallback: buat garis langsung
            L.polyline(latLngs, { color: 'gray', weight: 2, dashArray: '5,5' }).addTo(map);
            map.fitBounds(L.latLngBounds(latLngs));
          });
      }

      map.setView(lastLatLng, 13);
    }
  </script>
@endpush
