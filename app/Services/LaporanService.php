<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\LaporanRepositoryInterface;

class LaporanService
{
    private $laporanRepository;

    public function __construct(LaporanRepositoryInterface $laporanRepository)
    {
        $this->laporanRepository = $laporanRepository;
    }

    public function getLaporanTransaksi()
    {
        return $this->laporanRepository->getLaporanTransaksi();
    }

    public function getLaporanTransaksiPerOutlet()
    {
        return $this->laporanRepository->getLaporanTransaksiPerOutlet();
    }

    public function getLaporanTransaksiPerKaryawan()
    {
        return $this->laporanRepository->getLaporanTransaksiPerKaryawan();
    }

    public function getLaporanTransaksiPerMember()
    {
        return $this->laporanRepository->getLaporanTransaksiPerMember();
    }

    public function getLaporanTransaksiPerPaket()
    {
        return $this->laporanRepository->getLaporanTransaksiPerPaket();
    }

    public function getLaporanTransaksiPerBulan()
    {
        return $this->laporanRepository->getLaporanTransaksiPerBulan();
    }

    public function getLaporanTransaksiPerTahun()
    {
        return $this->laporanRepository->getLaporanTransaksiPerTahun();
    }

    public function getLaporanTransaksiPerBulanPerOutlet()
    {
        return $this->laporanRepository->getLaporanTransaksiPerBulanPerOutlet();
    }

    public function getLaporanTransaksiPerBulanPerKaryawan()
    {
        return $this->laporanRepository->getLaporanTransaksiPerBulanPerKaryawan();
    }

    public function getLaporanTransaksiPerBulanPerMember()
    {
        return $this->laporanRepository->getLaporanTransaksiPerBulanPerMember();
    }

    public function getLaporanTransaksiPerBulanPerPaket()
    {
        return $this->laporanRepository->getLaporanTransaksiPerBulanPerPaket();
    }

    public function getLaporanTransaksiPerTahunPerOutlet()
    {
        return $this->laporanRepository->getLaporanTransaksiPerTahunPerOutlet();
    }

    public function getLaporanTransaksiPerTahunPerKaryawan()
    {
        return $this->laporanRepository->getLaporanTransaksiPerTahunPerKaryawan();
    }

    public function getLaporanTransaksiPerTahunPerMember()
    {
        return $this->laporanRepository->getLaporanTransaksiPerTahunPerMember();
    }

    public function getLaporanTransaksiPerTahunPerPaket()
    {
        return $this->laporanRepository->getLaporanTransaksiPerTahunPerPaket();
    }
}
