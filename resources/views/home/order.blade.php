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
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header');
         <!-- end header section -->



         @if (session()->has('message'))
         <div class="alert alert-success alert-dismissible fade show" role="alert">
             <strong>{{ session()->get('message') }}</strong>
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
     @endif

            <div class="table-responsive text-center align-item-center">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Product Title</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Payment Status</th>
                            <th>Delivery Status</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($order as $order )
                        <tr>
                            <td>{{ $order->product_title }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->price }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>
                                @if ($order->delivery_status == 'delivered')
                                    <p class="text-success"> {{ $order->delivery_status }}</p>
                                @else
                                {{ $order->delivery_status }}
                                @endif

                            </td>
                            <td style="max-width: 70px">
                                <img width="100%" src="product/{{ $order->image }}" alt="">
                            </td>
                            <td>
                                @if($order->delivery_status == 'processing')
                                <a onclick="return confirm('Are you shur?')" href="{{ url('cancle_order', $order->id) }}" class="btn btn-danger">Cancle</a>
                                @else

                                @endif
                            </td>

                        </tr>

                        @empty
                        <tr>
                            No Orders Yet
                        </tr>

                        @endforelse
                    </tbody>
                </table>
            </div>

      </div>


      <!-- footer start -->
     @include('home.footer') ;
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

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

