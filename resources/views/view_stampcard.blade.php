@section('title', 'View Stampcard')
@extends('layouts.front')

@section('content')

    <section class="content section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="card text-center">
                        <div class="card-header">
                            <h2><b>VIEW STAMPCARD</b></h2>
                        </div>
                        <div class="card-body">
                            
                            @if (Session::has('message'))
                                <div class="alert alert-success"><b>Success: </b>{{ Session::get('message') }}</div>
                            @endif
                            @if (Session::has('error_message'))
                                <div class="alert alert-danger"><b>Sorry: </b>{{ Session::get('error_message') }}</div>
                            @endif
                            <h3><b>ENTER YOUR PHONE NUMBER TO VIEW <br>YOUR STAMPCARD.</b></h3>
                            <br>
                            {{-- <div class="alert alert-success">Qr code is correct</div> --}}

                            <form method="POST" action="{{ route('check_view_stampcard') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8 col-8 offset-2">
                                        <div class="form-group">
                                            <label for="phone_number"><h5><b>Company</b></h5></label>
                                            <select type="text" id="company" class="form-control @error('company') is-invalid @enderror" name="company">
                                                <option value="">Choose an option</option>
                                                @if (isset($data['company']) && count($data['company'])>0)
                                                    @foreach ($data['company'] as $key => $value)
                                                        <option {{old('company')==$value->id || (isset($data->user_id) && $data->user_id == $value->id)? 'selected': ''}} value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('company')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
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