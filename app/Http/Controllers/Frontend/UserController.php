<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\EmailNotification;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDescription;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class UserController extends BaseController
{
    public function google_login()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback()
    {
        $user = Socialite::driver('google')->user();

        $find_user = User::where('google_id', $user->id)->first();

        $registered_user = User::where('email', $user->email)->first();
        if ($registered_user) {
            Auth::login($registered_user);
            return redirect('/dashboard');
        }

        if ($find_user) {
            Auth::login($find_user);
            return redirect('/dashboard');
        }
        $new_user = new User();
        $new_user->name = $user->name;
        $new_user->email = $user->email;
        $new_user->google_id = $user->id;
        $new_user->password = Hash::make(rand(100000, 999999));
        $new_user->save();
        Auth::login($new_user);
        return redirect('/dashboard');
    }


    public function add_to_cart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required|min:1',
        ]);
        $user_id = Auth::user()->id;
        $product = Product::findOrFail($request->product_id);
        $amount = $product->discount > 0 ? ($product->price - ($product->price * $product->discount) / 100) * $request->qty : $product->price * $request->qty;

        $cart = new Cart();
        $cart->user_id = $user_id;
        $cart->product_id = $request->product_id;
        $cart->qty = $request->qty;
        $cart->amount = $amount;
        $cart->save();

        toast('Product added to cart successfully', 'success');
        return redirect()->back();
    }

    public function cart()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $vendors = [];
        foreach ($carts as $cart) {
            $product = Product::findOrFail($cart->product_id);
            if (!in_array($product->vendor, $vendors)) {
                $vendors[] = $product->vendor;
            }
        }

        return view('frontend.cart', compact('carts', 'vendors'));
    }

    public function cart_delete($id)
    {
        Cart::findOrFail($id)->delete();
        return redirect()->back();
    }

    public function cart_update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|min:1',
        ]);
        $cart = Cart::find($id);
        $product = Product::findOrFail($cart->product_id);
        $amount = $product->discount > 0 ? ($product->price - ($product->price * $product->discount) / 100) * $request->qty : $product->price * $request->qty;

        $cart->qty = $request->qty;
        $cart->amount = $amount;
        $cart->update();

        toast('Cart updated successfully', 'success');
        return redirect()->back();
    }


    public function profile()
    {
        $shipping_addresses = ShippingAddress::where('user_id', Auth::user()->id)->get();
        $options = [
            'center' => [
                'lat' => 26.802828,
                'lng' => 87.283137
            ],
            'googleview' => true,
            'zoom' => 18,
            'zoomControl' => true,
            'minZoom' => 13,
            'maxZoom' => 18,
            'default' => 'Google Maps'
        ];
        $initialMarkers = [
            [
                'position' => [
                    'lat' => 26.802828,
                    'lng' => 87.283137
                ],
                'draggable' => false,
                'title' => 'Dharan'
            ]
        ];

        return view('frontend.profile', compact('shipping_addresses', 'options', 'initialMarkers'));
    }




    public function add_shipping_address(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'address_note' => 'required',
            'phone' => 'required',
        ]);
        $user_id = Auth::user()->id;

        $address = new ShippingAddress();
        $address->user_id = $user_id;
        $address->title = $request->title;
        $address->phone = $request->phone;
        $address->address_note = $request->address_note;
        $address->save();

        toast('Shipping address added successfully', 'success');
        return redirect()->back();
    }


    public function checkout($id)
    {
        return view('frontend.checkout', compact('id'));
    }


    public function order(Request $request, $id)
    {
        $total = 0;
        $user = Auth::user();
        $order = new Order();
        $vendor = Vendor::findOrFail($id);
        $order->user_id = $user->id;
        $order->shipping_address_id = $request->shipping_address;
        $order->payment_type = $request->payment_type;
        foreach ($user->carts as $cart) {
            if ($cart->product->vendor_id == $id) {
                $total += $cart->amount;
            }
        }
        $order->total_amount = $total;
        $order->save();


        foreach ($user->carts as $cart) {
            if ($cart->product->vendor_id == $id) {
                $orderD = new OrderDescription();
                $orderD->order_id = $order->id;
                $orderD->product_id = $cart->product_id;
                $orderD->qty = $cart->qty;
                $orderD->amount = $cart->amount;
                $orderD->save();

                $cart->delete();
            }
        }
        $admins = Admin::all();

        $data = [
            "subject" => "New Order",
            "to" => $user->email,
            "message" => "You have a new order from $user->name of $vendor->name. The order id is $order->id.",
        ];

        Mail::to($admins)->send(new EmailNotification($data));

        toast('Order Placed successfully', 'success');
        return redirect()->back();
    }
}
