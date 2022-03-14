<?php

namespace App\Exports;

use App\Models\Paket;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class PaketExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Paket::join('tb_outlet', 'tb_paket.outlet_id', '=', 'tb_outlet.id')
        ->select('tb_paket.id', 'tb_outlet.nama as nama_outlet', 'tb_paket.nama_paket', 'tb_paket.jenis', 'tb_paket.harga')
        ->where('tb_outlet.id', Auth::user()->outlet_id)
        ->get();
        $array = [];
        foreach($data as $key => $item) {
            array_push($array, [
                'no' => $key + 1,
                'nama_outlet' => $item->nama_outlet,
                'nama_paket' => $item->nama_paket,
                'jenis' => $item->jenis,
                'harga' => $item->harga,
            ]);
        }
        return collect($array);
    }

    public function headings(): array
    {
        return ['id', 'nama outlet', 'nama paket', 'jenis', 'harga'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                foreach(range('A','E') as $alphabet){
                    $event->sheet->getDelegate()->getColumnDimension($alphabet)->setAutoSize(true);
                    $event->sheet->getDelegate()->getStyle($alphabet)->getAlignment()->setHorizontal('center');
                }
                $event->sheet->getDelegate()->insertNewRowBefore(1, 1);
                $event->sheet->getDelegate()->insertNewRowBefore(2, 1);
                $event->sheet->getDelegate()->setCellValue('A1', 'Data Paket');
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->mergeCells("A1:E1");

                $cellRange = 'A1:E1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

                $event->sheet->getDelegate()->getStyle('A3:E'. $event->sheet->getDelegate()->getHighestDataRow())->applyFromArray([
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
