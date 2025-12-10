<?php $__env->startSection('title', 'Detail Pengiriman - RekaTrack'); ?>
<?php ($pageName = 'Detail Pengiriman ' . ($travelDocument->no_travel_document ?? '')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <!-- Informasi Utama -->
  <div class="col-md-8">
    <div class="card card-full-height">
      <div class="card-header">
        <h4 class="card-title">Detail Pengiriman</h4>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <!-- Kolom Kiri: Informasi Utama -->
          <div class="col-sm-6">
            <div class="mb-3">
              <p class="text-muted mb-1">Kepada</p>
              <h5><?php echo e($travelDocument->send_to ?? '-'); ?></h5>
            </div>
            <div class="mb-3">
              <p class="text-muted mb-1">Proyek</p>
              <h5><?php echo e($travelDocument->project ?? '-'); ?></h5>
            </div>
            <div class="mb-3">
              <p class="text-muted mb-1">Tanggal SJN</p>
              <h5>
                <?php if($travelDocument->date_no_travel_document): ?>
                  <?php echo e(\Carbon\Carbon::parse($travelDocument->date_no_travel_document)->format('d/m/Y')); ?>

                <?php else: ?>
                  -
                <?php endif; ?>
              </h5>
            </div>
          </div>

          <!-- Kolom Kanan: Waktu Mulai & Selesai Kirim -->
          <div class="col-sm-6 d-flex flex-column justify-content-between">
            <!-- Waktu Mulai Kirim -->
            <div class="mb-3">
              <p class="text-muted mb-1">Waktu Mulai Kirim</p>
              <h5>
                <?php if($travelDocument->start_time): ?>
                  <?php echo e(\Carbon\Carbon::parse($travelDocument->start_time)->format('d/m/Y H:i')); ?>

                <?php else: ?>
                  <span class="text-muted">-</span>
                <?php endif; ?>
              </h5>
            </div>

            <!-- Waktu Selesai Kirim -->
            <div class="mb-0">
              <p class="text-muted mb-1">Waktu Selesai Kirim</p>
              <h5>
                <?php if($travelDocument->end_time): ?>
                  <?php echo e(\Carbon\Carbon::parse($travelDocument->end_time)->format('d/m/Y H:i')); ?>

                <?php else: ?>
                  <span class="text-muted">-</span>
                <?php endif; ?>
              </h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Referensi & Status -->
  <div class="col-md-4">
    <div class="card card-full-height">
      <div class="card-header">
        <h4 class="card-title">Referensi</h4>
      </div>
      <div class="card-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Nomor SJN</span>
            <strong><?php echo e($travelDocument->no_travel_document ?? '-'); ?></strong>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>PO</span>
            <strong><?php echo e($travelDocument->po_number ?? '-'); ?></strong>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Ref</span>
            <strong><?php echo e($travelDocument->reference_number ?? '-'); ?></strong>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Status</span>
            <?php if($travelDocument->status == 'Belum terkirim'): ?>
              <span class="badge badge-warning">Belum terkirim</span>
            <?php elseif($travelDocument->status == 'Sedang dikirim'): ?>
              <span class="badge badge-info">Sedang dikirim</span>
            <?php elseif($travelDocument->status == 'Terkirim'): ?>
              <span class="badge badge-success">Terkirim</span>
            <?php else: ?>
              <span class="badge badge-secondary">-</span>
            <?php endif; ?>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Tabel Barang -->
<div class="row mt-4">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Daftar Barang</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Nama Barang</th>
                <th>Kode Barang</th>
                <th class="text-end">QTY Kirim</th>
                <th class="text-end">QTY PO</th>
                <th class="text-end">Total Kirim</th>
                <th>Satuan</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $travelDocument->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                  <td><?php echo e($index + 1); ?></td>
                  <td><?php echo e($item->item_name); ?></td>
                  <td><?php echo e($item->item_code); ?></td>
                  <td class="text-end"><?php echo e($item->qty_send ?? '-'); ?></td>
                  <td class="text-end"><?php echo e($item->qty_po ?? '-'); ?></td>
                  <td class="text-end"><?php echo e($item->total_send ?? '-'); ?></td>
                  <td><?php echo e($item->unit->name ?? '-'); ?></td>
                  <td><?php echo e($item->information ?? '-'); ?></td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                  <td colspan="8" class="text-center py-4 text-muted">
                    <i class="fas fa-box-open fs-2 d-block mb-2"></i>
                    Tidak ada barang
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Aksi Bawah -->
<div class="row mt-4">
  <div class="col-md-12 d-flex justify-content-end gap-2">
    <a href="<?php echo e(route('shippings.edit', $travelDocument->id)); ?>" class="btn btn-secondary btn-round">
      <i class="fas fa-edit me-1"></i> Edit
    </a>
    <form action="<?php echo e(route('shippings.print', $travelDocument->id)); ?>" method="GET" class="d-inline">
      <?php echo csrf_field(); ?>
      <button type="submit" class="btn btn-primary btn-round">
        <i class="fas fa-print me-1"></i> Cetak Surat Jalan
      </button>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/server/Reka/current-rekatrack/current/resources/views/General/shippings-detail.blade.php ENDPATH**/ ?>