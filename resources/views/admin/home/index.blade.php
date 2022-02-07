@extends('layout.app')
@section('title', 'Home')
@section('main')
<div class="page-heading">
    <h3>Home</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p>Hello.... <strong>{{ Auth()->user()->name }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
