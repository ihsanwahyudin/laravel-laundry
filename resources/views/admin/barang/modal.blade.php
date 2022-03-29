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
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="number" name="qty" class="form-control" placeholder="QTY" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="harga" class="form-control disable-letter" placeholder="Harga" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="datetime-local" name="waktu_beli" class="form-control disable-letter" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="supplier" class="form-control disable-letter" placeholder="Nama Pemasok" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="selectStatus">
                                <i class="bi bi-list-ul"></i>
                            </label>
                            <select class="form-select" name="status_barang" id="selectStatus">
                                <option selected disabled value="">Status..</option>
                                <option value="diajukan_beli">Diajukan Beli</option>
                                <option value="habis">Habis</option>
                                <option value="tersedia">Tersedia</option>
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
                <div class="modal-body px-4">
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="number" name="qty" class="form-control" placeholder="QTY" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="harga" class="form-control disable-letter" placeholder="Harga" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="datetime-local" name="waktu_beli" class="form-control disable-letter" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="supplier" class="form-control disable-letter" placeholder="Nama Pemasok" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="selectStatus">
                                <i class="bi bi-list-ul"></i>
                            </label>
                            <select class="form-select" name="status_barang" id="selectStatus">
                                <option selected disabled value="">Status..</option>
                                <option value="diajukan_beli">Diajukan Beli</option>
                                <option value="habis">Habis</option>
                                <option value="tersedia">Tersedia</option>
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
                <form action="/barang/import-excel" method="POST" enctype="multipart/form-data">
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
