@extends('layout.app')
@section('title', 'Simulasi Data')
@section('main')
    <div class="page-heading">
        <h3>Simulasi Transaksi</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form method="POST" id="form-data">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="id-karyawan">ID Karyawan</label>
                                <input type="number" name="id" id="id-karyawan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="nama-barang">Nama Barang</label>
                                <select name="nama_barang" id="nama-barang" class="form-select" required>
                                    <option selected disabled value="">Pilih Barang</option>
                                    <option value="detergen">Detergen</option>
                                    <option value="pewangi">Pewangi</option>
                                    <option value="detergen sepatu">Detergen Sepatu</option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" name="jumlah" class="form-control" required min="0" max="99" id="jumlah" value="0">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="tanggal-beli">Tanggal Beli</label>
                                <input type="date" class="form-control" name="tanggal_beli" id="tanggal-beli" required>
                            </div>
                            <div class="mt-5">
                                <h4>Harga : Rp. <span id="harga">0</span></h4>
                            </div>
                            <div class="form-group">
                                <label for="jenis_pembayaran">Jenis Pembayaran</label>
                                <div class="d-flex gap-5 my-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_pembayaran" id="cash" value="cash" required>
                                        <label class="form-check-label" for="cash">
                                            Cash
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_pembayaran" id="e-money" value="e-money/transfer" required>
                                        <label class="form-check-label" for="e-money">
                                            E-money/Transfer
                                        </label>
                                    </div>
                                </div>
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
                    <span class="d-flex gap-3 align-items-center">
                        <button type="button" class="btn btn-outline-primary" id="sorting">Urutkan</button>
                        <div class="form-check">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox-cash" class="form-check-input checkbox-jenis-pembayaran" checked value="cash">
                                <label for="checkbox-cash">Cash</label>
                            </div>
                        </div>
                        <div class="form-check">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox-e-money-transfer" class="form-check-input checkbox-jenis-pembayaran" checked value="e-money/transfer">
                                <label for="checkbox-e-money-transfer">E-money / Transfer</label>
                            </div>
                        </div>
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
                            <th>Harga</th>
                            <th>QTY</th>
                            <th>Diskon</th>
                            <th>Total Harga</th>
                            <th>Jenis Pembayaran</th>
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
    <script type="module" src="{{ asset('js/crud/simulasi-transaksi.js') }}"></script>
@endpush
