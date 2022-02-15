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
                </div>
                <div class="card-body row">
                    <div class="row col-8">
                        <div class="col-6">
                            <div class="mb-2">
                                <label>Tanggal Bayar</label>
                                <div class="form-group m-0 position-relative has-icon-left">
                                    <input type="date" name="tgl_bayar" class="form-control" placeholder="Tanggal" autocomplete="off">
                                    <div class="form-control-icon">
                                        <i class="bi bi-calendar2-week"></i>
                                    </div>
                                </div>
                                <span class="form-errors"></span>
                            </div>
                            <div class="mb-2">
                                <div class="input-group flex-nowrap" style="width: 100% !important">
                                    <div class="form-group m-0 position-relative has-icon-left w-100">
                                        <input type="text" name="nama" class="form-control" placeholder="Nama Pelanggan" autocomplete="off" readonly>
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-primary" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#select-member-modal">Cari</button>
                                </div>
                            </div>
                            <div class="mb-2">
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
                                <label>Batas Waktu</label>
                                <div class="form-group m-0 position-relative has-icon-left">
                                    <input type="date" name="batas_waktu" class="form-control" placeholder="Batas Waktu" autocomplete="off">
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
                            <h2 class="fs-1"><strong>Rp <span name="total_penjualan">0</span></strong></h2>
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
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search for packages..." aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#select-data-modal">Pilih</button>
                    </div>
                    <table class="table" id="transaksi-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Paket</th>
                                <th>Jenis Paket</th>
                                <th>Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
        <section class="sticky-bottom row justify-content-end">
            <div class="card border-less col-6 border">
                <div class="card-header">
                    <h3>Masukan Pembayaran</h3>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <div class="input-group m-0">
                            <label class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                                </svg>
                            </label>
                            <select class="form-select" name="metode_pembayaran">
                                <option value="cash">Cash</option>
                                <option value="dp">DP</option>
                                <option value="bayar nanti">Bayar Nanti</option>
                            </select>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <label>Biaya Tambahan</label>
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="biaya_tambahan" class="form-control disable-letter" autocomplete="off" value="0">
                            <div class="form-control-icon">
                                <strong>Rp</strong>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <label>Diskon</label>
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="diskon" class="form-control disable-letter" autocomplete="off" value="0">
                            <div class="form-control-icon">
                                <strong>%</strong>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <label>Pajak</label>
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="pajak" class="form-control disable-letter" autocomplete="off" value="10" readonly>
                            <div class="form-control-icon">
                                <strong>%</strong>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <div class="mb-2">
                        <label>Nominal Uang</label>
                        <div class="form-group m-0 position-relative has-icon-left">
                            <input type="text" name="total_bayar" class="form-control disable-letter" autocomplete="off">
                            <div class="form-control-icon">
                                <strong>Rp</strong>
                            </div>
                        </div>
                        <span class="form-errors"></span>
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </section>
    </form>
    {{-- @include('admin.transaksi.floating-section') --}}
</div>
@include('admin.transaksi.modal')
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
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/formatNumber.js') }}"></script>
    <script type="module" src="{{ asset('js/crud/transaksi.js') }}"></script>
@endpush
