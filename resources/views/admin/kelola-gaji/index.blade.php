@extends('layout.app')
@section('title', 'Simulasi Data')
@section('main')
    <div class="page-heading">
        <h3>Simulasi Gaji Karyawan</h3>
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
                                {{-- <select name="id" id="id_karyawan" class="form-select">
                                    <option selected disabled value="">Pilih Karyawan</option>
                                </select> --}}
                            </div>
                            <div>
                                <label for="jk">Jenis Kelamin</label>
                                <div class="d-flex gap-5 my-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jk" id="l" value="L" required>
                                        <label class="form-check-label" for="l">
                                            Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jk" id="p" value="P" required>
                                        <label class="form-check-label" for="p">
                                            Perempuan
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label for="jumlah-anak">Jumlah Anak</label>
                                <input type="number" name="jumlah_anak" class="form-control" required min="0" max="99" id="jumlah-anak" value="0" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="nama">Nama Karyawan</label>
                                <input type="text" class="form-control" name="nama" id="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="status-menikah">Status Menikah</label>
                                <select name="status_menikah" id="status-menikah" class="form-select" required>
                                    <option selected disabled value="">Pilih Status</option>
                                    <option value="single">Single</option>
                                    <option value="couple">Couple</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="mulai-bekerja">Mulai Bekerja</label>
                                <input type="date" name="mulai_bekerja" id="mulai-bekerja" class="form-control" required>
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
                <h3>Data Karyawan</h3>
            </div>
            <div class="card-body">
                <div class="my-2 d-flex justify-content-between">
                    <span class="d-flex gap-2">
                        <select class="form-select" id="group-by">
                            <option value="id">ID</option>
                            <option value="nama">Nama</option>
                            <option value="jk">Jenis Kelamin</option>
                            <option value="status_menikah">Status Menikah</option>
                            <option value="jumlah_anak">Jumlah Anak</option>
                            <option value="mulai_bekerja">Mulai Bekerja</option>
                            <option value="gaji_awal">Gaji Awal</option>
                            <option value="tunjangan">Tunjangan</option>
                            <option value="total_gaji">Total Gaji</option>
                        </select>
                        <select class="form-select" id="sorting">
                            <option selected disabled>Sorting</option>
                            <option value="desc">Descending</option>
                            <option value="asc">Ascending</option>
                        </select>
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
                            <th>Nama Karyawan</th>
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
                            <th>Jumlah Anak</th>
                            <th>Mulai Bekerja</th>
                            <th>Gaji Awal</th>
                            <th>Tunjangan</th>
                            <th>Total Gaji</th>
                            <th></th>
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
    <script type="module" src="{{ asset('js/crud/kelola-gaji.js') }}"></script>
@endpush
