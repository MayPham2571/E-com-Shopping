<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Models\Product;

use App\Models\Cart;

use App\Models\Order;

use Session;
use Stripe;

use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function index(){

        $product=Product::paginate(3);

        return view('home.userpage',compact('product'));
    }

    public function redirect(){

        $usertype=Auth::user()->usertype;

        if ($usertype=='1'){
            return view('admin.home');

        }else{
            $product=Product::paginate(3);

        return view('home.userpage',compact('product'));
        }
    }

    public function product_details($id){

        $product=product::find($id);

         return view('home.product_details', compact('product'));
    }

    public function add_cart(Request $request, $id){

        if(Auth::id()){

            $user=Auth::user();

            $product=product::find($id);

            $cart=new cart;

            $cart->name=$user->name;
            $cart->email=$user->email;
            $cart->phone=$user->phone;
            $cart->address=$user->address;
            $cart->user_id=$user->id;

            $cart->product_id=$product->id;
            $cart->product_title=$product->title;

            //if product has discount price
            if($product->discount_price!=null){

                $cart->price=$product->discount_price * $request->quantity;
            }
            else{ //if not

                $cart->price=$product->price * $request->quantity;
            }
            $cart->quantity=$request->quantity;

            
            $cart->image=$product->image;

            $cart->save();
            
            return redirect()->back();
        }
        
        else{

            return redirect('login');
        }

        
    }

    public function show_cart(){

        if(Auth::id()){

            $id=Auth::user()->id;

            $cart=cart::where('user_id','=',$id)->get();

            return view('home.show_cart', compact('cart'));
        }
        else{
            return redirect('login');
        }
        
        
    }

    public function remove_cart($id){

        $cart=cart::find($id);

        $cart->delete();

        return redirect()->back();
    }

    public function cash_order(){

        $user=Auth::user();

        $userid=$user->id;

        $data=cart::where('user_id','=', $userid)->get();

        foreach($data as $data){

            $order=new order;

            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->address=$data->address;
            $order->user_id=$data->user_id;

            $order->product_title=$data->product_title;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->image=$data->image;
            $order->product_id=$data->product_id;

            $order->payment_status='Cash on delivery';
            $order->delivery_status='Processing';

            $order->save();

            $cart_id=$data->id;

            $cart=cart::find($cart_id);

            $cart->delete();

        }

        return redirect()->back()->with('message','We have received your order and will connect with you soon!');
    
    }

    public function stripe($totalprice){

        return view('home.stripe', compact('totalprice'));
    }

    public function stripePost(Request $request): RedirectResponse
    {
        dd($request->all());

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
      
        $stripe->charges->create ([
                "amount" =>  $request->price*100,
                "currency" => "vnd",
                "source" => $request->stripeToken,
                "description" => "Thanks for payment." 
        ]);

        dd($request);
        
        return back()
                ->with('success', 'Payment successful!');
    }


}
// str_replace([',', '.'], ['', ''],