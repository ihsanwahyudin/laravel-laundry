<div class="modal fade text-left modal-borderless" id="detail-transaksi-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Transaksi</h3>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-2 row">
                    <div class="col-6">
                        <table>
                            <tr>
                                <td>Status Transaksi</td>
                                <td class="px-3">:</td>
                                <td name="status_transaksi"><span class="badge bg-light-primary">baru</span></td>
                            </tr>
                            <tr>
                                <td>Status Pembayaran</td>
                                <td class="px-3">:</td>
                                <td name="status_pembayaran"><span class="badge bg-light-danger">belum lunas</span></td>
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
                    <div class="alert alert-primary text-center mx-5 my-4 py-2" role="alert">
                        <p>Tanggal Bayar - Batas Waktu</p>
                        <strong><span name="tgl_bayar">2021-10-01</span> sd <span name="batas_waktu">2021-10-31</span></strong>
                    </div>
                </div>
                <div class="mb-2">
                    <h6>Data Paket Pesanan</h6>
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
                            <tbody></tbody>
                            <tfoot>
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
                <div class="d-flex justify-content-end">
                    <a href="/api/transaksi/cetak-faktur" target="_blank" class="btn btn-outline-primary" id="cetak-faktur">Cetak</a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
    <style>
        #paket-table tfoot td, #paket-table tfoot th {
            border: none !important;
        }
    </style>
@endpush
