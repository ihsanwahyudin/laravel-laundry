<?php

namespace App\Services;

use App\Exports\TransaksiExport;
use App\Repositories\Interfaces\Eloquent\TransaksiRepositoryInterface;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;

class ExportService
{
    private $transaksiRepository;

    public function __construct(TransaksiRepositoryInterface $transaksiRepository)
    {
        $this->transaksiRepository = $transaksiRepository;
    }

    public function exportExcel()
    {
        return Excel::download(new TransaksiExport, 'laporan-transaksi.xlsx');
    }

    public function exportPDF()
    {
        $data = $this->transaksiRepository->getAllTransactionData();
        $xml = $this->xml($data);
        $dompdf = new Dompdf();
        $dompdf->getOptions()->set('chroot', asset('images'));
        $dompdf->getOptions()->getChroot();
        $dompdf->loadHtml($xml);
        $dompdf->render();
        return $dompdf->stream("document.pdf", array("Attachment" => false));
    }

    private function xml($data)
    {
        $title = 'Laporan Transaksi';

        $thead = '<thead>';
        $thead .= '<tr>
            <th>No</th>
            <th>Kode Invoice</th>
            <th>Nama Member</th>
            <th>Tanggal Bayar</th>
            <th>Batas Waktu</th>
            <th>Metode Pembayaran</th>
            <th>Status Transaksi</th>
            <th>Status Pembayaran</th>
        </tr>';
        $thead .= '</thead>';

        $tbody = `<tbody>`;
        foreach($data as $key => $item) {
            $tbody .= '<tr>
                <td>'.($key + 1).'</td>
                <td>'.$item->kode_invoice.'</td>
                <td>'.$item->member->nama.'</td>
                <td>'.$item->tgl_bayar.'</td>
                <td>'.$item->batas_waktu.'</td>
                <td>'.$item->metode_pembayaran.'</td>
                <td>'.$item->status_transaksi.'</td>
                <td>'.$item->status_pembayaran.'</td>
            </tr>';
        }
        $tbody .= `</tbody>`;

        return
        <<<HTML
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8" />
                <title>$title</title>

                <style type="text/css">
                    * {
                        font-family: Verdana, Arial, sans-serif;
                    }
                    table {
                        font-size: x-small;
                    }
                    thead {
                        background: #202020;
                        color: #FFFFFF;
                        text-align: left;
                    }
                    tfoot tr td {
                        font-weight: bold;
                        font-size: x-small;
                    }
                    .gray {
                        background-color: lightgray;
                    }
                    h3 {
                        text-transform: uppercase;
                    }
                    .text-uppercase {
                        text-transform: uppercase;
                    }
                </style>
            </head>
            <body>
                <h3 align="center">$title</h3>

                <br/>
                <br/>
                <h5 class="text-uppercase" style="margin: 0" align="left">Data $title</h5>
                <table width="100%" cellpadding="5" cellspacing="0">
                    $thead
                    $tbody
                </table>
            </body>
        </html>
        HTML;
        // <h5 align="center">
        //             <br>
        //             <small style="font-weight: normal">Tanggal: $from s/d $to</small>
        //         </h5>
        //         $tfoot
    }
}
