<div class="modal fade text-left modal-borderless" id="create-data-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data Baru</h4>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="selectRole">
                                <i class="bi bi-shop"></i>
                            </label>
                            <select class="form-select" name="outlet_id" id="selectRole">
                                <option selected disabled value="">Choose Outlet..</option>
                            </select>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="nama_paket" class="form-control" placeholder="Nama Paket" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-bag-check"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="selectJenis">
                                <i class="bi bi-list-ul"></i>
                            </label>
                            <select class="form-select" name="jenis" id="selectJenis">
                                <option selected disabled value="">Choose Packages..</option>
                                <option value="kiloan">Kiloan</option>
                                <option value="selimut">Selimut</option>
                                <option value="bed_cover">Bed Cover</option>
                                <option value="kaos">Kaos</option>
                                <option value="lain">Lain</option>
                            </select>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="harga" class="form-control" placeholder="Harga" autocomplete="off">
                            <div class="form-control-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                                </svg>
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
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="selectRole">
                                <i class="bi bi-shop"></i>
                            </label>
                            <select class="form-select" name="outlet_id" id="selectRole">
                                <option selected disabled value="">Choose Outlet..</option>
                            </select>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="nama_paket" class="form-control" placeholder="Nama Paket" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-bag-check"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="selectJenis">
                                <i class="bi bi-list-ul"></i>
                            </label>
                            <select class="form-select" name="jenis" id="selectJenis">
                                <option selected disabled value="">Choose Packages..</option>
                                <option value="kiloan">Kiloan</option>
                                <option value="selimut">Selimut</option>
                                <option value="bed_cover">Bed Cover</option>
                                <option value="kaos">Kaos</option>
                                <option value="lain">Lain</option>
                            </select>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="harga" class="form-control" placeholder="Harga" autocomplete="off">
                            <div class="form-control-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                                </svg>
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
            </div>
            <div class="modal-body">
                <form action="/paket/import-excel" method="POST" enctype="multipart/form-data">
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
