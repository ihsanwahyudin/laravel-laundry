<?php

namespace App\Repositories\Interfaces\Eloquent;

interface LaporanRepositoryInterface
{
    public function getLaporanTransaksi();

    public function getLaporanTransaksiBetweenDate($startDate, $endDate);

    public function getLaporanTransaksiPerOutlet();

    public function getLaporanTransaksiPerKaryawan();

    public function getLaporanTransaksiPerMember();

    public function getLaporanTransaksiPerPaket();

    public function getLaporanTransaksiPerBulan();

    public function getLaporanTransaksiPerTahun();

    public function getLaporanTransaksiPerBulanPerOutlet();

    public function getLaporanTransaksiPerBulanPerKaryawan();

    public function getLaporanTransaksiPerBulanPerMember();

    public function getLaporanTransaksiPerBulanPerPaket();

    public function getLaporanTransaksiPerBulanPerTahun();

    public function getLaporanTransaksiPerTahunPerOutlet();

    public function getLaporanTransaksiPerTahunPerKaryawan();

    public function getLaporanTransaksiPerTahunPerMember();

    public function getLaporanTransaksiPerTahunPerPaket();

    public function getIncomeCurrentMonth();

    public function countTransactionData();

    public function countMemberData();

    public function getRecentlyTransaction();

    public function getIncomePerDayCurrentMonth();

    public function getMasterDataLogs();

    public function getTransaksiLogs();

    public function getLatestTransaction(int $latest);

    public function getAmountOfTransactionPerStatusTransaction();

    public function getAmountOfTransactionPerDayPerStatusTransaction();

    public function getNumberOfMemberPerGender();
}
