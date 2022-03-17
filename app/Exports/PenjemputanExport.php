<?php

namespace App\Exports;

use App\Models\Penjemputan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class PenjemputanExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Penjemputan::with(['transaksi' => function($q) {
            $q->with(['member', 'user', 'detailTransaksi' => function($q) {
                $q->with('paket');
            }]);
        }])->get();
        $array = [];
        foreach($data as $key => $item) {
            array_push($array, [
                'no' => $key + 1,
                'transaksi_id' => $item->transaksi_id,
                'nama_pelanggan' => $item->transaksi->member->nama,
                'alamat_pelanggan' => $item->transaksi->member->alamat,
                'telp_pelanggan' => $item->transaksi->member->tlp,
                'petugas_penjemput' => $item->petugas_penjemput,
                'status' => $item->status,
            ]);
        }
        return collect($array);
    }

    public function headings(): array
    {
        return ['No', 'Transaksi ID', 'Nama Pelanggan', 'Alamat Pelanggan', 'Telp Pelanggan', 'Petugas Penjemput', 'status'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                foreach(range('A','G') as $alphabet){
                    $event->sheet->getDelegate()->getColumnDimension($alphabet)->setAutoSize(true);
                    $event->sheet->getDelegate()->getStyle($alphabet)->getAlignment()->setHorizontal('center');
                }
                $event->sheet->getDelegate()->insertNewRowBefore(1, 1);
                $event->sheet->getDelegate()->insertNewRowBefore(2, 1);
                $event->sheet->getDelegate()->setCellValue('A1', 'Data Penjemputan');
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->mergeCells("A1:G1");

                $cellRange = 'A1:G1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

                $event->sheet->getDelegate()->getStyle('A3:G'. $event->sheet->getDelegate()->getHighestDataRow())->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
