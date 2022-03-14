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
                <div class="modal-body">
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-inboxes"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="merk_barang" class="form-control" placeholder="Merk Barang" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-minecart-loaded"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="number" name="qty" class="form-control" placeholder="QTY" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="kondisi">
                                <i class="bi bi-list-ul"></i>
                            </label>
                            <select class="form-select" name="kondisi" id="kondisi">
                                <option selected disabled value="">Pilih Kondisi..</option>
                                <option value="layak_pakai">Layak Pakai</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_baru">Rusak Baru</option>
                            </select>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="date" name="tanggal_pengadaan" class="form-control" placeholder="Tanggal" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-calendar-date"></i>
                            </div>
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
                            <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-inboxes"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="merk_barang" class="form-control" placeholder="Merk Barang" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-minecart-loaded"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="number" name="qty" class="form-control" placeholder="QTY" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="kondisi">
                                <i class="bi bi-list-ul"></i>
                            </label>
                            <select class="form-select" name="kondisi" id="kondisi">
                                <option selected disabled value="">Pilih Kondisi..</option>
                                <option value="layak_pakai">Layak Pakai</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_baru">Rusak Baru</option>
                            </select>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="date" name="tanggal_pengadaan" class="form-control" placeholder="Tanggal" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-calendar-date"></i>
                            </div>
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
                <form action="/barang-inventaris/import-excel" method="POST" enctype="multipart/form-data">
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
