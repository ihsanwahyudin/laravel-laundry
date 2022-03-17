<div class="modal fade text-left modal-borderless" id="create-data-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data Baru</h4>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form>
                <div class="modal-body px-4">
                    <div class="mb-2">
                        <div class="input-group flex-nowrap" style="width: 100% !important">
                            <div class="form-group m-0 position-relative has-icon-left w-100">
                                <input type="text" name="kode_invoice" class="form-control" placeholder="No Transaksi" autocomplete="off" readonly>
                                <input type="hidden" name="transaksi_id">
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#select-transaksi-modal" data-bs-dismiss="modal">Cari</button>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="nama" class="form-control" placeholder="Nama Pelanggan" autocomplete="off" disabled>
                            <div class="form-control-icon">
                                <i class="bi bi-shop"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="tlp" class="form-control" placeholder="Telp Pelanggan" autocomplete="off" disabled>
                            <div class="form-control-icon">
                                <i class="bi bi-shop"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="alamat" class="form-control" placeholder="Alamat Pelanggan" autocomplete="off" disabled>
                            <div class="form-control-icon">
                                <i class="bi bi-shop"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="petugas_penjemput" class="form-control" placeholder="Nama Petugas Penjemput" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="selectJenis">
                                <i class="bi bi-list-ul"></i>
                            </label>
                            <select class="form-select" name="status" id="selectJenis">
                                <option selected disabled value="">Status..</option>
                                <option value="tercatat">Tercatat</option>
                                <option value="penjemputan">Penjemputan</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Batal</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade text-left modal-borderless" id="update-data-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Data</h4>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="kode_invoice" class="form-control" placeholder="No Transaksi" autocomplete="off" disabled>
                            <input type="hidden" name="transaksi_id">

                            <div class="form-control-icon">
                                <i class="bi bi-shop"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="nama" class="form-control" placeholder="Nama Pelanggan" autocomplete="off" disabled>
                            <div class="form-control-icon">
                                <i class="bi bi-shop"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="tlp" class="form-control" placeholder="Telp Pelanggan" autocomplete="off" disabled>
                            <div class="form-control-icon">
                                <i class="bi bi-shop"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="alamat" class="form-control" placeholder="Alamat Pelanggan" autocomplete="off" disabled>
                            <div class="form-control-icon">
                                <i class="bi bi-shop"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="petugas_penjemput" class="form-control" placeholder="Nama Petugas Penjemput" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="selectJenis">
                                <i class="bi bi-list-ul"></i>
                            </label>
                            <select class="form-select" name="status" id="selectJenis">
                                <option selected disabled value="">Status..</option>
                                <option value="tercatat">Tercatat</option>
                                <option value="penjemputan">Penjemputan</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Batal</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade text-left modal-borderless" id="import-data-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import Data</h4>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="/penjemputan/import-excel" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="mb-2">
                            <div class="form-group m-0">
                                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" placeholder="Nama" autocomplete="off">
                            </div>
                            <span class="form-errors"></span>
                        </div>
                    <button type="submit" class="btn btn-primary">Import Excel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left modal-borderless" id="select-transaksi-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Paket</h4>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive p-2">
                    <table class="table w-100" id="daftar-transaksi-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Invoice</th>
                                <th>Nama Member</th>
                                <th>Tanggal Bayar</th>
                                <th>Batas Waktu</th>
                                <th>Metode Pembayaran</th>
                                <th>Status Transaksi</th>
                                <th>Status Pembayaran</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
