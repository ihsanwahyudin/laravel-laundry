@extends('layout.app')
@section('title', 'Log Aktivitas')
@section('main')
<div class="page-heading">
    <div class="card">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><span class="text-primary">Log Aktivitas</span></li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h3>Filter Data</h3>
            <form id="filter-data-form">
                <div class="row">
                    <div class="mb-2 col-6">
                        <label>From Date</label>
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="date" name="start_date" class="form-control" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-calendar2-week"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2 col-6">
                        <label>To Date</label>
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="date" name="end_date" class="form-control" autocomplete="off">
                            <div class="form-control-icon">
                                <i class="bi bi-calendar2-week"></i>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-primary float-end">Apply</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="log-data">

    </div>
    {{-- <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>20 September 2021</h4>
            <h4>14 Aktivitas</h4>
        </div>
        <div class="card-content pb-4">
            <div class="recent-message d-flex px-4 py-3">
                <div class="avatar avatar-lg">
                    <img src="{{ asset('vendors/mazer/dist/assets/images/faces/4.jpg') }}" />
                </div>
                <div class="name ms-4">
                    <div class="title">
                        <h5>Hank Schrader</h5>
                        <span><small>1 hour Ago</small></span>
                    </div>
                    <h6 class="text-muted mb-0">Menambah Data baru dengan ID 98923223</h6>
                </div>
            </div>
            <div class="recent-message d-flex px-4 py-3">
                <div class="avatar avatar-lg">
                    <img src="{{ asset('vendors/mazer/dist/assets/images/faces/5.jpg') }}" />
                </div>
                <div class="name ms-4">
                    <div class="title">
                        <h5>Dean Winchester</h5>
                        <span><small>2 hour Ago</small></span>
                    </div>
                    <h6 class="text-muted mb-0">Mengubah Data dengan ID 1231231</h6>
                </div>
            </div>
            <div class="recent-message d-flex px-4 py-3">
                <div class="avatar avatar-lg">
                    <img src="{{ asset('vendors/mazer/dist/assets/images/faces/1.jpg') }}" />
                </div>
                <div class="name ms-4">
                    <div class="title">
                        <h5>John Dodol</h5>
                        <span><small>5 hour Ago</small></span>
                    </div>
                    <h6 class="text-muted mb-0">Menghapus data dengan ID 1231231</h6>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection
@push('css')
<style>
    .recent-message:hover {
        background-color: #f5f5f5;
    }
    .recent-message .name {
        width: 100%;
    }
    .name .title {
        display: flex;
        justify-content: space-between;
    }
</style>
@endpush
@push('script')
    <script src="{{ asset('vendors/moment/moment.js') }}"></script>
    <script type="module" src="{{ asset('js/crud/log-activity.js') }}"></script>
@endpush
