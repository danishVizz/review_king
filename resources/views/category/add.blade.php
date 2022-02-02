

@if (isset($data->id))
    @section('title', 'Update Deal')
@else
    @section('title', 'Add Deal')
@endif
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
                            <h4 class="card-title">{{ isset($data->id)? 'Update':'Add' }} Deal Detail</h4>
                        </div>
                        <div class="card-body">
                            @if (Session::has('message'))
                                <div class="alert alert-success"><b>Success: </b>{{ Session::get('message') }}</div>
                            @endif
                            @if (Session::has('error_message'))
                                <div class="alert alert-danger"><b>Sorry: </b>{{ Session::get('error_message') }}</div>
                            @endif

                            @if (isset($data->id))
                                <form class="form" action="{{ route('category.update', $data->id) }}" method="post">
                                @method('PUT')
                                
                            @else
                                <form class="form" action="{{ route('category.store') }}" method="POST">
                                
                            @endif
                                @csrf
                                <div class="row">
                                    @if (Auth::user()->role == 1)
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="company">Company</label>
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
                                    @endif
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
                                            <label for="order_number">Order #</label>
                                            <input value="{{old('order_number', isset($data->order_number)? $data->order_number: '')}}" type="number" id="order_number" class="form-control @error('order_number') is-invalid @enderror" placeholder="Order #" name="order_number">
                                            @error('order_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textArea type="text" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Description" name="description">{{old('description', isset($data->description)? $data->description: '')}}</textArea>
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light">{{ isset($data->id)? 'Update':'Add' }}</button>

                                        @if (isset($data->id))
                                        @else
                                            <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                        @endif
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
