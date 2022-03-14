<div class="modal fade text-left modal-borderless" id="update-data-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-2 text-center">
                    <h3>Status Transaksi</h3>
                </div>
                <div class="mb-5">
                    <div class="horizontal-progressbar">
                        <ul>
                            <li class="progressbar-list">
                                <div class="progressbar-item">
                                    <div class="progressbar-icon">
                                        <i class="bi bi-bag"></i>
                                    </div>
                                </div>
                                <div class="progressbar-label">
                                    <strong>Baru</strong>
                                </div>
                            </li>
                            <li class="progressbar-list">
                                <div class="progressbar-item">
                                    <div class="progressbar-icon">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </div>
                                </div>
                                <div class="progressbar-label">
                                    <strong>Progres</strong>
                                </div>
                            </li>
                            <li class="progressbar-list">
                                <div class="progressbar-item">
                                    <div class="progressbar-icon">
                                        <i class="bi bi-bag-check"></i>
                                    </div>
                                </div>
                                <div class="progressbar-label">
                                    <strong>Selesai</strong>
                                </div>
                            </li>
                            <li class="progressbar-list">
                                <div class="progressbar-item">
                                    <div class="progressbar-icon">
                                        <i class="bi bi-person-check"></i>
                                    </div>
                                </div>
                                <div class="progressbar-label">
                                    <strong>Diambil</strong>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mb-5 row">
                    <div class="col-6">
                        <table>
                            <tr>
                                <td>Status Transaksi</td>
                                <td class="px-3">:</td>
                                <td name="status_transaksi"></td>
                            </tr>
                            <tr>
                                <td>Status Pembayaran</td>
                                <td class="px-3">:</td>
                                <td name="status_pembayaran"><span class="badge bg-light-danger">belum lunas</span> (<a href="/transaksi/pembayaran">lakukan pembayaran</a>)</td>
                            </tr>
                            <tr>
                                <td>Metode Pembayaran</td>
                                <td class="px-3">:</td>
                                <td name="metode_pembayaran"><span class="badge bg-light-warning">bayar nanti</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-6">
                        <table>
                            <tr>
                                <td>Kode Invoice</td>
                                <td class="px-3">:</td>
                                <td name="kode_invoice">INV202101001</td>
                            </tr>
                            <tr>
                                <td>Nama Member</td>
                                <td class="px-3">:</td>
                                <td name="nama">Ihsan</td>
                            </tr>
                            <tr>
                                <td>No Telepon</td>
                                <td class="px-3">:</td>
                                <td name="tlp">08187271</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="mb-2">
                    <h4>Data Paket Pesanan</h4>
                    <div class="table-responsive p-2">
                        <table class="table w-100 text-center" id="paket-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Paket</th>
                                    <th>Jenis Paket</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Paket Baju</td>
                                    <td>Kaos</td>
                                    <td>Rp 8.000</td>
                                    <td>4x</td>
                                    <td>Rp 32.000</td>
                                </tr>
                            </tbody>
                            <tfoot id="belum-lunas">
                                <tr>
                                    <th colspan="6" class="text-center">Pelanggan Belum Menulasi Pembayaran</th>
                                </tr>
                            </tfoot>
                            <tfoot id="lunas">
                                <tr>
                                    <td colspan="5" class="text-end">Biaya Tambahan</td>
                                    <td>Rp <span name="biaya_tambahan">0</span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end">Diskon</td>
                                    <td><span name="diskon">0</span>%</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end">Pajak</td>
                                    <td><span name="pajak">0</span>%</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end">Total Pembayaran</td>
                                    <td>Rp <span name="total_pembayaran">0</span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end">Total Bayar</td>
                                    <td>Rp <span name="total_bayar">0</span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end">Kembalian</td>
                                    <td>Rp <span name="kembalian">0</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
<link rel="stylesheet" href="{{ asset('vendors/muffle-ui/horizontal-progress-bar/horizontal-progress-bar.css') }}">
<style>
    #paket-table tfoot td, #paket-table tfoot th {
        border: none !important;
    }
</style>
@endpush
