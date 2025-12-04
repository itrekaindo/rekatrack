<?php

namespace App\Exports;

use App\Models\TravelDocument;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class ShippingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = TravelDocument::with('items.unit')->orderBy('created_at', 'desc');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ]);
        } elseif ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        } elseif ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No SJN',
            'Tanggal SJN',
            'Kepada',
            'Nomor Referensi',
            'Nomor PO',
            'Proyek',
            'Status',
            'Kode Barang',
            'Nama Barang',
            'Qty Kirim',
            'Qty PO',
            'Total Kirim',
            'Satuan',
            'Deskripsi',
            'Keterangan'
        ];
    }

    public function map($travelDocument): array
    {
        $rows = [];

        if ($travelDocument->items->isEmpty()) {
            // Jika tidak ada item, tetap tampilkan dokumen utama
            $rows[] = [
                $travelDocument->no_travel_document,
                $travelDocument->date_no_travel_document?->format('Y-m-d') ?? '',
                $travelDocument->send_to,
                $travelDocument->reference_number,
                $travelDocument->po_number,
                $travelDocument->project,
                $travelDocument->status,
                '', '', '', '', '', '', '', ''
            ];
        } else {
            foreach ($travelDocument->items as $item) {
                $rows[] = [
                    $travelDocument->no_travel_document,
                    $travelDocument->date_no_travel_document? \Carbon\Carbon::parse($travelDocument->date_no_travel_document)->format('Y-m-d'): '',
                    $travelDocument->send_to,
                    $travelDocument->reference_number,
                    $travelDocument->po_number,
                    $travelDocument->project,
                    $travelDocument->status,
                    $item->item_code,
                    $item->item_name,
                    $item->qty_send,
                    $item->qty_po,
                    $item->total_send,
                    $item->unit?->name ?? '—',
                    $item->description,
                    $item->information ?? ''
                ];
            }
        }

        return $rows;
    }
}
