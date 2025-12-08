<?php $__env->startSection('title', 'Tracking Pengiriman - RekaTrack'); ?>
<?php ($pageName = 'Tracking Pengiriman'); ?>

<?php $__env->startSection('content'); ?>
    <!-- === Statistik: Sesuai Gaya Kaiadmin === -->
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Sedang Dikirim</p>
                                <h4 class="card-title"><?php echo e($totalActive); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Terkirim</p>
                                <h4 class="card-title"><?php echo e($totalDelivered); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- === Pencarian Manual === -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Cari Pengiriman</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input
                                    type="text"
                                    id="search"
                                    class="form-control"
                                    placeholder="Cari berdasarkan Nomor Surat Jalan..."
                                />
                                <button onclick="searchTracking()" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- === Pengiriman Aktif === -->
    <?php if($activeShippings->isNotEmpty()): ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Pengiriman Aktif</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor SJN</th>
                                        <th>Kepada</th>
                                        <th>Proyek</th>
                                        <th>Tanggal</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $activeShippings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr style="cursor: pointer;" onclick="loadTracking('<?php echo e($shipping->no_travel_document); ?>')">
                                            <td class="text-primary fw-bold"><?php echo e($shipping->no_travel_document); ?></td>
                                            <td>
                                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                <?php echo e($shipping->send_to ?: '-'); ?>

                                            </td>
                                            <td><?php echo e($shipping->project ?: '-'); ?></td>
                                            <td>
                                                <?php if($shipping->date_no_travel_document): ?>
                                                    <?php echo e(\Carbon\Carbon::parse($shipping->date_no_travel_document)->format('d/m/Y')); ?>

                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-info">Sedang dikirim</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- === Pengiriman Terkirim === -->
    <?php if($deliveredShippings->isNotEmpty()): ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Pengiriman Terkirim</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor SJN</th>
                                        <th>Kepada</th>
                                        <th>Proyek</th>
                                        <th>Tanggal</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $deliveredShippings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr style="cursor: pointer;" onclick="loadTracking('<?php echo e($shipping->no_travel_document); ?>')">
                                            <td class="text-primary fw-bold"><?php echo e($shipping->no_travel_document); ?></td>
                                            <td>
                                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                <?php echo e($shipping->send_to ?: '-'); ?>

                                            </td>
                                            <td><?php echo e($shipping->project ?: '-'); ?></td>
                                            <td>
                                                <?php if($shipping->date_no_travel_document): ?>
                                                    <?php echo e(\Carbon\Carbon::parse($shipping->date_no_travel_document)->format('d/m/Y')); ?>

                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-success">Terkirim</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- === Peta === -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-0" style="height: 700px; position: relative;">
                    <div id="map" class="w-100 h-100"></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 100%; width: 100%; border-radius: 0.5rem; }
        .geocode-popup {
            min-width: 200px;
            text-align: center;
            padding: 8px !important;
        }
        table tr:hover {
            background-color: #f8f9fa !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        const map = L.map("map").setView([-2.5489, 118.0132], 5);
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        function loadTracking(sjn) {
            fetch(`<?php echo e(route('tracking.search')); ?>?no_travel_document=${encodeURIComponent(sjn)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.locations?.length > 0) {
                        updateMapWithLocations(data.locations);
                    } else {
                        showAlert('error', data.message || 'Tidak ada data lokasi');
                    }
                })
                .catch(err => {
                    console.error(err);
                    showAlert('error', 'Gagal memuat data tracking');
                });
        }

        function searchTracking() {
            const query = document.getElementById("search")?.value?.trim();
            if (!query) {
                showAlert('warning', 'Masukkan nomor surat jalan');
                return;
            }
            loadTracking(query);
        }

        async function updateMapWithLocations(locations) {
            map.eachLayer(layer => {
                if (!(layer instanceof L.TileLayer)) map.removeLayer(layer);
            });

            const latLngs = locations.map(loc => [loc.latitude, loc.longitude]);
            const firstLoc = latLngs[0];
            const lastLoc = latLngs[latLngs.length - 1];

            // Titik Awal
            const startMarker = L.marker(firstLoc, {
                icon: L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41]
                })
            }).addTo(map);
            showLoadingPopup(startMarker, 'Memuat lokasi awal...');

            // Titik Akhir
            const endMarker = L.marker(lastLoc).addTo(map);
            showLoadingPopup(endMarker, 'Memuat lokasi akhir...');

            const startAddress = await getReverseGeocode(firstLoc[0], firstLoc[1]);
            const endAddress = await getReverseGeocode(lastLoc[0], lastLoc[1]);

            startMarker.setPopupContent(`
                <div class="geocode-popup">
                    <strong>📍 Titik Awal</strong><br>
                    <small>${startAddress}</small>
                </div>
            `);

            endMarker.setPopupContent(`
                <div class="geocode-popup">
                    <strong>🏁 Lokasi Terakhir</strong><br>
                    <small>${endAddress}</small>
                </div>
            `).openPopup();

            // Checkpoint
            if (latLngs.length > 2) {
                for (let i = 1; i < latLngs.length - 1; i++) {
                    L.marker(latLngs[i], {
                        icon: L.divIcon({
                            html: `<div style="background:#1572e8;width:10px;height:10px;border-radius:50%;border:2px solid white;"></div>`,
                            iconSize: [10, 10],
                            iconAnchor: [5, 5]
                        })
                    }).addTo(map).bindPopup(`Checkpoint ${i}`);
                }
            }

            // Rute
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            try {
                const response = await fetch('<?php echo e(route("tracking.route")); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ start: firstLoc, end: lastLoc })
                });
                const data = await response.json();

                if (data.features?.[0]?.geometry?.coordinates) {
                    const route = data.features[0].geometry.coordinates.map(c => [c[1], c[0]]);
                    L.polyline(route, { color: '#1572e8', weight: 4, opacity: 0.7 }).addTo(map);
                    map.fitBounds(L.latLngBounds(route), { padding: [50, 50] });
                } else {
                    L.polyline(latLngs, { color: '#6c757d', weight: 2, dashArray: '5,5' }).addTo(map);
                    map.fitBounds(L.latLngBounds(latLngs), { padding: [50, 50] });
                }
            } catch (err) {
                L.polyline(latLngs, { color: '#6c757d', weight: 2, dashArray: '5,5' }).addTo(map);
                map.fitBounds(L.latLngBounds(latLngs), { padding: [50, 50] });
            }
        }

        async function getReverseGeocode(lat, lng) {
            try {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1&accept-language=id`
                );
                const data = await response.json();
                if (data.display_name) {
                    let addr = data.display_name;
                    if (addr.length > 70) addr = addr.substring(0, 70) + '...';
                    return addr;
                }
                return "Alamat tidak ditemukan";
            } catch (error) {
                console.error("Geocode error:", error);
                return "Alamat tidak tersedia";
            }
        }

        function showLoadingPopup(marker, text = "Memuat...") {
            marker.bindPopup(`
                <div class="geocode-popup">
                    <i class="fas fa-spinner fa-spin me-1"></i> ${text}
                </div>
            `);
        }

        function showAlert(type, message) {
            if (window.$.notify) {
                $.notify({ message }, { type, placement: { from: 'top', align: 'right' }, time: 4000 });
            } else {
                alert(message);
            }
        }

        document.getElementById('search')?.addEventListener('keypress', e => {
            if (e.key === 'Enter') searchTracking();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/server/Reka/current-rekatrack/current/resources/views/General/tracker.blade.php ENDPATH**/ ?>