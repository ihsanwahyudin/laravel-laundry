@extends('layout.app')
@section('title', 'Data Paket')
@push('css')
<link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
@endpush
@section('main')
<div class="page-heading">
    <div class="card">
        <div class="card-body">
            @php
                $url = explode("/", $_SERVER["REQUEST_URI"]);
            @endphp
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    @foreach ($url as $key => $item)
                        @if ($item != "")
                            <li class="breadcrumb-item"><span class="{{ $key + 1 == count($url) ? 'text-primary' : '' }}">{{ ucfirst($item) }}</span></li>
                        @endif
                    @endforeach
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
    <div class="card">
        <div class="card-body">
            <h3>Data Laporan</h3>
            <div class="d-flex justify-content-end">
                <a href="/api/laporan/transaksi/export-pdf" target="_blank" class="btn btn-outline-primary rounded-pill me-2">PDF</a>
                <a href="/api/laporan/transaksi/export-excel" target="_blank" class="btn btn-outline-primary rounded-pill me-2">Excel</a>
                <button class="btn btn-outline-primary rounded-pill me-2" id="export-txt">Text</button>
            </div>
            <div class="table-responsive p-2">
                <table class="table" id="laporan-table">
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
                            <th class="text-center">Detail</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include('admin.laporan-transaksi.modal')
@endsection
@push('script')
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/formatNumber.js') }}"></script>
    <script type="module" src="{{ asset('js/crud/laporan-transaksi.js') }}"></script>
@endpush
