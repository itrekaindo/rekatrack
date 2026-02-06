<?php $__env->startSection('title', 'Laporan Bukti Pengiriman - Rekatrack'); ?>
<?php ($pageName = 'Bukti Pengiriman ' . ($travelDocument->no_travel_document ?? '')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <!-- Header Card with Document Info -->
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-md-8">
            <div class="d-flex align-items-center">
              <div class="me-3">
                <div class="avatar avatar-online">
                  <span class="avatar-title rounded-circle border border-white bg-success">
                    <i class="fa fa-check-circle"></i>
                  </span>
                </div>
              </div>
              <div>
                <h4 class="fw-bold mb-1"><?php echo e($travelDocument->no_travel_document ?? '-'); ?></h4>
                <p class="text-muted mb-0">Bukti Pengiriman</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 text-end">
            <span class="badge badge-success badge-lg">
              <i class="fa fa-check me-1"></i> <?php echo e($travelDocument->status ?? '-'); ?>

            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Document Information - Left -->
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          <i class="fa fa-file-alt me-2"></i> Informasi Dokumen
        </div>
      </div>
      <div class="card-body">
        <!-- No Surat Jalan -->
        <div class="mb-3">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="fa fa-file-invoice fa-2x text-primary"></i>
            </div>
            <div class="flex-fill">
              <p class="text-muted mb-1">No Surat Jalan</p>
              <h5 class="fw-bold mb-0"><?php echo e($travelDocument->no_travel_document ?? '-'); ?></h5>
            </div>
          </div>
        </div>

        <hr>

        <!-- Tanggal SJN -->
        <div class="mb-3">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="fa fa-calendar-alt fa-2x text-info"></i>
            </div>
            <div class="flex-fill">
              <p class="text-muted mb-1">Tanggal SJN</p>
              <h5 class="fw-bold mb-0">
                <?php if($travelDocument->posting_date): ?>
                  <?php echo e(\Carbon\Carbon::parse($travelDocument->posting_date)
                    ->locale('id')
                    ->translatedFormat('d F Y')); ?>

                <?php else: ?>
                  -
                <?php endif; ?>
              </h5>
            </div>
          </div>
        </div>

        <hr>

        <!-- Tujuan -->
        <div class="mb-3">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="fa fa-map-marker-alt fa-2x text-danger"></i>
            </div>
            <div class="flex-fill">
              <p class="text-muted mb-1">Tujuan</p>
              <h5 class="fw-bold mb-0"><?php echo e($travelDocument->send_to ?? '-'); ?></h5>
            </div>
          </div>
        </div>

        <hr>

        <!-- Proyek -->
        <div>
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="fa fa-project-diagram fa-2x text-success"></i>
            </div>
            <div class="flex-fill">
              <p class="text-muted mb-1">Proyek</p>
              <h5 class="fw-bold mb-0"><?php echo e($travelDocument->project ?? '-'); ?></h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Reception Information - Right -->
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          <i class="fa fa-user-check me-2"></i> Informasi Penerimaan
        </div>
      </div>
      <div class="card-body">
        <!-- Nama Penerima -->
        <div class="mb-3">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="fa fa-user fa-2x text-primary"></i>
            </div>
            <div class="flex-fill">
              <p class="text-muted mb-1">Nama Penerima</p>
              <h5 class="fw-bold mb-0"><?php echo e($confirmation->receiver_name ?? '-'); ?></h5>
            </div>
          </div>
        </div>

        <hr>

        <!-- Waktu Diterima -->
        <div class="mb-3">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="fa fa-clock fa-2x text-success"></i>
            </div>
            <div class="flex-fill">
              <p class="text-muted mb-1">Waktu Diterima</p>
              <h5 class="fw-bold mb-0"><?php echo e($confirmation->received_at ?? '-'); ?></h5>
            </div>
          </div>
        </div>

        <hr>

        <!-- Waktu Mulai Pengiriman -->
        <div>
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="fa fa-play-circle fa-2x text-info"></i>
            </div>
            <div class="flex-fill">
              <p class="text-muted mb-1">Waktu Mulai Pengiriman</p>
              <h5 class="fw-bold mb-0"><?php echo e($startTime ?? '-'); ?></h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Photo and Notes Section -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          <i class="fa fa-camera me-2"></i> Bukti & Catatan
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Bukti Foto -->
          <div class="col-md-6">
            <div class="mb-3">
              <p class="text-muted mb-2 fw-bold">Bukti Foto Pengiriman</p>
              <div class="text-center p-3 border rounded bg-light">
                <?php if(!empty($confirmation->photo_path)): ?>
                  <img src="<?php echo e(asset('storage/'.$confirmation->photo_path)); ?>"
                       class="img-fluid rounded shadow-sm"
                       style="max-width: 100%; max-height: 400px; object-fit: contain;"
                       alt="Bukti Pengiriman">
                <?php else: ?>
                  <div class="py-5">
                    <i class="fa fa-image fa-3x text-muted mb-3 d-block opacity-50"></i>
                    <p class="text-muted mb-0">Tidak ada foto</p>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Catatan -->
          <div class="col-md-6">
            <div class="mb-3">
              <p class="text-muted mb-2 fw-bold">Catatan Penerima</p>
              <div class="p-3 border rounded bg-light" style="min-height: 200px;">
                <?php if(!empty($confirmation->note)): ?>
                  <div class="d-flex">
                    <div class="me-2">
                      <i class="fa fa-sticky-note text-warning"></i>
                    </div>
                    <div class="flex-fill">
                      <p class="mb-0"><?php echo e($confirmation->note); ?></p>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="text-center py-5">
                    <i class="fa fa-comment-slash fa-3x text-muted mb-3 d-block opacity-50"></i>
                    <p class="text-muted mb-0">Tidak ada catatan</p>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Action Buttons -->
<div class="row">
  <div class="col-12">
    
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <a href="<?php echo e(route('shippings.detail', $travelDocument->id)); ?>" class="btn btn-light btn-round">
              <i class="fa fa-arrow-left me-1"></i> Kembali ke Detail
            </a>
          </div>
          <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary btn-round">
              <i class="fa fa-print me-1"></i> Cetak Bukti
            </button>
            <a href="<?php echo e(route('shippings.index')); ?>" class="btn btn-secondary btn-round">
              <i class="fa fa-list me-1"></i> Daftar Pengiriman
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.badge-lg {
  padding: 8px 16px;
  font-size: 14px;
}

@media print {
  .btn, .card:last-child {
    display: none !important;
  }

  .card {
    box-shadow: none !important;
    border: 1px solid #dee2e6 !important;
  }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/server/Reka/current-rekatrack/current/resources/views/General/shippings-report.blade.php ENDPATH**/ ?>