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
</div>
@endsection
