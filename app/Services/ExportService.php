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

    public function cetakFaktur($noInvoice)
    {
        $data = $this->transaksiRepository->findTransaksiByInvoice($noInvoice);
        $data === null ? abort(404) : $data;
        $xml = $this->fakturXML($data);
        $dompdf = new Dompdf();
        $dompdf->getOptions()->set('chroot', asset('images'));
        $dompdf->getOptions()->getChroot();
        $dompdf->loadHtml($xml);
        $dompdf->render();
        return $dompdf->stream("document.pdf", array("Attachment" => false));
    }

    private function fakturXML($data)
    {
        $title = 'Faktur Pembayaran';
        $statusTransaksi = $data['status_transaksi'];
        $statusPembayaran = $data['status_pembayaran'];
        $metodePembayaran = $data['metode_pembayaran'];
        $noInvoice = $data['kode_invoice'];
        $namaMember = $data['member']['nama'];
        $tlp = $data['member']['tlp'];
        $tglBayar = $data['tgl_bayar'];
        $batasWaktu = $data['batas_waktu'];
        $biayaTambahan = number_format($data['pembayaran']['biaya_tambahan'], 0, ',', '.');
        $diskon = $data['pembayaran']['diskon'];
        $pajak = $data['pembayaran']['pajak'];
        $totalPembayaran = number_format($data['pembayaran']['total_pembayaran'], 0, ',', '.');
        $totalBayar = number_format($data['pembayaran']['total_bayar'], 0, ',', '.');
        $kembalian = number_format($data['pembayaran']['total_pembayaran'] - $data['pembayaran']['total_bayar'], 0, ',', '.');

        $tbody = '';
        foreach($data['detailTransaksi'] as $key => $item) {
            $tbody .= '<tr>
                            <td>'.($key+1).'</td>
                            <td>'.$item['paket']['nama_paket'].'</td>
                            <td>'.$item['paket']['jenis'].'</td>
                            <td>Rp '.number_format($item['harga'], 0, ',', '.').'</td>
                            <td>'.$item['qty'].'x</td>
                            <td align="left">Rp '.number_format($item['harga'] * $item['qty'], 0, ',', '.').'</td>
                        </tr>';
        }

        $tfoot = '';

        if($data['status_pembayaran'] === 'lunas') {
            $tfoot .= '<tr>
                            <td colspan="5" align="right">Biaya Tambahan</td>
                            <td align="left">Rp '.$biayaTambahan.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right">Diskon</td>
                            <td align="left">'.$diskon.'%</td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right">Pajak</td>
                            <td align="left">'.$pajak.'%</td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right">Total Pembayaran</td>
                            <td align="left">Rp '.$totalPembayaran.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right">Total Bayar</td>
                            <td align="left">Rp '.$totalBayar.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right">Kembalian</td>
                            <td align="left">Rp '.abs($kembalian).'</td>
                        </tr>';
        } else {
            $tfoot .= '<tr>
                            <th colspan="6" align="center">Pembayaran Belum Lunas</th>
                        </tr>';
        }

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
                    .content-header tr, .content-header td {
                        margin: 0;
                        padding-top: 0;
                        padding-bottom: 0;
                    }
                    thead {
                        background: #202020;
                        color: #FFFFFF;
                        text-align: left;
                    }
                    tfoot tr td {
                        /* font-weight: bold; */
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
                    .mp-0 {
                        margin: 0;
                        padding: 0;
                    }
                    .px-1 {
                        padding-right: .5rem !important;
                        padding-left: .5rem !important;
                    }
                </style>
            </head>
            <body>
                <h3 align="center">$title</h3>
                <br/>
                <table class="content-header" width="100%" cellpadding="5" cellspacing="0">
                    <tr>
                        <td width="50%">
                            <table class="content-header" cellpadding="5" cellspacing="0">
                                <tr>
                                    <td>Status Transaksi</td>
                                    <td class="px-1">:</td>
                                    <td>$statusTransaksi</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td class="px-1">:</td>
                                    <td>$statusPembayaran</td>
                                </tr>
                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td class="px-1">:</td>
                                    <td>$metodePembayaran</td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table class="content-header" cellpadding="5" cellspacing="0">
                                <tr>
                                    <td>No Invoice</td>
                                    <td class="px-1">:</td>
                                    <td>$noInvoice</td>
                                </tr>
                                <tr>
                                    <td>Nama Member</td>
                                    <td class="px-1">:</td>
                                    <td>$namaMember</td>
                                </tr>
                                <tr>
                                    <td>No Telepon</td>
                                    <td class="px-1">:</td>
                                    <td>$tlp</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br/>
                <div style="width: 100%; background: #202020; padding-top: .5rem; padding-bottom: .5rem; text-align: center; color: white">
                    <small style="display: block">Tanggal Bayar - Tanggal Selesai</small>
                    <small><strong class="mp-0">$tglBayar sd $batasWaktu</strong></small>
                </div>
                <br/>
                <h5 class="text-uppercase" style="margin: 0" align="left">Data Paket</h5>
                <table width="100%" cellpadding="5" cellspacing="0" class="mp-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Paket</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th>QTY</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        $tbody
                    </tbody>
                    <tfoot>
                        $tfoot
                    </tfoot>
                </table>
            </body>
        </html>
        HTML;
    }

    private function xml($data)
    {
        $title = 'Laporan Transaksi';

        $thead = '<thead>';
        $thead .= '<tr>
            <th>No</th>
            <th>Kode Invoice</th>
            <th>Nama Member</th>
            <th>Tanggal Transaksi</th>
            <th>Status Pembayaran</th>
            <th>Pemasukan</th>
        </tr>';
        $thead .= '</thead>';

        $tbody = `<tbody>`;
        $totalPemasukan = 0;
        foreach($data as $key => $item) {
            $totalPemasukan += $item->pembayaran->total_pembayaran;
            $tbody .= '<tr>
                <td align="center">'.($key + 1).'</td>
                <td>'.$item->kode_invoice.'</td>
                <td>'.$item->member->nama.'</td>
                <td>'.date('d F Y', strtotime($item->created_at)).'</td>
                <td>'.$item->status_pembayaran.'</td>
                <td>Rp '.($item->status_pembayaran === 'lunas' ? number_format($item->pembayaran->total_pembayaran, 0, ',', '.') : 0).'</td>
            </tr>';
        }
        $tbody .= `</tbody>`;
        $totalPemasukan = number_format($totalPemasukan, 0, ',', '.');

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
                    <tfoot style="border-top: 1px solid black">
                        <tr>
                            <th colspan="5">Total Pemasukan</th>
                            <th align="left">Rp $totalPemasukan</th>
                        </tr>
                    </tfoot>
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
