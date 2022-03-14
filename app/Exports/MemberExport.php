<?php

namespace App\Exports;

use App\Models\Member;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class MemberExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Member::select('id', 'nama', 'alamat', 'jenis_kelamin', 'tlp')->get();
        return new Collection($data);
    }

    public function headings(): array
    {
        return ['id', 'nama', 'alamat', 'jenis_kelamin', 'tlp'];
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
                $event->sheet->getDelegate()->setCellValue('A1', 'Data Member');
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
