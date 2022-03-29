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
                            <p>Hello.... <strong id="user">{{ Auth()->user()->name }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Your Activity</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    @foreach ($data as $item)
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ date('d F Y', strtotime($item['date'])) }}</h4>
                                <h4>{{ count($item['logs']) }} Aktivitas</h4>
                            </div>
                            @foreach ($item['logs'] as $detailLog)
                                <div class="card-content">
                                    <div class="recent-message d-flex px-4 py-3">
                                        <div class="avatar avatar-lg">
                                            <img src="/vendors/mazer/dist/assets/images/faces/1.jpg" />
                                        </div>
                                        <div class="name ms-4">
                                            <div class="title">
                                                <h5>{{ $detailLog['context']['user_name'] }}</h5>
                                                <span><small>{{ \Carbon\Carbon::parse($detailLog['timestamp'])->diffForHumans() }}</small></span>
                                            </div>
                                            <p>{{ $detailLog['message'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('css')
<style>
    <style>
    .recent-message:hover {
        background-color: #f5f5f5;
    }
    .recent-message .name {
        width: 100%;
    }
    .name .title {
        display: flex;
        justify-content: space-between;
    }
</style>
</style>
@endpush
@push('script')
    <script type="text/typescript" src="{{ asset('ts/crud/index.ts') }}"></script>
    <script src="{{ asset('ts/compiler/typescript.min.js') }}"></script>
    <script src="{{ asset('ts/compiler/typescript.compile.min.js') }}"></script>
@endpush
