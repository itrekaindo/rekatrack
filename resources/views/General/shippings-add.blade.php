@extends('layouts.app')

@section('title', 'Tambah Pengiriman - RekaTrack')
@php($pageName = 'Tambah Data Pengiriman')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">Form Pengiriman Baru</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('shippings.store') }}" id="shippingForm">
          @csrf

          <!-- Nomor SJN di atas (prioritas utama) -->
          <div class="row mb-4">
            <div class="col-md-6">
              <label class="form-label">Nomor SJN <span class="text-danger">*</span></label>
              <input
                type="text"
                name="numberSJN"
                value="{{ old('numberSJN') }}"
                class="form-control form-control-lg"
                placeholder="Masukkan nomor surat jalan"
                required
              />
            </div>
          </div>

          <!-- Data Pengiriman Lain -->
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label">Kepada <span class="text-danger">*</span></label>
              <input
                type="text"
                name="sendTo"
                value="{{ old('sendTo') }}"
                class="form-control"
                placeholder="Nama penerima"
                required
              />
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor Ref <span class="text-danger">*</span></label>
              <input
                type="text"
                name="numberRef"
                value="{{ old('numberRef') }}"
                class="form-control"
                placeholder="Nomor referensi"
                required
              />
            </div>
            <div class="col-md-6">
              <label class="form-label">Proyek <span class="text-danger">*</span></label>
              <input
                type="text"
                name="projectName"
                value="{{ old('projectName') }}"
                class="form-control"
                placeholder="Nama proyek"
                required
              />
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor PO <span class="text-danger">*</span></label>
              <input
                type="text"
                name="poNumber"
                value="{{ old('poNumber') }}"
                class="form-control"
                placeholder="Nomor purchase order"
                required
              />
            </div>
          </div>

          <!-- Bagian Barang -->
          <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Data Barang</h5>
              <div class="d-flex align-items-center gap-2">
                <span class="text-muted">Total: <span id="totalBarang">1</span> item</span>
                <button type="button" class="btn btn-primary btn-sm" id="addItemBtn">
                  <i class="fas fa-plus me-1"></i> Tambah Barang
                </button>
              </div>
            </div>
            <div class="card-body">
              <div id="itemsContainer">
                @foreach ($items as $index => $item)
                  <div class="item-row mb-4 p-3 bg-light rounded">
                    <div class="row g-3">
                      <div class="col-md-3">
                        <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          name="itemName[]"
                          value="{{ old("itemName.$index", $item['itemName']) }}"
                          class="form-control"
                          placeholder="Contoh: Baut M10"
                          required
                        />
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          name="itemCode[]"
                          value="{{ old("itemCode.$index", $item['itemCode']) }}"
                          class="form-control"
                          placeholder="SKU/Part No"
                          required
                        />
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Satuan <span class="text-danger">*</span></label>
                        <select name="unitType[]" class="form-select" required>
                          <option value="">-- pilih --</option>
                          @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" {{ old("unitType.$index", $item['unitType']) == $unit->id ? 'selected' : '' }}>
                              {{ $unit->name }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-1">
                        <label class="form-label">Qty Kirim</label>
                        <input
                          type="number"
                          name="quantitySend[]"
                          value="{{ old("quantitySend.$index", $item['quantitySend']) }}"
                          class="form-control"
                          placeholder="0"
                        />
                      </div>
                      <div class="col-md-1">
                        <label class="form-label">Qty PO</label>
                        <input
                          type="number"
                          name="qtyPreOrder[]"
                          value="{{ old("qtyPreOrder.$index", $item['qtyPreOrder']) }}"
                          class="form-control"
                          placeholder="0"
                        />
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Total Kirim <span class="text-danger">*</span></label>
                        <input
                          type="number"
                          name="totalSend[]"
                          value="{{ old("totalSend.$index", $item['totalSend']) }}"
                          class="form-control"
                          placeholder="0"
                          required
                        />
                      </div>
                      <div class="col-md-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          name="description[]"
                          value="{{ old("description.$index", $item['description']) }}"
                          class="form-control"
                          placeholder="Spesifikasi barang"
                          required
                        />
                      </div>
                      <div class="col-md-3">
                        <label class="form-label">Keterangan</label>
                        <input
                          type="text"
                          name="information[]"
                          value="{{ old("information.$index", $item['information']) }}"
                          class="form-control"
                          placeholder="Opsional"
                        />
                      </div>
                      <div class="col-md-12 d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-item"
                          {{ count($items) <= 1 ? 'disabled' : '' }}>
                          <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          <!-- Aksi Bawah -->
          <div class="d-flex justify-content-between mt-4 pt-3 border-top">
            <a href="{{ route('shippings.index') }}" class="btn btn-light">
              <i class="fas fa-arrow-left me-1"></i> Batal
            </a>
            <button type="submit" class="btn btn-success btn-round">
              <i class="fas fa-save me-1"></i> Simpan Pengiriman
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('itemsContainer');
    const addItemBtn = document.getElementById('addItemBtn');
    let itemCount = {{ count($items) }};
    const units = @json($units);

    function getUnitOptions() {
      let html = '<option value="">-- pilih --</option>';
      units.forEach(unit => {
        html += `<option value="${unit.id}">${unit.name}</option>`;
      });
      return html;
    }

    function createNewItemRow() {
      return `
        <div class="item-row mb-4 p-3 bg-light rounded">
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
              <input type="text" name="itemName[]" class="form-control" placeholder="Contoh: Baut M10" required />
            </div>
            <div class="col-md-2">
              <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
              <input type="text" name="itemCode[]" class="form-control" placeholder="SKU/Part No" required />
            </div>
            <div class="col-md-2">
              <label class="form-label">Satuan <span class="text-danger">*</span></label>
              <select name="unitType[]" class="form-select" required>
                ${getUnitOptions()}
              </select>
            </div>
            <div class="col-md-1">
              <label class="form-label">Qty Kirim</label>
              <input type="number" name="quantitySend[]" class="form-control" placeholder="0" />
            </div>
            <div class="col-md-1">
              <label class="form-label">Qty PO</label>
              <input type="number" name="qtyPreOrder[]" class="form-control" placeholder="0" />
            </div>
            <div class="col-md-2">
              <label class="form-label">Total Kirim <span class="text-danger">*</span></label>
              <input type="number" name="totalSend[]" class="form-control" placeholder="0" required />
            </div>
            <div class="col-md-3">
              <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
              <input type="text" name="description[]" class="form-control" placeholder="Spesifikasi barang" required />
            </div>
            <div class="col-md-3">
              <label class="form-label">Keterangan</label>
              <input type="text" name="information[]" class="form-control" placeholder="Opsional" />
            </div>
            <div class="col-md-12 d-flex justify-content-end mt-2">
              <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                <i class="fas fa-trash me-1"></i> Hapus
              </button>
            </div>
          </div>
        </div>
      `;
    }

    function updateTotalBarang() {
      document.getElementById('totalBarang').textContent = container.querySelectorAll('.item-row').length;
    }

    addItemBtn.addEventListener('click', function () {
      if (itemCount >= 50) return;
      container.insertAdjacentHTML('beforeend', createNewItemRow());
      itemCount++;
      updateTotalBarang();
    });

    container.addEventListener('click', function (e) {
      if (e.target.closest('.remove-item')) {
        const row = e.target.closest('.item-row');
        if (container.querySelectorAll('.item-row').length > 1) {
          row.remove();
          updateTotalBarang();
        }
      }
    });

    updateTotalBarang();
  });
</script>
@endpush
