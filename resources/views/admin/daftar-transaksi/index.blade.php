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
    <form id="store-transaction">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h3>Transaksi</h3>
                    {{-- <div>
                        <label>Status Transaksi</label>
                        <div class="alert alert-success p-2" role="alert">
                            Selesai
                        </div>
                        <span class="badge bg-light-warning">diambil</span>
                    </div> --}}
                </div>
                <div class="card-body row">
                    <div class="row col-8">
                        <div class="col-6">
                            <div class="mb-2">
                                <label>Kode Invoice</label>
                                <div class="input-group flex-nowrap" style="width: 100% !important">
                                    <div class="form-group m-0 position-relative has-icon-left w-100">
                                        <input type="text" name="kode_invoice" class="form-control" placeholder="Kode Invoice" autocomplete="off" readonly>
                                        <div class="form-control-icon">
                                            <i class="bi bi-arrow-left-right"></i>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-primary" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#select-data-modal">Cari</button>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label>Nama Member</label>
                                <div class="form-group m-0 position-relative has-icon-left">
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Member" autocomplete="off" readonly>
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                                <span class="form-errors"></span>
                            </div>
                            <div class="mb-2">
                                <label>Telepon</label>
                                <div class="form-group m-0 position-relative has-icon-left">
                                    <input type="text" name="tlp" class="form-control" placeholder="Telepon" autocomplete="off" readonly>
                                    <div class="form-control-icon">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                </div>
                                <span class="form-errors"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <label>Tanggal Transaksi</label>
                                <div class="form-group m-0 position-relative has-icon-left">
                                    <input type="text" name="tgl_bayar" class="form-control" placeholder="Tanggal Transaksi" autocomplete="off" readonly>
                                    <div class="form-control-icon">
                                        <i class="bi bi-calendar2-week"></i>
                                    </div>
                                </div>
                                <span class="form-errors"></span>
                            </div>
                            <div class="mb-2">
                                <label>Batas Waktu</label>
                                <div class="form-group m-0 position-relative has-icon-left">
                                    <input type="text" name="batas_waktu" class="form-control" placeholder="Batas waktu" autocomplete="off" readonly>
                                    <div class="form-control-icon">
                                        <i class="bi bi-calendar2-week"></i>
                                    </div>
                                </div>
                                <span class="form-errors"></span>
                            </div>

                        </div>
                    </div>
                    <div class="col-4 d-flex justify-content-end align-items-end">
                        <div>
                            <h4 class="mr-5">Total Pembayaran</h4>
                            <h2 class="fs-1"><strong>Rp <span name="total_pembayaran">0</span></strong></h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h3>Data Penjualan</h3>
                </div>
                <div class="card-body">
                    <table class="table" id="selected-transaksi-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Paket</th>
                                <th>Jenis Paket</th>
                                <th>Harga</th>
                                <th class="text-center">Jumlah</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h3>Data Pembayaran</h3>
                </div>
                <div class="card-body">
                    <table class="table" id="pembayaran-table">
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
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-center">Subtotal</th>
                                <th name="subtotal_bayar">Rp 0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
    </form>
    {{-- @include('admin.transaksi.floating-section') --}}
</div>
@include('admin.daftar-transaksi.modal')
@endsection
@push('css')
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
@endpush
@push('script')
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendors/moment/moment.js') }}"></script>
    <script src="{{ asset('js/formatNumber.js') }}"></script>
    <script type="module" src="{{ asset('js/crud/daftar-transaksi.js') }}"></script>
@endpush