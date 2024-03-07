<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Ecommerce</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
      <!-- font awesome style -->
      <link href="home/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="home/css/style.css" rel="stylesheet" />
      <!-- responsive style -->
      <link href="home/css/responsive.css" rel="stylesheet" />
   </head>
   <body>
    @include('sweetalert::alert')
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
         @if (session()->has('message'))
         <div class="alert alert-success alert-dismissible fade show" role="alert">
             <strong>{{ session()->get('message') }}</strong>
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
     @endif


         <table class="table table-dark table-striped text-center">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Product Title</td>
                    <td>Product Quantity</td>
                    <td>Price</td>
                    <td>Image</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0 ?>
                <?php $totalprice = 0 ?>
                @foreach ($cart as $cart )
                <?php $i++ ?>
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $cart->product_title }}</td>
                    <td>{{ $cart->quantity }}</td>
                    <td>${{ $cart->price }}</td>
                    <td style="width: 70px"><img src="product/{{ $cart->image }}" alt="" width="100%"></td>
                    <td><a onclick="return confirm('Are you shur?')" href="{{ url('remove_cart' , $cart->id) }}" class="btn btn-danger">Remove</a></td>
                </tr>
                <?php $totalprice += $cart->price   ?>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total : ${{ $totalprice }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
          </table>

          <div class="text-center">
            <h3 style="font-size: 25px ; padding-bottom:25px">Proceed to order</h3>
            <a href="{{ url("cash_order") }}" class="btn btn-danger">Cash On Delivery</a>
            <a href="{{ url('stripe',$totalprice ) }}" class="btn btn-danger">Pay Using Card</a>
          </div>

      </div>



      <!-- footer start -->
     @include('home.footer') ;
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2024 All Rights Reserved<br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

         </p>
      </div>

<script>
    function confirmation(ev) {
      ev.preventDefault();
      var urlToRedirect = ev.currentTarget.getAttribute('href');
      console.log(urlToRedirect);
      swal({
          title: "Are you sure to cancel this product",
          text: "You will not be able to revert this!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
      })
      .then((willCancel) => {
          if (willCancel) {



              window.location.href = urlToRedirect;

          }


      });


  }
</script>
      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>
