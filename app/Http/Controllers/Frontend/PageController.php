<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\EmailNotification;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class PageController extends BaseController
{

    public function home()
    {
        $vendors = Vendor::where('status', 'approved')->get();
        $products = Product::where('discount', '!=', null || 0)->limit(16)->get();
        return view('frontend.home', compact('vendors', 'products'));
    }

    public function compare(Request $request)
    {
        $q = $request->q;
        $products = Product::where('name', 'like', "%$q%")->orderBy('price', 'asc')->get();
        return view('frontend.compare', compact('products', 'q'));
    }

    public function vendor_request(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:vendors',
            'phone' => 'required|unique:shops|digits:10',
            'shop_name' => 'required',
        ]);

        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->password = Hash::make('codeit123');
        $vendor->save();

        $shop = new Shop();
        $shop->name = $request->shop_name;
        $shop->phone = $request->phone;
        $shop->vendor_id = $vendor->id;
        $shop->save();

        $data = [
            "subject" => "New Vendor Request",
            "to" => "Sudam",
            "message" => "Vendor request received from $request->name  with email $request->email and phone $request->phone and shop name $request->shop_name",
        ];

        $admins = Admin::all();
        Mail::to($admins)->send(new EmailNotification($data));

        toast('Your request has been submitted successfully', 'success');
        return redirect()->back();
    }

    public function vendor(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $products = $vendor->products;
        $q = $request->q;
        if ($q) {
            $products = Product::where('name', 'like', "%$q%")->orderBy('price', 'asc')->get();
        }
        return view('frontend.vendor', compact('vendor', 'products'));
    }
}
