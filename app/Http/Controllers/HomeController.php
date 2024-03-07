<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Reply;
use Session;
use Stripe;

class HomeController extends Controller
{
    public function index(){
        $product = product::all();
        $comment = comment::all();
        $reply = reply::all();
        // $product = product::paginate(3);
        return view('home.userpage' , compact('product' , 'comment' , 'reply'));
    }
    public function redirect(){
        $usertype = Auth::user()->usertype;

        if($usertype == '1'){
            $total_product = product::all()->count();
            $total_order = order::all()->count();
            $total_user = user::all()->count();
            $order = order::all();
            $total_revenue = 0;
            foreach($order as $order){
                $total_revenue +=$order->price ;
            }
            $total_delivered = $order::where('delivery_status' ,'=' ,'delivered')->get()->count() ;
            $total_processing = $order::where('delivery_status', '=' ,'processing')->get()->count() ;
            return view('admin.home' , compact('total_product' ,'total_order' , 'total_user' , 'total_revenue','total_delivered','total_processing' ));
        }
        else {
            $product = product::all();
            $comment = comment::all();
            $reply = reply::all();

            return view('home.userpage' , compact('product' ,'comment' , 'reply' ));
        }
    }

    public function product_details($id){
        $product = product::find($id);
        return view('home.product_details' , compact('product'));
    }

    public function add_cart(Request $request ,$id){

        if(Auth::id()){
            $user = Auth::user();
            $userid = $user->id;
            $product = product::find($id) ;
            $product_exist_id = cart::where('product_id' , '=' , $id)->where('user_id' , '=' ,$userid )->get('id')->first() ;
            if($product_exist_id) {

                $cart = cart::find($product_exist_id)->first() ;
                $quantity = $cart->quantity ;
                $cart->quantity = $quantity + $request->quantity ;
                if($product->discount_price !=null){
                    $cart->price = $product->discount_price * $cart->quantity ;
                }
                else {
                    $cart->price = $product->price * $cart->quantity ;
                }
                $cart->save();
                Alert::success('Product Added Successfully', 'we have added product to your cart') ;
                return redirect()->back();


            } else{


            $cart = new cart ;

            $cart->name = $user->name ;
            $cart->email = $user->email ;
            $cart->phone = $user->phone ;
            $cart->address = $user->address ;
            $cart->user_id = $user->id ;
            $cart->product_title = $product->title ;

            if($product->discount_price !=null){
                $cart->price = $product->discount_price * $request->quantity ;
            }
            else {
                $cart->price = $product->price * $request->quantity ;
            }
            // $cart->price = $product->price ;
            $cart->image = $product->image ;
            $cart->product_id = $product->id ;
            $cart->quantity = $request->quantity ;

            $cart->save();
            return redirect()->back()->with('message' , 'Product Added Successfully');

            }


        }
        else {
            return redirect('login');
        }
    }

    public function show_cart(){
      if(Auth::id()) {
        $id = Auth::user()->id ;
        $cart = cart::where('user_id' , '=' , $id)->get();
        return view('home.show_cart' , compact('cart'));
      } else {
        return redirect('login');
      }
    }

    public function remove_cart($id){
        $cart = cart::find($id) ;

        $cart->delete();
        Alert::success('Product Deleted Successfully', 'we have deleted from your cart') ;
        return redirect()->back();
    }

    public function cash_order(){
        $user =Auth::user();
        $userid = $user->id ;

        $data = cart::where('user_id' , '=' ,$userid)->get() ;


        foreach($data as $data){
            $order = new Order ;

            $order->name = $data->name ;
            $order->email = $data->email ;
            $order->phone = $data->phone ;
            $order->address = $data->address ;
            $order->user_id = $data->user_id ;
            $order->product_title = $data->product_title ;
            $order->price = $data->price ;
            $order->quantity = $data->quantity ;
            $order->image = $data->image ;
            $order->product_id = $data->product_id ;

            $order->payment_status = 'cash on delivery';
            $order->delivery_status = 'processing' ;

            $order->save();
            $cart_id = $data->id ;
            $cart = cart::find($cart_id) ;
            $cart->delete();
        }
        return redirect()->back()->with('message' , 'We Have Received Your Order , We Will Connect With You soon');
    }
    public function stripe($totalprice){

        return view('home.stripe' , compact('totalprice')) ;
    }

    public function stripePost(Request $request , $totalprice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "thanks we are here for you"
        ]);

        $user =Auth::user();
        $userid = $user->id ;

        $data = cart::where('user_id' , '=' ,$userid)->get() ;


        foreach($data as $data){
            $order = new Order ;

            $order->name = $data->name ;
            $order->email = $data->email ;
            $order->phone = $data->phone ;
            $order->address = $data->address ;
            $order->user_id = $data->user_id ;
            $order->product_title = $data->product_title ;
            $order->price = $data->price ;
            $order->quantity = $data->quantity ;
            $order->image = $data->image ;
            $order->product_id = $data->product_id ;

            $order->payment_status = 'paid';
            $order->delivery_status = 'processing' ;

            $order->save();
            $cart_id = $data->id ;
            $cart = cart::find($cart_id) ;
            $cart->delete();
        }

        Session::flash('success', 'Payment successful!');

        return back();
    }

    public function show_order(){
        if(Auth::id()){

            $user = Auth::user() ;

            $userid = $user->id;

            $order = order::where('user_id' , '=' , $userid)->get();

            return view('home.order' , compact('order'));
        } else {
            return redirect('login');
        }
    }

    public function cancle_order($id){
        $order = order::find($id) ;
        $order->delete();
        return redirect()->back()->with('message' , 'Order Deleted Successfully');
    }
    public function add_comment(Request $request){

        if(Auth::id()){
            $user = Auth::user() ;

            $userid = $user->id;
            $username = $user->name ;
            $comment = new comment ;
            $comment->name = $username ;
            $comment->user_id = $userid ;
            $comment->comment = $request->comment ;
            $comment->save();
            return redirect()->back();

        } else{
            return redirect('login');
        }

    }
    public function add_reply(Request $request){

        if(Auth::id()){
            $user = Auth::user() ;

            $userid = $user->id;
            $username = $user->name ;
            $reply = new reply ;
            $reply->name = $username ;
            $reply->user_id = $userid ;
            $reply->reply = $request->reply ;
            $reply->comment_id  = $request->commentId ;
            $reply->save();
            return redirect()->back();

        } else{
            return redirect('login');
        }

    }

    public function product_search(Request $request){
        $comment = comment::all();
        $reply = reply::all();
        $search_name = $request->search ;
        $product = product::where('title' , 'LIKE' , "%$search_name%")->get() ;
        return view('home.userpage' , compact('product' , 'comment' , 'reply')) ;
    }

    public function product(){
        $product = product::all() ;
        $comment = comment::all();
        $reply = reply::all();
        return view('home.all_product' , compact('product' , 'comment' , 'reply'));
    }

    public function search_product(Request $request){
        $comment = comment::all();
        $reply = reply::all();
        $search_name = $request->search ;
        $product = product::where('title' , 'LIKE' , "%$search_name%")->get() ;
        return view('home.all_product' , compact('product' , 'comment' , 'reply')) ;
    }

    public function about(){
        return view('home.about') ;
    }
    public function blog(){
        return view('home.blog') ;
    }
    public function contact(){
        return view('home.contact') ;
    }
}
