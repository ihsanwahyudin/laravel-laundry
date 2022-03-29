<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class BarangExport implements FromCollection, WithEvents, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Barang::select('nama_barang', 'qty', 'harga', 'waktu_beli', 'supplier', 'status_barang')->get();
        $array = [];
        foreach($data as $key => $item) {
            array_push($array, [
                'no' => $key + 1,
                'nama_barang' => $item->nama_barang,
                'qty' => $item->qty,
                'harga' => $item->harga,
                'waktu_beli' => $item->waktu_beli,
                'supplier' => $item->supplier,
                'status_barang' => $item->status_barang,
            ]);
        }
        // dd($array);
        return collect($array);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Barang',
            'QTY',
            'Harga',
            'Waktu Beli',
            'Supplier',
            'Status Barang',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                foreach(range('A','G') as $alphabet){
                    $event->sheet->getDelegate()->getColumnDimension($alphabet)->setAutoSize(true);
                    $event->sheet->getDelegate()->getStyle($alphabet)->getAlignment()->setHorizontal('center');
                }
                // set index for column
                $event->sheet->getDelegate()->insertNewRowBefore(1, 1);
                $event->sheet->getDelegate()->insertNewRowBefore(2, 1);
                $event->sheet->getDelegate()->setCellValue('A1', 'Data Barang');
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
