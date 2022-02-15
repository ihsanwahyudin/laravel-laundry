<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\LaporanRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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

    public function getLaporanTransaksiBetweenDate($startDate, $endDate)
    {
        // $startDate = date('Y-m-d h:i:s', strtotime($startDate . ' 00:00:00'));
        // $endDate = date('Y-m-d h:i:s', strtotime($endDate . ' 23:59:59'));
        return $this->laporanRepository->getLaporanTransaksiBetweenDate($startDate, $endDate);
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

    public function getIncomeCurrentMonth()
    {
        return $this->laporanRepository->getIncomeCurrentMonth();
    }

    public function getTransactionAmount()
    {
        return $this->laporanRepository->countTransactionData();
    }

    public function getNumberOfMember()
    {
        return $this->laporanRepository->countMemberData();
    }

    public function getRecentlyTransaction()
    {
        return $this->laporanRepository->getRecentlyTransaction();
    }

    public function getIncomePerDayCurrentMonth()
    {
        return $this->laporanRepository->getIncomePerDayCurrentMonth();
    }

    public function getRecentlyActivity()
    {
        $masterData = $this->laporanRepository->getMasterDataLogs()->toArray();
        $transaksiData = $this->laporanRepository->getTransaksiLogs()->toArray();

        $data = new Collection(array_merge($masterData, $transaksiData));
        $data = $data->sortByDesc('created_at')->groupBy(function($date) {
            return Carbon::parse($date['created_at'])->format('d-M-Y');
        });
        return $data;
    }

    public function getLatestTransaction($limit)
    {
        return $this->laporanRepository->getLatestTransaction($limit);
    }

    public function getAmountOfTransactionPerStatusTransaction()
    {
        return $this->laporanRepository->getAmountOfTransactionPerStatusTransaction();
    }

    public function getAmountOfTransactionPerDayPerStatusTransaction()
    {
        $data = $this->laporanRepository->getAmountOfTransactionPerDayPerStatusTransaction();
        $result = new Collection($data);
        $result = $result->groupBy(function($data) {
            return $data['status_transaksi'];
        });
        return $result;
    }

    public function getNumberOfMemberPerGender()
    {
        return $this->laporanRepository->getNumberOfMemberPerGender();
    }
}
