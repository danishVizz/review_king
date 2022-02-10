

@section('title', 'Update Profle')
@extends('layouts.admin')

@section('content')

<div class="content-wrapper">
    <div class="content-header row">
        
    </div>
    <div class="content-body">
        <section id="multiple-column-form">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update Profile</h4>
                        </div>
                        <div class="card-body">
                            @if (Session::has('message'))
                                <div class="alert alert-success"><b>Success: </b>{{ Session::get('message') }}</div>
                            @endif
                            @if (Session::has('error_message'))
                                <div class="alert alert-danger"><b>Sorry: </b>{{ Session::get('error_message') }}</div>
                            @endif


                            <form class="form" action="{{ route('update_profile') }}" method="post">
                            @method('PUT')
                            @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input value="{{old('name', isset($data->name)? $data->name: '')}}" type="text" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input {{ isset($data->email)? 'disabled': '' }} value="{{old('email', isset($data->email)? $data->email: '')}}" type="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="text" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="text" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Confirm Password" name="confirm_password">
                                            @error('confirm_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="phone_no">Phone Number</label>

                                            <input minlength="13" maxlength="16" value="{{old('phone_no', isset($data->phone_no)? $data->phone_no: '')}}" type="text" id="phone_no" class="OnlyNumbers form-control @error('phone_no') is-invalid @enderror" placeholder="Enter phone number in digits with country code." name="phone_no">
                                            @error('phone_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="rating_link">Rating Link</label>
                                            <input value="{{old('rating_link', isset($data->rating_link)? $data->rating_link: '')}}" type="text" id="rating_link" class="form-control @error('rating_link') is-invalid @enderror" placeholder="Rating Link" name="rating_link">
                                            @error('rating_link')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
