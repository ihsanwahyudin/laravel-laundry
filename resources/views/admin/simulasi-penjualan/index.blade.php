@extends('layout.app')
@section('title', 'Simulasi Penjualan')
@section('main')
    <div class="page-heading">
        <h3>Simulasi Penjualan</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form method="POST" id="form-data">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="no-transaksi">No Transaksi</label>
                                <input type="number" name="no_transaksi" id="no-transaksi" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="barang-dibeli">Barang dibeli</label>
                                <select name="nama_barang" id="barang-dibeli" class="form-select" required></select>
                            </div>
                            <div class="form-group col-4">
                                <label for="jumlah-beli">Jumlah beli</label>
                                <input type="number" name="jumlah_beli" class="form-control" required min="0" max="99" id="jumlah-beli" value="0">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="tanggal-beli">Tanggal Beli</label>
                                <input type="date" class="form-control" name="tanggal_beli" id="tanggal-beli" required>
                            </div>
                            <div class="form-group">
                                <label for="warna">Warna</label>
                                <select name="warna" id="warna" class="form-select" required>
                                    <option selected disabled value="">Pilih Warna</option>
                                    <option value="kuning">Kuning</option>
                                    <option value="merah">Merah</option>
                                    <option value="hijau">Hijau</option>
                                    <option value="biru">Biru</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama-pembeli">Nama Pembeli</label>
                                <input type="text" name="nama_pembeli" id="nama-pembeli" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-primary float-end">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Data Barang</h3>
            </div>
            <div class="card-body">
                <div class="my-2 d-flex justify-content-between">
                    <span class="d-flex gap-2">
                        <select class="form-select" id="group-by">
                            <option value="no_transaksi">ID</option>
                            <option value="tanggal_beli">Tanggal Beli</option>
                            <option value="nama_barang">Nama Barang</option>
                            <option value="warna">Warna</option>
                            <option value="harga_beli">Harga</option>
                            <option value="jumlah_beli">Jumlah Beli</option>
                            <option value="nama_pembeli">Nama Pelanggan</option>
                            <option value="diskon">Diskon</option>
                            <option value="total_harga">Total Harga</option>
                        </select>
                        <select class="form-select" id="order-by">
                            <option value="desc">Descending</option>
                            <option value="asc">Ascending</option>
                        </select>
                        <button type="button" class="btn btn-outline-primary" id="sorting">Urutkan</button>
                    </span>
                    <span class="d-flex gap-2">
                        <input type="search" class="form-control" id="search" style="width: 200px">
                        <button class="btn btn-outline-primary" id="btnSearch">
                            Search
                        </button>
                    </span>
                </div>
                <table class="table text-center table-borderless">
                    <thead class="table-primary text-primary">
                        <tr>
                            <th>ID</th>
                            <th>Tanggal Beli</th>
                            <th>Nama Barang</th>
                            <th>Warna</th>
                            <th>Harga</th>
                            <th>Jumlah Beli</th>
                            <th>Nama Pelanggan</th>
                            <th>Diskon</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    {{-- Include Library --}}
    <script src="{{ asset('vendors/moment/moment.js') }}"></script>
    <script type="module" src="{{ asset('js/crud/simulasi-penjualan.js') }}"></script>
@endpush
