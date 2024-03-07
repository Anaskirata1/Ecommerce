<section class="product_section layout_padding">
    <div class="container">
       <div class="heading_container heading_center">
          <h2>
             Our <span>products</span>
          </h2>
          <form action="{{ url('product_search') }}" method="GET">
            @csrf
            <input type="text" placeholder="Search" name="search">
            <input type="submit" value="search">
          </form>
       </div>

       @if (session()->has('message'))
       <div class="alert alert-success alert-dismissible fade show" role="alert">
           <strong>{{ session()->get('message') }}</strong>
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
           </button>
       </div>
   @endif
       <div class="row">
        @foreach ($product as $product )


          <div class="col-sm-6 col-md-4 col-lg-4">
             <div class="box">
                <div class="option_container">
                   <div class="options">
                      <a href="{{ url('product_details' , $product->id) }}" class="option1">
                        product details
                      </a>
                     <form action="{{ url('add_cart' , $product->id) }}" method="POST">
                        @csrf
                       <div class="row">
                        <div class="col-md-4"><input type="number" value="1" name="quantity" min="1" style="width: 70px"></div>
                        <div class="col-md-4"> <input type="submit" value="Add to cart"></div>

                       </div>
                     </form>
                   </div>
                </div>
                <div class="img-box">
                   <img src="product/{{ $product->image }}" alt="">
                </div>
                <div class="detail-box">
                   <h5>
                    {{ $product->title }}
                   </h5>
                   <h6>
                    @if ($product->discount_price)
                   <small><em> <del> ${{ $product->price }}</del></em></small>
                    ${{  $product->discount_price}}
                    @else ${{ $product->price }}
                    @endif( )

                   </h6>
                </div>
             </div>
          </div>
          @endforeach
       </div>

       <div class="btn-box">
          <a href="">
          View All products
          </a>
       </div>
    </div>
 </section>
