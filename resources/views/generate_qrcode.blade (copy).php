@section('title', 'Dashboard')
@extends('layouts.admin')

@section('content')

<style>
#qr_code_scan {
    background: #fff;
    box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.1);
    padding: 20px;
}

#qr_code_scan h2 {
    margin-bottom: 15px;
}
</style>

<div class="content-wrapper">
    <div class="content-body">
        <section id="qr_code_scan">

            <div class="row match-height">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center" style="display: block">
                    <h2><b>SCAN QRCODE</b></h2>
                    {{ $qr_code }}
                    <br>
                    <br>
                    {{ $link }}
                </div>
            </div>

        </section>

    </div>
</div>
@endsection