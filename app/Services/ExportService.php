<?php

namespace App\Services;

use App\Exports\AbsensiExport;
use App\Exports\BarangExport;
use App\Exports\BarangInventarisExport;
use App\Exports\ExampleExport;
use App\Exports\MemberExport;
use App\Exports\OutletExport;
use App\Exports\PaketExport;
use App\Exports\PenjemputanExport;
use App\Exports\TransaksiExport;
use App\Exports\TransaksiExportByDate;
use App\Repositories\Interfaces\Eloquent\TransaksiRepositoryInterface;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
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

    public function exportExcelByDate($startDate, $endDate)
    {
        return Excel::download(new TransaksiExportByDate($startDate, $endDate), 'laporan-transaksi.xlsx');
    }

    public function exportExcelExample()
    {
        $path = public_path('json/genshin-achievement.json');

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);
        // dd(json_decode($file));

        // $response = Response::make($file, 200);
        // $response->header("Content-Type", $type);

        return Excel::download(new ExampleExport(json_decode($file)), 'genshin-achievement.xlsx');;
    }

    public function exportMemberExcel()
    {
        return Excel::download(new MemberExport,'member '.date('d-m-Y').'.xlsx');
    }

    public function exportOutletExcel()
    {
        return Excel::download(new OutletExport,'outlet '.date('d-m-Y').'.xlsx');
    }

    public function exportPaketExcel()
    {
        return Excel::download(new PaketExport,'paket '.date('d-m-Y').'.xlsx');
    }

    public function exportBarangInventarisExcel()
    {
        return Excel::download(new BarangInventarisExport,'barang inventaris '.date('d-m-Y').'.xlsx');
    }

    public function exportPenjemputanExcel()
    {
        return Excel::download(new PenjemputanExport,'penjemputan '.date('d-m-Y').'.xlsx');
    }

    public function exportBarangExcel()
    {
        return Excel::download(new BarangExport,'barang '.date('d-m-Y').'.xlsx');
    }

    public function exportAbsensiExcel()
    {
        return Excel::download(new AbsensiExport,'absensi karyawan '.date('d-m-Y').'.xlsx');
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

    public function exportPDFByDate($startDate, $endDate)
    {
        $data = $this->transaksiRepository->filterTransactionDataByDate($startDate, $endDate);
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
        return View::make('export.faktur-transaksi', compact('data'))->render();
    }

    private function xml($data)
    {
        return View::make('export.laporan-transaksi', compact('data'))->render();
    }
}
