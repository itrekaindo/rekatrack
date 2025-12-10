@extends('layouts.app')

@section('title', 'Detail Pengiriman - RekaTrack')
@php($pageName = 'Detail Pengiriman ' . ($travelDocument->no_travel_document ?? ''))

@section('content')
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
              <h5>{{ $travelDocument->send_to ?? '-' }}</h5>
            </div>
            <div class="mb-3">
              <p class="text-muted mb-1">Proyek</p>
              <h5>{{ $travelDocument->project ?? '-' }}</h5>
            </div>
            <div class="mb-3">
              <p class="text-muted mb-1">Tanggal SJN</p>
              <h5>
                @if($travelDocument->date_no_travel_document)
                  {{ \Carbon\Carbon::parse($travelDocument->date_no_travel_document)->format('d/m/Y') }}
                @else
                  -
                @endif
              </h5>
            </div>
          </div>

          <!-- Kolom Kanan: Waktu Mulai & Selesai Kirim -->
          <div class="col-sm-6 d-flex flex-column justify-content-between">
            <!-- Waktu Mulai Kirim -->
            <div class="mb-3">
              <p class="text-muted mb-1">Waktu Mulai Kirim</p>
              <h5>
                @if($travelDocument->start_time)
                  {{ \Carbon\Carbon::parse($travelDocument->start_time)->format('d/m/Y H:i') }}
                @else
                  <span class="text-muted">-</span>
                @endif
              </h5>
            </div>

            <!-- Waktu Selesai Kirim -->
            <div class="mb-0">
              <p class="text-muted mb-1">Waktu Selesai Kirim</p>
              <h5>
                @if($travelDocument->end_time)
                  {{ \Carbon\Carbon::parse($travelDocument->end_time)->format('d/m/Y H:i') }}
                @else
                  <span class="text-muted">-</span>
                @endif
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
            <strong>{{ $travelDocument->no_travel_document ?? '-' }}</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>PO</span>
            <strong>{{ $travelDocument->po_number ?? '-' }}</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Ref</span>
            <strong>{{ $travelDocument->reference_number ?? '-' }}</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Status</span>
            @if($travelDocument->status == 'Belum terkirim')
              <span class="badge badge-warning">Belum terkirim</span>
            @elseif($travelDocument->status == 'Sedang dikirim')
              <span class="badge badge-info">Sedang dikirim</span>
            @elseif($travelDocument->status == 'Terkirim')
              <span class="badge badge-success">Terkirim</span>
            @else
              <span class="badge badge-secondary">-</span>
            @endif
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
              @forelse($travelDocument->items as $index => $item)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $item->item_name }}</td>
                  <td>{{ $item->item_code }}</td>
                  <td class="text-end">{{ $item->qty_send ?? '-' }}</td>
                  <td class="text-end">{{ $item->qty_po ?? '-' }}</td>
                  <td class="text-end">{{ $item->total_send ?? '-' }}</td>
                  <td>{{ $item->unit->name ?? '-' }}</td>
                  <td>{{ $item->information ?? '-' }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center py-4 text-muted">
                    <i class="fas fa-box-open fs-2 d-block mb-2"></i>
                    Tidak ada barang
                  </td>
                </tr>
              @endforelse
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
    <a href="{{ route('shippings.edit', $travelDocument->id) }}" class="btn btn-secondary btn-round">
      <i class="fas fa-edit me-1"></i> Edit
    </a>
    <form action="{{ route('shippings.print', $travelDocument->id) }}" method="GET" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-primary btn-round">
        <i class="fas fa-print me-1"></i> Cetak Surat Jalan
      </button>
    </form>
  </div>
</div>
@endsection
