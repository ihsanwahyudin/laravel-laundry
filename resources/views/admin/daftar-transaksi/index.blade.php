@extends('layout.app')
@section('title', 'Data Paket')
@push('css')
<link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }

    input[type=number] {
        -moz-appearance:textfield; /* Firefox */
    }
</style>
{{-- <link href="https://kodhus.com/static/css/kodhus.min.css" rel="stylesheet" type="text/css" />
<script src="https://kodhus.com/static/js/kodhus.min.js"></script> --}}
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
        <div class="card-header">
            <h3>Daftar Transaksi</h3>
        </div>
        <div class="card-body">
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
@include('admin.daftar-transaksi.modal')
@endsection
@push('script')
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendors/moment/moment.js') }}"></script>
    <script src="{{ asset('js/formatNumber.js') }}"></script>
    <script type="module" src="{{ asset('js/crud/daftar-transaksi.js') }}"></script>
@endpush
