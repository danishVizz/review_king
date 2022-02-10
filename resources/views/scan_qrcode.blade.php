@section('title', 'QR CODE')
@extends('layouts.front')

@section('content')

    <section class="content section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="card text-center">
                        <div class="card-header">
                            <h2><b>QR CODE</b></h2>
                        </div>
                        <div class="card-body">
                            
                            @if (isset($user_detail->id))
                            <h3><b>ENTER YOUR PHONE NUMBER TO COMPLETE <br>YOUR ORDER.</b></h3>
                            <br>
                            {{-- <div class="alert alert-success">Qr code is correct</div> --}}

                            <form method="POST" action="{{ route('ConfirmOrder') }}">
                                @csrf
                                <input value="{{ $user_detail->id }}" type="hidden" name="company_id">
                                <div class="row">
                                    <div class="col-md-8 col-8 offset-2">
                                        <div class="form-group">
                                            <label for="phone_number"><h5><b>Phone Number</b></h5></label>
                                            <input minlength="13" maxlength="16" maxlength="16" value="{{old('phone_number')}}" type="text" id="phone_number" class="OnlyNumbers form-control @error('phone_number') is-invalid @enderror" placeholder="Enter phone number in digits with country code." name="phone_number">
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
                            <div class="alert alert-danger">Qr code has been expired.</div>
                        @endif

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