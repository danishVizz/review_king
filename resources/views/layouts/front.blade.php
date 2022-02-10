<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Review King - @yield('title')</title>

    <style>
      .main_content{
          display: flex;
          align-items: center;
          height: 100vh;
          justify-content: center;
          min-height: 380px;
      }
      </style>
  </head>
  <body>
    <div class="main_content">
      @yield('content')
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
      $("body").on("click", ".gift_modal_btn", function () {
        // alert($(this).attr('gift_order_desc'));

        $('.gift_order_desc').html($(this).attr('gift_order_desc'));

        $("#giftOrderModal").modal("show");
      });

      
    $('#phone_no, #phone_number').on('keyup', function(){
      // console.log(this.value.length);

        // if(this.value.length == 4){
        //     this.value = this.value.replace(/(\d{2})\-?(\d{4})/,'$1-$2');
        // }
      
        // if (this.value.replace(/\D/g,'').length > 1) {
            if (this.value.indexOf('-') === -1) {
                if (this.value.indexOf('+') === -1) {
                    this.value = '+' + this.value.replace(/(\d{2})\-?(\d{4})\-?(\d{4})/,'$1-$2-$3');
                }else{
                    this.value = this.value.replace(/(\d{2})\-?(\d{4})\-?(\d{4})/,'$1-$2-$3');
                }
            }
        // } else if ( this.value.indexOf('-') !== -1 ) {
        //     this.value = this.value.replace(/(\+1|-)/g,'');
            // this.value = this.value.replace(/(\+1|+)/g,'');
        // }
    });

    $(".OnlyNumbers").keydown(function (event) {
            if (!(event.keyCode == 8                                // backspace
                || event.keyCode == 9                               // tab
                || event.keyCode == 17                              // ctrl
                || event.keyCode == 46                              // delete
                || (event.keyCode >= 35 && event.keyCode <= 40)     // arrow keys/home/end
                || (event.keyCode >= 48 && event.keyCode <= 57)     // numbers on keyboard
                || (event.keyCode >= 96 && event.keyCode <= 105)    // number on keypad
                || (event.keyCode == 65 && prevKey == 17 && prevControl == event.currentTarget.id))          // ctrl + a, on same control
            ) {
                event.preventDefault();     // Prevent character input
            }
            else {
                prevKey = event.keyCode;
                prevControl = event.currentTarget.id;
            }
        });
    
    </script>
  </body>
</html>