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
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-center">Total</th>
                                    <th name="total_pembayaran">Rp 450.000</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="mb-2">
                    <h6>Data Pembayaran</h6>
                    <div class="table-responsive p-2">
                        <table class="table w-100 text-center" id="pembayaran-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Biaya Tambahan</th>
                                    <th>Diskon</th>
                                    <th>Pajak</th>
                                    <th>Total Pembayaran</th>
                                    <th>Total Bayar</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-center">Total</th>
                                    <th name="total_pembayaran_bersih">Rp 450.000</th>
                                    <th name="total_bayar">Rp 500.000</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-outline-primary">Cetak</button>
                </div>
            </div>
        </div>
    </div>
</div>
