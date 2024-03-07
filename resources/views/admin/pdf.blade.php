<div class="main-panel">
    <div class="content-wrapper">
        <h2 class="text-center mb-2">All Orders</h2>

     <div class="cont">
        <table class="center table table-dark table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    {{-- <th>Phone</th> --}}
                    <th>Address</th>
                    <th>Product Title</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($order as $order )
                <tr>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->email }}</td>
                    {{-- <td>{{ $order->phone }}</td> --}}
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->product_title }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->price }}</td>
                    <td>{{ $order->payment_status }}</td>
                    <td>{{ $order->delivery_status }}</td>
                    <td>
                        @if ($order->delivery_status =='processing')
                        <a href="{{ url('delivered' , $order->id) }}" onclick="return confirm('Are you shur?')" class="btn btn-primary">Delivered</a>
                        @else
                        <p class="text-success">Done</p>
                        @endif
                    </td>



                </tr>
                @endforeach
            </tbody>
        </table>
     </div>
    </div>
</div>
