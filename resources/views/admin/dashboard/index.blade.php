@extends('layout.app')
@section('title', 'Dashboard')
@section('main')
<div class="page-heading">
    <h3>Laundry Statistics</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Pemasukan</h6>
                                    <h6 class="font-extrabold mb-0" id="pemasukan">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Jumlah Transaksi</h6>
                                    <h6 class="font-extrabold mb-0" id="jumlah-transaksi">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Jumlah Member</h6>
                                    <h6 class="font-extrabold mb-0" id="jumlah-member">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pemasukan Harian</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-pemasukan-harian"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Status Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="alert alert-primary d-flex justify-content-between">
                                    <span>Baru</span>
                                    <span id="jumlah-status-baru">0</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-info d-flex justify-content-between">
                                    <span>Proses</span>
                                    <span id="jumlah-status-proses">0</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-warning d-flex justify-content-between">
                                    <span>Selesai</span>
                                    <span id="jumlah-status-selesai">0</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-success d-flex justify-content-between">
                                    <span>Diambil</span>
                                    <span id="jumlah-status-diambil">0</span>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-primary" width="32" height="32" fill="blue" style="width: 10px;">
                                            <use xlink:href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill') }}" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Baru</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-0" id="jumlah-status-baru">0</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-status-baru"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-success" width="32" height="32" fill="blue" style="width: 10px;">
                                            <use xlink:href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill') }}" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Proses</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-0" id="jumlah-status-proses">0</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-status-proses"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-danger" width="32" height="32" fill="blue" style="width: 10px;">
                                            <use xlink:href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill') }}" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Selesai</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-0" id="jumlah-status-selesai">0</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-status-selesai"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-danger" width="32" height="32" fill="blue" style="width: 10px;">
                                            <use xlink:href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill') }}" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Diambil</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-0" id="jumlah-status-diambil">0</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-status-diambil"></div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Aktivitas Terbaru</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg" id="aktivitas-terbaru">
                                    <thead>
                                        <tr>
                                            <th>Nama Pengguna</th>
                                            <th>Aktivitas</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-5">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('vendors/mazer/dist/assets/images/faces/'.random_int(1,5).'.jpg') }}" alt="Face 1" />
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">{{ Auth()->user()->name }}</h5>
                            <h6 class="text-muted mb-0">{{ Auth()->user()->email }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Transaksi Terbaru</h4>
                </div>
                <div class="card-content pb-4" id="transaksi-terbaru">
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Member Data</h4>
                </div>
                <div class="card-body">
                    <div id="chart-member-data"></div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('vendors/moment/moment.js') }}"></script>
	<script type="module" src="{{ asset('js/crud/statistik.js') }}"></script>
@endpush
