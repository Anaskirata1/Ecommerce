<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use PDF ;
use Notification ;
use App\Notifications\SendEmailNotification ;

class AdminController extends Controller
{
    public function view_category(){
        if(Auth::id()) {
            $data = category::all() ;
            return view('admin.category' , compact("data")) ;
        } else {
            return redirect('login') ;
        }

    }

    public function add_category(Request $request ){
       if(Auth::id()) {
        $data = new category ;


        $validated = $request->validate([
            'category' => 'required|min:3|max:255'

        ]);


        $data->category_name = $request->category ;
        $data->save();
        return redirect()->back()->with('message' , 'Category Added Successfully');
       } else return redirect('login') ;
    }

    public function delete_category($id){

       if(Auth::id()) {
        $data = category::find($id) ;

        $data->delete();

        return redirect()->back()->with('message' , 'Category Deleted Successfully');
       } else {
        return redirect('login') ;
       }
    }

    public function update_category($id){
       if(Auth::id()) {
        $data = category::find($id) ;
        return view('admin.update_category', compact('data')) ;
       } else {
        return redirect('login') ;
       }
    }
    public function update_category_confirm(Request $request , $id){
        $data = category::find($id) ;
        $data->category_name = $request->category ;
        $data->save();
        return redirect()->back();
    }


    public function view_product(){
        if(Auth::id()) {
            $category = category::all();
            return view('admin.product', compact('category')) ;
        } else {
            return redirect('login') ;
        }

    }

    public function add_product(Request $request){
      if(Auth::id()) {
        $product = new product ;

        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'category' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);



        $product->title = $request->title ;
        $product->description = $request->description ;
        $product->price = $request->price ;
        $product->quantity = $request->quantity ;
        $product->discount_price = $request->discount_price  ;
        $product->category_id = $request->category ;
        // add image to database
        $image = $request->image ;
        $imagename = time().'.'.$image->getClientOriginalExtension() ;
        $request->image->move('product' , $imagename ) ;

        $product->image =$imagename;
        $product->save();
        return redirect()->back()->with('message' , 'Product Added Successfully');
      } else{
        return redirect('login') ;
      }
    }

    public function show_product(){
        if(Auth::id()) {
            $category = category::all() ;
        $product = product::all();
        return view('admin.show_product' ,compact('product' , 'category')) ;
        } else {
            return redirect('login') ;
        }
    }
    public function delete_product($id){

       if(Auth::id()) {
        $data = product::find($id) ;
        $data->delete();
        return redirect()->back()->with('delete' , 'Product Deleted Successfully');;
       } else {
        return redirect('login') ;
       }

    }

    public function update_product($id){
       if(Auth::id()) {
        $category = category::all();
        $product = product::find($id) ;
        return view('admin.update_product' , compact('product' , 'category'));
       } else {
        return redirect('login') ;
       }
    }

    public function update_product_confirm(Request $request , $id){
        $product = product::find($id) ;

        $product->title = $request->title ;
        $product->description = $request->description ;
        $product->price = $request->price ;
        $product->quantity = $request->quantity ;
        $product->discount_price = $request->discount_price  ;
        $product->category = $request->category ;

        $image = $request->image ;
        if($image){
            $imagename = time().'.'.$image->getClientOriginalExtension() ;
            $request->image->move('product' , $imagename ) ;
            $product->image =$imagename;
        }


        $product->save();
        return redirect()->back()->with('message' , 'Product Updated Successfully');
    }
    public function order(){
        $order = order::all();
        return view('admin.order' , compact('order')) ;
    }

    public function delivered($id){
        $order = order::find($id) ;
        $order->delivery_status = 'delivered' ;
        $order->payment_status= 'paid' ;
        $order->save();
        return redirect()->back();
    }
    public function print_pdf(){
        $order = order::all();
        $pdf = PDF::loadView('admin.pdf' , compact('order'));

        return $pdf->download('order_details.pdf');

    }
    public function send_email($id){
        $order = order::find($id) ;
        return view('admin.email_info' , compact('order')) ;
    }
    public function send_user_email(Request $request , $id){
        $order = order::find($id);

        $details = [
            'greeting'  => $request->greeting,
            'firstline' => $request->firstline,
            'body'      => $request->body,
            'button'    => $request->button,
            'url'       => $request->url,
            'lastline'  => $request->lastline,

        ];
        Notification::send($order , new SendEmailNotification($details));
        return redirect()->back();
    }

    public function searchdata(Request $request){
        $searchText = $request->search ;
        $order = order::where('name' ,'LIKE' , "%$searchText%")->orWhere('product_title' ,'LIKE' , "%$searchText%")->get();
        return view('admin.order' , compact('order')) ;

    }
}
