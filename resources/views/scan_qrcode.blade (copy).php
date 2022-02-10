@section('title', 'Dashboard')
@extends('layouts.admin')

@section('content')

<style>
    #qr_code_scan{
        background: #fff;
        box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.1);
        padding: 20px;
    }
    #qr_code_scan h2{
        margin-bottom: 15px;
    }
</style>

<div class="content-wrapper">
    <div class="content-body">
        <section id="qr_code_scan">
            
            <div class="row match-height">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center" style="display: block">
                    @if (isset($user_detail->id))
                        <h2><b>ENTER YOUR PHONE NUMBER TO COMPLETE <br>YOUR ORDER.</b></h2>
                        {{-- <div class="alert alert-success">Qr code is correct</div> --}}

                        <form method="POST" action="{{ route('ConfirmOrder') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-4 offset-4">
                                    <div class="form-group">
                                        <label for="phone_number"><b>Phone Number</b></label>
                                        <input value="{{old('phone_number')}}" type="text" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="+xy.........." name="phone_number">
                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Confirm</button>
                        </form>
                    @else
                        <div class="alert alert-danger">Qr code has been expired</div>
                    @endif
                </div>
            </div>

        </section>

    </div>
</div>
@endsection
