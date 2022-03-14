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
                            <input type="text" name="name" class="form-control" placeholder="Nama" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="selectRole">
                                <i class="bi bi-person-bounding-box"></i>
                            </label>
                            <select class="form-select" name="role" id="selectRole">
                                <option selected disabled>Choose Role..</option>
                                <option value="admin">Admin</option>
                                <option value="kasir">Kasir</option>
                            </select>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="selectOutlet">
                                <i class="bi bi-shop"></i>
                            </label>
                            <select class="form-select" name="outlet_id" id="selectOutlet">
                                <option selected disabled>Choose Outlet...</option>
                            </select>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="password" name="password" class="form-control" placeholder="password" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="password confirmation" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="fas fa-lock"></i>
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
                <h4 class="modal-title">Edit Data</h4>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-2">
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="name" class="form-control" placeholder="Nama" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="selectRole">
                                <i class="bi bi-person-bounding-box"></i>
                            </label>
                            <select class="form-select" name="role" id="selectRole">
                                <option selected disabled>Choose Role..</option>
                                <option value="admin">Admin</option>
                                <option value="kasir">Kasir</option>
                            </select>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text" for="selectOutlet">
                                <i class="bi bi-shop"></i>
                            </label>
                            <select class="form-select" name="outlet_id" id="selectOutlet">
                                <option selected disabled>Choose Outlet...</option>
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
