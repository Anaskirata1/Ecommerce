<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <base href="/public">
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
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')

      <div class="card mb-3" style="padding: 50px" >
        <div class="row g-0">
          <div class="col-md-4">
            <img src="product/{{ $product->image }}" alt="" width="100%">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title"> Product Title : {{ $product->title }}</h5>
              <p class="card-text"> Product Description : {{ $product->description }}</p>
              <p class="card-text"><small class="text-muted"> category:{{ $product->category->category_name }}</small></p>
              <h6>
                @if ($product->discount_price)
               <small><em> <del> ${{ $product->price }}</del></em></small>
                ${{  $product->discount_price}}
                @else ${{ $product->price }}
                @endif( )

               </h6>
               <p class="card-text"> avilable :{{ $product->quantity }}</p>

               <form action="{{ url('add_cart' , $product->id) }}" method="POST">
                        @csrf
                       <div class="">
                        <div class=""><input type="number" value="1" name="quantity" min="1" style="width: 70px"></div>
                        <div class="" style="margin: 0"> <input type="submit" value="Add to cart"></div>

                       </div>
                </form>
            </div>
          </div>
        </div>
      </div>

    </div>


      <!-- footer start -->
     @include('home.footer') ;
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2024 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

         </p>
      </div>
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
