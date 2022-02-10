@section('title', 'STAMP CARD')
@extends('layouts.front')
<style>
/* @import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,200;0,400;1,200&family=Open+Sans&display=swap'); */
@import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");

h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6 {
    margin-top: 0;
    margin-bottom: 0.5rem;
    font-weight: 500;
    line-height: 1.2; }


h3,p,li{
    font-family: "Nunito";
}


.section-padding {
    padding-top: 100px;
    padding-bottom: 100px;
}
.content .block h3, .content .block .h3 {
    margin-bottom: 30px;
    font-weight: 500;
    color: #161c2d;
}
.content .block p {
    line-height: 30px;
    color: #869ab8;
}
.content .block h3, .content .block .h3 {
    margin-bottom: 30px;
    font-weight: 500;
    color: #161c2d;
}
.content .block .bullet-list {
    margin-top: 20px;
}
.bullet-list li {
    position: relative;
    margin-left: 30px;
    margin-bottom: 20px;
    color: #869ab8;
}
.bullet-list li::after {
    position: absolute;
    content: "";
    background: #AEAED5;
    width: 12px;
    height: 12px;
    left: -30px;
    top: 6px;
    border-radius: 50px;
}
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
  }

  .card-body {
  
    background-color: #818881;
    padding: 50px;
  }
  .stem{
      font-size: 35px;
      color: white;
      font-family: "Nunito";
  }
  .mainbg{
      background-color: brown;
  }

  /* .col-lg-3.bg-white.border.my-5.mr-0 {
    margin-left: 62px;
} */
.btn.text-center {
    display: flex;
    justify-content: center;
    margin: 20px 0px;
}

button.btn.btn-success.text-center {
    font-size: 35px;
}

.row {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
    /* text-align: center; */
    justify-content: center;
}
.col-lg-3.col-md-4.col-xs-4.bg-white.border.my-5 {
    margin-left: 10px;
}
.col-3.bg-white.border.py-5 {
    border-radius: 14px;
}
/* mediq quries */
/* new css  */

/* css  */
body {
  background-color: #343a40;
}
.row1 {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 10px;
  margin: 10px 0;
}
.col-3new {
  background-color: #fff;
  text-align: center;
   padding: 30px;
  height: 80px;
  display: flex;
  justify-content: center;
  align-items: center;
}
img {
  width: 50px;
  height: 50px;
}
.h1-heading{
    font-size: 20px;
  overflow: hidden;
    text-overflow: ellipsis;   
    width: 100%;
}
@media(max-width: 767px){
   
    .h1-heading{
      font-size: 20px;
    }
  }


@media(max-width: 576px){
  .row1 {
    grid-template-columns: repeat(2, 1fr);    
  }
  .h1-heading{
    font-size: 12px;
  }
}

.cross_block{
    font-size: 40px;
    font-weight: bold;
}
.gift_block{
    font-size: 20px;
    font-weight: bold;
    text-transform: uppercase;
}



.gift_modal_btn{
  opacity: 0.8;
  transition: 0.3s;
}
.gift_modal_btn:hover{
    opacity: 1;
    text-decoration: none;
}
.gift_modal_btn:hover .text-dark{
    color: green !important;    
}

.main_content {
    min-height: calc(980px) !important;
}
</style>
@section('content')

    <section class="content section-padding">


      @php
          $have_orders = false;
          $stampcard_count = 1;
      @endphp

      @if (isset($data['customer_orders']) && count($data['customer_orders'])>0)
        @foreach ($data['customer_orders'] as $key => $value)

          @php
            $have_orders = true;
            if (isset($value->stampcard_count) && !empty($value->stampcard_count)) {
              // if ($value->stampcard_count == 1) {
              //     $stampcard_count = 2;
              // }else{
                  $stampcard_count = $value->stampcard_count + 1;
              // }
            }
            break;
          @endphp

        @endforeach
      @endif



        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="container bg-dark" style="padding: 20px;">
                        <h1 class="mainheading text-center text-white " style="text-transform: uppercase">
                          {{ nthNumber($stampcard_count) }}
                          STEMPLKARTE
                        </h1>
  
                        <!-- Modal -->
                        <div class="modal fade" id="giftOrderModal" tabindex="-1" role="dialog" aria-labelledby="giftOrderModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="giftOrderModalLabel">GIFT ORDER DETAIL</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                  <p class="gift_order_desc"></p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        @php
                            if(!$have_orders){
                              echo '<div class="alert alert-danger">Not have any order yet.</div>';
                            }
                        @endphp
                  
                        <div class="row1 secondrow1 align-items-stretch" style="    max-height: 100vh; overflow: auto;">
            
                            @php 
                                $order_no = 1;   
                            @endphp
                            @if (isset($data['customer_orders']) && count($data['customer_orders'])>0)
                                @foreach ($data['customer_orders'] as $key => $value)
                                    <div class="col-3new bg-white border  ">
                                        <div class="img text-center cross_block">
                                            X
                                        </div>
                                    </div>
            
                                    @php
                                        $posted_data = array();
                                        $posted_data['user_id'] = $value->user_id;
                                        $posted_data['order_number'] = $order_no;
                                        $posted_data['detail'] = true;
                                        $gift_orders = app('App\Models\Category')->getCategory($posted_data);
                                        // echo '<pre>';
                                        // print_r($gift_orders->toArray());
                                        // exit;
                                        if($gift_orders){
                                            // echo $order_no;
                                            echo '<a gift_order_desc="'.$gift_orders->description.'" href="javascript:(void)" class="gift_modal_btn"><div class="col-3new bg-white border">
                                                    <div class=" text-center">
                                                        <h1 class="mainheading text-center text-dark  h1-heading gift_block" style="
                                                            word-break: break-all;">
                                                            Gift Order
                                                        </h1>
                                                    </div>
                                                </div></a>';


                                              
                                                if(count($data['customer_orders']) == $gift_orders->order_number){
                                                  echo '<script>alert("Congratulations you recieved gift. ('.$gift_orders->description.')")</script>';
                                                }
                                        }
                                        $order_no++;   
                                    @endphp
            
                                @endforeach
                            @endif
            
            
                            @php
                              $last_count = count($data['customer_orders'])>6? count($data['customer_orders']): 6;
                              if(isset($data['last_gift']->order_number)){
                                  $last_count = $data['last_gift']->order_number;
                              }
                                // $last_count = count($data['customer_orders'])+2;
                                // if(isset($data['last_gift']->order_number)){
                                //     $last_count = $data['last_gift']->order_number + 2;
                                // }
                            @endphp
            
                            @if (isset($data['customer_orders']) && count($data['customer_orders'])>0)
                              @for ($i = count($data['customer_orders']); $i < $last_count; $i++)
                                  <div class="col-3new   bg-white border  "></div>
                                  @php
                                      $posted_data = array();
                                      $posted_data['user_id'] = $value->user_id;
                                      $posted_data['order_number'] = $order_no;
                                      $posted_data['detail'] = true;
                                      $gift_orders = app('App\Models\Category')->getCategory($posted_data);
                                      // echo '<pre>';
                                      // print_r($gift_orders->toArray());
                                      // exit;
                                      if($gift_orders){
                                          // echo $order_no;
                                              echo '<a gift_order_desc="'.$gift_orders->description.'" href="javascript:(void)" class="gift_modal_btn"><div class="col-3new bg-white border">
                                                      <div class=" text-center">
                                                      <h1 class="mainheading text-center text-dark  h1-heading gift_block" style="
                                                          word-break: break-all;">
                                                          Gift Order
                                                      </h1>
                                                      </div>
                                                  </div></a>';

                                                  if(count($data['customer_orders']) == $gift_orders->order_number){
                                                    echo '<script>alert("Congratulations you recieved gift. ('.$gift_orders->description.')")</script>';
                                                  }
                                      }
                                      $order_no++;   
                                  @endphp
                              @endfor
                            @endif
            
            
            
                          {{-- <div class="col-3new bg-white border  ">
                            <div class="img text-center">
                                X
                            </div>
                          </div>
                          <div class="col-3new   bg-white border ">
                            <div class="img text-center">
                              X
                            </div>
                          </div>
                          <div class="col-3new bg-white border">
                            <div class="img text-center">
                              X
                            </div>
                          </div>
                          <div class="col-3new bg-white border" style=" word-break: break-all;">
                         
                          </div>
                          <div class="col-3new   bg-white border  ">
                           
                          </div>
                          <div class="col-3new bg-white border">
                            <div class=" text-center">
                              <h1 class="mainheading text-center text-dark  h1-heading" style="
                                word-break: break-all;">
                                KOSTENLOS
                              </h1>
                            </div>
                          </div> --}}
                        </div>
                        <div class="btn text-center">
                        </div>
                    </div>
                    
                    {{-- <div class="card text-center">
                        <div class="card-header">
                            <h2><b>STAMP CARD</b></h2>
                        </div>
                        <div class="card-body">

                            @php
                             $order_no = 1;   
                            @endphp
                            @if (isset($data['customer_orders']) && count($data['customer_orders'])>0)
                                @foreach ($data['customer_orders'] as $key => $value)
                                    X

                                    @php
                                        $posted_data = array();
                                        $posted_data['user_id'] = Auth::user()->id;
                                        $posted_data['order_number'] = $order_no;
                                        $posted_data['detail'] = true;
                                        $gift_orders = app('App\Models\Category')->getCategory($posted_data);
                                        // echo '<pre>';
                                        // print_r($gift_orders->toArray());
                                        // exit;
                                        if($gift_orders){
                                            echo $order_no;
                                        }
                                        $order_no++;   
                                    @endphp

                                @endforeach
                            @endif


                            @php
                                $last_count = count($data['customer_orders'])+2;
                                if(isset($data['last_gift']->order_number)){
                                    $last_count = $data['last_gift']->order_number + 2;
                                }
                            @endphp

                            @for ($i = count($data['customer_orders']); $i < $last_count; $i++)
                                A
                                @php
                                    $posted_data = array();
                                    $posted_data['user_id'] = Auth::user()->id;
                                    $posted_data['order_number'] = $order_no;
                                    $posted_data['detail'] = true;
                                    $gift_orders = app('App\Models\Category')->getCategory($posted_data);
                                    // echo '<pre>';
                                    // print_r($gift_orders->toArray());
                                    // exit;
                                    if($gift_orders){
                                        echo $order_no;
                                    }
                                    $order_no++;   
                                @endphp
                            @endfor
                        </div>
                        <div class="card-footer text-muted">
                            <a href="#" class="btn btn-primary">Scan QR</a> 
                        </div>
                      </div> --}}


                  
                </div>
              
            </div>
        </div>

    </section>

@endsection