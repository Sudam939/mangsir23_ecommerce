<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        return view('frontend.profile');
    }
}
