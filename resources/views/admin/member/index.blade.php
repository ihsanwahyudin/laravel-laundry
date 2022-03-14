@extends('layout.app')
@section('title', 'Data Member')
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
    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h3>Data Member</h3>
            </div>
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-between">
                    {{-- <button type="button" class="btn btn-primary ">Buat Data</button> --}}
                    <button type="button" class="btn btn-primary rounded-pill block" data-bs-toggle="modal" data-bs-target="#create-data-modal">
                        Buat Data
                    </button>
                    <span>
                        <a href="/member/export-excel" class="btn btn-primary rounded-pill">
                            Export
                        </a>
                        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#import-data-modal">
                            Import
                        </button>
                    </span>
                </div>
                <table class="table" id="member-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Jenis</th>
                            <th>Telepon</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </section>
    <!-- Basic Tables end -->
</div>
@include('admin.member.modal')
@endsection
@push('script')
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script type="module" src="{{ asset('js/crud/member.js') }}"></script>
    @if (session('success'))
        <script>
            Swal.fire({
        toast: true,
        title: "Success",
        text: '{{ session('success') }}',
        icon: 'success',
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    })
        </script>
    @endif
@endpush
