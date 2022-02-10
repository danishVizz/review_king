
@section('title', 'Generate Qrcode')
@extends('layouts.front')

@section('content')

    <section class="content section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="card text-center">
                        <div class="card-header">
                            <h2><b>SCAN QRCODE FOR ORDER</b></h2>
                        </div>
                        <div class="card-body">
                          {{-- <h5 class="card-title">Special title treatment</h5>
                          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> --}}
                            {{ $qr_code }}
                            <br>
                            <br>
                            <a href="{{ $link }}" target="_blank">{{ $link }}</a>
                        </div>
                        <div class="card-footer text-muted">
                            {{-- <a href="#" class="btn btn-primary">Scan QR</a> --}}
                        </div>
                      </div>


                  
                </div>
              
            </div>
        </div>

    </section>

@endsection