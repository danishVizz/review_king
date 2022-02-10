@section('title', 'Customer Orders List')
@extends('layouts.admin')

@section('content')

<div class="content-wrapper">
    <div class="content-header row">
        
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Filter</h4>
        </div>
        <div class="card-body">

            @if (strpos(Request::path(), 'old_customer_orders') !== false)
                <form class="form" action="{{ route('old_customer_orders_filter') }}" method="POST">
            @else
                <form class="form" action="{{ route('customer_orders_filter') }}" method="POST">
            @endif
                @csrf
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input value="{{ isset($request_data['company_name'])? $request_data['company_name']: '' }}" type="text" id="company_name" class="form-control @error('company_name') is-invalid @enderror" placeholder="Company Name" name="company_name">
                            @error('company_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input value="{{ isset($request_data['phone_number'])? $request_data['phone_number']: '' }}" type="text" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Phone Number" name="phone_number">
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="content-body" style="background: #fff">
        
        @if (Session::has('message'))
            <div class="alert alert-success"><b>Success: </b>{{ Session::get('message') }}</div>
        @endif
        @if (Session::has('error_message'))
            <div class="alert alert-danger"><b>Sorry: </b>{{ Session::get('error_message') }}</div>
        @endif
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr #</th>
                        <th>Company Name</th>
                        <th>Phone Number</th>
                        <th>Total Orders</th>
                        {{-- <th>Stampcard Count</th> --}}
                        @php
                            if(strpos(Request::path(), 'old_customer_orders') !== false){
                                echo '<th>Renew Stampcard</th>';
                                echo '<th>Orders Detail</th>';
                            }else{
                                echo '<th>Stampcard Count</th>';
                                echo '<th>Stampcard</th>';
                            }
                        @endphp
                        <th>Created At</th>
                        <th>Updated At</th>
                        @if(strpos(Request::path(), 'old_customer_orders') !== false)
                            
                        @else
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (isset($data) && count($data)>0)
                        @foreach ($data as $key=>$item)
                        @php
                            $sr_no = $key + 1;
                            if ($data->currentPage()>1) {
                                $sr_no = ($data->currentPage()-1)*$data->perPage();
                                $sr_no = $sr_no + $key + 1;
                            }
                        @endphp
                            <tr>
                                <td>{{ $sr_no }}</td>
                                <td>{{ $item['user_name'] }}</td>
                                <td>{{ $item['phone_number'] }}</td>
                                <td>{{ $item['total_orders'] }}</td>
                                {{-- <td>{{ isset($item['stampcard_count']) && !empty($item['stampcard_count'])? nthNumber($item['stampcard_count']):nthNumber(1) }} Stampcard</td>"; --}}
                                @php
                                    if(strpos(Request::path(), 'old_customer_orders') !== false){
                                        echo  '<td>'.$item['stampcard_count'].' Time</td>';

                                        $ary = explode(',', $item['total_renew_orders']);
                                        $total_renew_orders = '';
                                        for ($i=0; $i < count($ary); $i++) { 
                                            $order_no = $i+1;
                                            if (!empty($total_renew_orders)) {
                                                // 'In your 1st stampcard you ordered 3'
                                                $total_renew_orders = $total_renew_orders.' and You have ordered '.$ary[$i].' in your '.nthNumber($order_no).' stampcard';
                                                // $total_renew_orders = $total_renew_orders.','.$ary[$i];
                                            }else{
                                                // $total_renew_orders = $ary[$i];
                                                $total_renew_orders = 'You have ordered '.$ary[$i].' in your '.nthNumber($order_no).' stampcard';
                                            }
                                        }
                                        echo  '<td>'.$total_renew_orders.'</td>';
                                    }else{
                                        // echo  '<td>'.isset($item['stampcard_count']) && !empty($item['stampcard_count'])? nthNumber($item['stampcard_count']):nthNumber(1) .' Stampcard</td>';

                                        $stampcard_count = 1;
                                        if (isset($item['stampcard_count']) && !empty($item['stampcard_count'])) {
                                            // if ($item['stampcard_count'] == 1) {
                                            //     $stampcard_count = 2;
                                            // }else{
                                                $stampcard_count = $item['stampcard_count'] + 1;
                                            // }
                                        }

                                        echo  '<td>'.nthNumber($stampcard_count).' Stampcard</td>';
                                        echo  '<td><a target="_blank" href="'. url('stampcard') .'/'.$item['slug'].'">View Stampcard</a></td>';

                                    }
                                @endphp
                                
                                <td>{{ date('M d, Y H:i A', strtotime($item['created_at'])) }}</td>
                                <td>{{ date('M d, Y H:i A', strtotime($item['updated_at'])) }}</td>
                                @if(strpos(Request::path(), 'old_customer_orders') !== false)
                                    
                                @else
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow waves-effect waves-float waves-light" data-toggle="dropdown">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item renew_stampcard" href="javascript:void(0);" data-phone-number="{{$item['phone_number']}}" data-user-id="{{$item['user_id']}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 mr-50"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                <span>Renew Stampcard</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                @endif
                                
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{-- {!! $data->links() !!} --}}
            {{ $data->links('vendor.pagination.bootstrap-4') }}
            
        </div>
    </div>
</div>
@endsection
