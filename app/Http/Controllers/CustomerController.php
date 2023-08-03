<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use App\Models\SubscribedEmailModel;
use App\Models\ContactModel;
use App\Models\Wishlists;
use App\Models\Products;
use App\Models\Orders;
use App\Models\OrderBillingAddress;
use App\Models\OrderDetails;
use App\Models\VistorOrders;
use App\Models\VistorOrderDetails;
use App\Models\Carts;
use App\Models\Currencies;
use App\Models\SentMails;
use App\Models\Reviews;
use App\Models\Coupons;
use App\Models\UsedCoupons;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Coupon;

class CustomerController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'subscriber_email' => 'required'
        ]);
        $email = new SubscribedEmailModel();
        $emailExist = SubscribedEmailModel::where('emails', '=', $request->subscribeemail)->get();
        if (empty($emailExist->toArray())) {
            $email->emails = $request->subscribeemail;
            $email->save();
            return response()->json([
                'success' => true,
                'message' => 'Congrats! you Subscribed.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You Subscribed Already.'
            ]);
        }
    }
    public function signUp(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'email' => 'required|email'
        ]);
        $usernameExist = Customers::where('username', '=', $request->username)->get();
        if (empty($usernameExist->toArray())) {
            $emailExist = Customers::where('email_addr', '=', $request->email)->get();
            if (empty($emailExist->toArray())) {
                $customer = new Customers();
                $customer->username = $request['username'];
                $customer->first_name = $request['f_name'];
                $customer->last_name = $request['l_name'];
                $customer->email_addr = $request['email'];
                $customer->password = md5($request['password']);
                $customer->status = "Active";
                if ($customer->save()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Successfully Registered.'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Try Again.'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Email Already Register.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Username Taken.'
            ]);
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'cpassword' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        $customerData = Customers::where('email_addr', '=', $request->email)->get();
        $customerData = $customerData->toArray();
        if ($customerData[0]['password'] == md5($request['cpassword'])) {
            $customer = Customers::where('email_addr', '=', $request->email)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => md5($request->password)
            ]);
            if ($customer) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile Updated.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again Later.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Password Not Matched'
            ]);
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $username = $request['email'];
        $password = md5($request['password']);
        $customer = Customers::where(function ($query) use ($username) {
            $query->where('email_addr', '=', $username)
                ->orWhere('username', '=', $username);
        })->where('password', '=', $password)->where('status', '=', 'Active')->get();
        $customer = $customer->toArray();
        if (!empty($customer)) {
            $data = array();
            $data['user_id'] = $customer[0]['id'];
            $data['user_name'] = $customer[0]['username'];
            $data['f_name'] = $customer[0]['first_name'];
            $data['l_name'] = $customer[0]['last_name'];
            $data['email'] = $customer[0]['email_addr'];
            session()->put('customer', $data);
            return response()->json([
                'success' => true,
                'message' => 'Successfully Logged In.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email Or Password'
            ]);
        }
    }
    public function logout()
    {
        session()->forget('customer');
        return redirect('/');
    }
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'product_price' => 'required',
            'product_qty' => 'required'
        ]);
        if (session()->has('customer')) {
            $p_id = $request->product_id;
            $u_id = session()->get('customer.user_id');
            $check = Carts::where(function ($query) use ($p_id, $u_id) {
                $query->where('customers_id', '=', $u_id)->where('products_id', '=', $p_id);
            })->get();
            if (count($check) == 0) {
                $cart = new Carts();
                $cart->customers_id = $u_id;
                $cart->products_id = $p_id;
                $cart->price = $request->product_price;
                $cart->qty = $request->product_qty;
                if ($cart->save()) {
                    $check = Carts::where(function ($query) use ($u_id) {
                        $query->where('customers_id', '=', $u_id);
                    })->get();
                    return response()->json([
                        'success' => true,
                        'message' => 'Item Added To Cart.',
                        'qty' => count($check)
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Try Again.'
                    ]);
                }
            } else {
                $check = $check->toArray();
                $new_price = $check[0]['price'] + $request->price;
                $new_qty = $check[0] + $request->qty;
                $update = Carts::where(function ($query) use ($p_id, $u_id) {
                    $query->where('customers_id', '=', $u_id)->where('products_id', '=', $p_id);
                })->update(['price' => $new_price, 'qty' => $new_qty]);
                if ($update) {
                    $qty = Carts::where(function ($query) use ($u_id) {
                        $query->where('customers_id', '=', $u_id);
                    })->get();
                    return response()->json([
                        'success' => true,
                        'message' => 'Item Added To Cart.',
                        'qty' => count($qty)
                    ]);
                } else {
                    return response()->json([
                        'success' => true,
                        'message' => 'Try Again.'
                    ]);
                }
            }
        } else {
            $cart = array();
            $cart['products_id'] = $request->product_id;
            $cart['qty'] = $request->product_qty;
            $cart['price'] = $request->product_price;
            if (session()->has('cart')) {
                $carts = session()->get('cart');
                if (in_array($request->product_id, array_column($carts, 'product_id'))) {
                    $index = array_search($request->product_id, array_column($carts, 'product_id'));
                    $carts[$index]['qty'] = $carts[$index]['qty'] + $cart['qty'];
                    $carts[$index]['price'] = $carts[$index]['price'] + $cart['price'];
                    session()->put('cart', $carts);
                    return response()->json([
                        'success' => true,
                        'message' => 'Item Added To Cart.',
                        'qty' => count(session()->get('cart'))
                    ]);
                } else {
                    session()->push('cart', $cart);
                    return response()->json([
                        'success' => true,
                        'message' => 'Item Added To Cart.',
                        'qty' => count(session()->get('cart'))
                    ]);
                }
            } else {
                session()->push('cart', $cart);
                return response()->json([
                    'success' => true,
                    'message' => 'Item Added To Cart.',
                    'qty' => count(session()->get('cart'))
                ]);
            }
        }
    }
    public function addToCartPage(Request $request)
    {
        if (session()->has('customer')) {
            $products = json_decode($request->products);
            $u_id = session()->get('customer.user_id');
            foreach ($products as $product) {
                $p_id = $product->id;
                $carts = Carts::where(function ($query) use ($p_id, $u_id) {
                    $query->where('customers_id', '=', $u_id)->where('products_id', '=', $p_id);
                })->get();
                foreach ($carts as $cart) {
                    Carts::where(function ($query) use ($p_id, $u_id) {
                        $query->where('customers_id', '=', $u_id)->where('products_id', '=', $p_id);
                    })->update(['qty' => $product->qty, 'price' => $product->qty * $product->price]);
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'Cart Updated.'
            ]);
        } else {
            if (session()->has('cart')) {
                $products = json_decode($request->products);
                session()->forget('cart');
                $carts = array();
                foreach ($products as $product) {
                    $a['products_id'] = $product->id;
                    $a['qty'] = $product->qty;
                    $a['price'] = $product->qty * $product->price;
                    array_push($carts, $a);
                }
                session()->put('cart', $carts);
                return response()->json([
                    'success' => true,
                    'message' => 'Cart Updated.'
                ]);
            }
        }
    }
    public function delete_cart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);
        if (session()->has('customer')) {
            $p_id = $request->product_id;
            $u_id = session()->get('customer.user_id');
            $check = Carts::where(function ($query) use ($p_id, $u_id) {
                $query->where('customers_id', '=', $u_id)->where('products_id', '=', $p_id);
            })->get();
            if (count($check) > 0) {
                $delete = Carts::where(function ($query) use ($p_id, $u_id) {
                    $query->where('customers_id', '=', $u_id)->where('products_id', '=', $p_id);
                })->delete();
                if ($delete) {
                    $check = Carts::where(function ($query) use ($u_id) {
                        $query->where('customers_id', '=', $u_id);
                    })->get();
                    return response()->json([
                        'success' => true,
                        'message' => 'Item Deleted From Cart.',
                        'qty' => count($check)
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Try Again.',
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item Not To Found.',
                ]);
            }
        } else {
            if ((session()->has('cart'))) {
                $carts = session()->get('cart');
                $index = 0;
                $res = 0;
                for ($i = 0; $i < count($carts); $i++) {
                    if ($request->product_id == $carts[$i]['products_id']) {
                        $index = $i;
                        $res = 1;
                    }
                }
                unset($carts[$index]);
                session()->forget('cart');
                session()->put('cart', $carts);
                if ($res == 1) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item Deleted From Cart.',
                        'qty' => count(session()->get('cart'))
                    ]);
                } else {
                    return response()->json([
                        'success' => true,
                        'message' => 'Try Again.'
                    ]);
                }
            }
        }
    }
    public function addToWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);
        if (session()->has('customer')) {
            $p_id = $request->product_id;
            $u_id = session()->get('customer.user_id');
            $check = Wishlists::where(function ($query) use ($p_id, $u_id) {
                $query->where('customers_id', '=', $u_id)->where('products_id', '=', $p_id);
            })->get();
            if (count($check) == 0) {
                $wishlist = new Wishlists();
                $wishlist->customers_id = $u_id;
                $wishlist->products_id = $p_id;
                if ($wishlist->save()) {
                    $check = Wishlists::where(function ($query) use ($u_id) {
                        $query->where('customers_id', '=', $u_id);
                    })->get();
                    return response()->json([
                        'success' => true,
                        'message' => 'Item Added To Wishlist.',
                        'qty' => count($check)
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Item Already In Wishlist.'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item Already In Wishlist.'
                ]);
            }
        } else {
            $wishlist = array();
            $wishlist['products_id'] = $request->product_id;
            if ((session()->has('wishlist'))) {
                if (in_array($request->product_id, array_column(session()->get('wishlist'), 'products_id'))) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Item Already In Wishlist.'
                    ]);
                } else {
                    session()->push('wishlist', $wishlist);
                    return response()->json([
                        'success' => true,
                        'message' => 'Item Added To Wishlist.',
                        'qty' => count(session()->get('wishlist'))
                    ]);
                }
            } else {
                session()->push('wishlist', $wishlist);
                return response()->json([
                    'success' => true,
                    'message' => 'Item Added To Wishlist.',
                    'qty' => count(session()->get('wishlist'))
                ]);
            }
        }
    }
    public function delete_wishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);
        if (session()->has('customer')) {
            $p_id = $request->product_id;
            $u_id = session()->get('customer.user_id');
            $check = Wishlists::where(function ($query) use ($p_id, $u_id) {
                $query->where('customers_id', '=', $u_id)->where('products_id', '=', $p_id);
            })->get();
            if (count($check) > 0) {
                $delete = Wishlists::where(function ($query) use ($p_id, $u_id) {
                    $query->where('customers_id', '=', $u_id)->where('products_id', '=', $p_id);
                })->delete();
                if ($delete) {
                    $check = Wishlists::where(function ($query) use ($u_id) {
                        $query->where('customers_id', '=', $u_id);
                    })->get();
                    return response()->json([
                        'success' => true,
                        'message' => 'Item Deleted From Wishlist.',
                        'qty' => count($check)
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Try Again.',
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item Not To Found.',
                ]);
            }
        } else {
            if ((session()->has('wishlist'))) {
                $wishlist = session()->get('wishlist');
                $index = 0;
                $res = 0;
                for ($i = 0; $i < count($wishlist); $i++) {
                    if ($request->product_id == $wishlist[$i]['products_id']) {
                        $index = $i;
                        $res = 1;
                    }
                }
                unset($wishlist[$index]);
                session()->forget('wishlist');
                session()->put('wishlist', $wishlist);
                if ($res == 1) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item Deleted From Wishlist.',
                        'qty' => count(session()->get('cart'))
                    ]);
                } else {
                    return response()->json([
                        'success' => true,
                        'message' => 'Try Again.'
                    ]);
                }
            }
        }
    }
    public function contact_Us(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'telephone' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ]);
        $contact = new ContactModel();
        $contact->name = $request['name'];
        $contact->email = $request['email'];
        $contact->phone = $request['telephone'];
        $contact->subject = $request['subject'];
        $contact->message = $request['message'];
        $contact->save();
        return response()->json([
            'success' => true,
            'message' => 'Message Sent.'
        ]);
    }

    public function update_billing_address(Request $request)
    {
        $request->validate([
            'billing_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required',
            'phone' => 'required',
        ]);
        $customer = Customers::where('id', '=', session()->get('customer.user_id'))->update([
            'contact_number' => stripslashes($request->first_name),
            'address1' => $request->billing_address,
            'address2' => !empty($request->billing_address2) ? stripslashes($request->billing_address2) : '',
            'city' => stripslashes($request->city),
            'state' => stripslashes($request->state),
            'postal_code' => stripslashes($request->zipcode),
            'contact_number' => stripslashes($request->phone)
        ]);
        if ($customer) {
            return response()->json([
                'success' => true,
                'message' => 'Billing Add Updated.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Try Again Later.'
            ]);
        }
    }

    public function customer_order(Request $request)
    {
        if (session()->has('customer')) {
            $item = 0;
            $bill = 0;
            $coupons_id='';
            $carts = Carts::where('customers_id', '=', session()->get('customer.user_id'))->get();
            foreach ($carts as $cart) {
                $item += $cart->qty;
                $bill += $cart->price;
            }
            if(!empty($request->coupon)){
                $coupon=Coupons::where('coupon','=',$request->coupon)->where('status','=','Active')->first();
                $coupons_id=$coupon->id;
                if($coupon->discount_amount>0 ){
                    $new_bill=floatval($bill)-floatval($coupon->discount_amount);
                    $bill=$new_bill;
                }else{
                    $new_bill=floatval($bill)-floatval(($bill*$coupon->discount_percentage)/100);
                    $bill=$new_bill;
                }
            }
            $order = new Orders();
            $order->customers_id = session()->get('customer.user_id');
            $order->note = $request->note;
            $order->bill = $bill;
            $order->item = $item;
            $order->payment_method = $request->payment_option;
            if (isset($request->other)) {
                $order->is_same_as_billing = 0;
            }
            if ($order->save()) {
                foreach ($carts as $cart) {
                    $order_detail = new OrderDetails();
                    $order_detail->orders_id = $order->id;
                    $order_detail->products_id = $cart->products_id;
                    $order_detail->qty = $cart->qty;
                    $order_detail->sub_bill = $cart->price;
                    if ($order_detail->save()) {
                        Carts::where('customers_id', '=', session()->get('customer.user_id'))->where('products_id', '=', $cart->products_id)->delete();
                    }
                }
                if (isset($request->other)) {
                    $order_address = new OrderBillingAddress();
                    $order_address->orders_id = $order->id;
                    $order_address->address1 = $request->o_billing_address;
                    $order_address->address2 = $request->o_billing_address2;
                    $order_address->city = $request->o_city;
                    $order_address->state = $request->o_state;
                    $order_address->postal_code = $request->o_zipcode;
                    $order_address->save();
                }
                Mail::to(session()->get('customer.email'))->send(new \App\Mail\OrderMail("SDRO" . $order->id, "New Order"));
                if (Mail::flushMacros()) {
                    if(!empty($request->coupon)){
                        $used_coupon = new UsedCoupons();
                        $used_coupon->email=session()->get('customer.email');
                        $used_coupon->coupons_id=$coupons_id;
                        $used_coupon->save();
                    }
                    session()->put('order_id','SDRO'.$order->id);
                    if($request->payment_option=="Paypal"){
                        $provider = new PaypalClient;
                        $provider->setApiCredentials(config('paypal'));
                        $token = $provider->getAccessToken();
                        $response = $provider->createOrder([
                            "intent" => "CAPTURE",
                            "application_context" => [
                                "return_url" => route('payment.success'),
                                "cancel_url" => route('payment.unsuccess')
                            ],
                            "purchase_units" => [
                                0 => [
                                    "amount" => [
                                        "currency_code" => "GBP",
                                        "value" => $bill
                                    ]
                                ]
                            ]
                        ]);
                        if (isset($response['id']) && $response != null) {
                            foreach ($response['links'] as $links) {
                                if ($links['rel'] == 'approve') {
                                    return redirect()->away($links['href']);
                                }
                            }
                            notify()->info('Contact Admin for further Detail', '', 'topRight');
                            return url('/');
                        } else {
                            notify()->error($response['error']['message'], '', 'topRight');
                            return url('/');
                        }
                    }else{ 
                        session()->put('order_bill',$bill);
                        return redirect(route('stripe.form'));
                    }
                } else {
                    $sent_mail = new SentMails();
                    $sent_mail->mail = session()->get('customer.email');
                    $sent_mail->name = session()->get('customer.f_name') . ' ' . session()->get('customer.l_name');
                    $sent_mail->subject = "Order Confirmation";
                    $sent_mail->order_number = "SDRO" . $order->id;
                    $sent_mail->bill = $bill;
                    $sent_mail->save();
                    if (!empty($request->coupon)) {
                        $used_coupon = new UsedCoupons();
                        $used_coupon->email=session()->get('customer.email');
                        $used_coupon->coupons_id=$coupons_id;
                        $used_coupon->save();
                    }
                    session()->put('order_id','SDRO'.$order->id);
                    if($request->payment_option=="Paypal"){                        
                        $provider = new PaypalClient;
                        $provider->setApiCredentials(config('paypal'));
                        $token = $provider->getAccessToken();
                        $response = $provider->createOrder([
                            "intent" => "CAPTURE",
                            "application_context" => [
                                "return_url" => route('payment.success'),
                                "cancel_url" => route('payment.unsuccess')
                            ],
                            "purchase_units" => [
                                0 => [
                                    "amount" => [
                                        "currency_code" => "GBP",
                                        "value" => $bill
                                    ]
                                ]
                            ]
                        ]);
                        if (isset($response['id']) && $response != null) {
                            foreach ($response['links'] as $links) {
                                if ($links['rel'] == 'approve') {
                                    return redirect()->away($links['href']);
                                }
                            }
                            notify()->info('Contact Admin for further Detail', '', 'topRight');
                            return url('/');
                        } else {
                            notify()->error($response['error']['message'], '', 'topRight');
                            return url('/');
                        }
                    }else{
                        session()->put('order_bill',$bill);
                        return redirect(route('stripe.form'));
                    }
                }
            } else {
                notify()->error('Try Again.', '', 'topRight');
                return redirect()->back();
            }
        } else {
            $item = 0;
            $bill = 0;
            $coupons_id='';
            $carts = session()->get('cart');
            foreach ($carts as $cart) {
                $item += $cart['qty'];
                $bill += $cart['price'];
            }
            if(!empty($request->coupon)){
                $coupon=Coupons::where('coupon','=',$request->coupon)->where('status','=','Active')->first();
                $coupons_id=$coupon->id;
                if($coupon->discount_amount>0 ){
                    $new_bill=floatval($bill)-floatval($coupon->discount_amount);
                    $bill=$new_bill;
                }else{
                    $new_bill=floatval($bill)-floatval(($bill*$coupon->discount_percentage)/100);
                    $bill=$new_bill;
                }
            }
            $order = new VistorOrders();
           
            $order->mac_add = substr(exec('getmac'), 0, 17);
            $order->ip = request()->ip();
            $order->note = $request->note;
            $order->bill = $bill;
            $order->item = $item;
            $order->payment_method = $request->payment_option;
            $order->first_name = $request->fname;
            $order->last_name = $request->lname;
            $order->contact_number = $request->phone;
            $order->address1 = $request->billing_address;
            $order->address2 = $request->billing_address2;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->postal_code = $request->zipcode;
            $order->email = $request->email;
            if ($order->save()) {
                foreach ($carts as $cart) {
                    $order_detail = new VistorOrderDetails();
                    $order_detail->vistor_orders_id = $order->id;
                    $order_detail->products_id = $cart['products_id'];
                    $order_detail->qty = $cart['qty'];
                    $order_detail->sub_bill = $cart['price'];
                    $order_detail->save();
                }
                session()->forget('cart');
                Mail::to($request->email)->send(new \App\Mail\OrderMail("SDVO" . $order->id, "New Order"));
                if (Mail::flushMacros()) {
                    if (!empty($request->coupon)) {
                        $used_coupon = new UsedCoupons();
                        $used_coupon->email=session()->get('customer.email');
                        $used_coupon->coupons_id=$coupons_id;
                        $used_coupon->save();
                    }
                    session()->put('order_id','SDVO'.$order->id);
                    if($request->payment_option=="Paypal"){
                        $provider = new PaypalClient;
                        $provider->setApiCredentials(config('paypal'));
                        $token = $provider->getAccessToken();
                        $response = $provider->createOrder([
                            "intent" => "CAPTURE",
                            "application_context" => [
                                "return_url" => route('payment.success'),
                                "cancel_url" => route('payment.unsuccess')
                            ],
                            "purchase_units" => [
                                0 => [
                                    "amount" => [
                                        "currency_code" => "GBP",
                                        "value" => $bill
                                    ]
                                ]
                            ]
                        ]);
                        if (isset($response['id']) && $response != null) {
                            foreach ($response['links'] as $links) {
                                if ($links['rel'] == 'approve') {
                                    return redirect()->away($links['href']);
                                }
                            }
                            notify()->info('Contact Admin for further Detail', '', 'topRight');
                            return url('/');
                        } else {
                            notify()->error($response['error']['message'], '', 'topRight');
                            return url('/');
                        }
                    }else{
                        session()->put('order_bill',$bill);
                        return redirect(route('stripe.form'));
                    }
                } else {
                    $sent_mail = new SentMails();
                    $sent_mail->mail = $request->email;
                    $sent_mail->name = $request->fname . ' ' . $request->lname;
                    $sent_mail->subject = "Order Confirmation";
                    $sent_mail->order_number = "SDVO" . $order->id;
                    $sent_mail->bill = $bill;
                    $sent_mail->save();
                    if (!empty($request->coupon)) {
                        $used_coupon = new UsedCoupons();
                        $used_coupon->email=session()->get('customer.email');
                        $used_coupon->coupons_id=$coupons_id;
                        $used_coupon->save();
                    }
                    session()->put('order_id','SDVO'.$order->id);
                    if($request->payment_option=="Paypal"){
                        $provider = new PaypalClient;
                        $provider->setApiCredentials(config('paypal'));
                        $token = $provider->getAccessToken();
                        $response = $provider->createOrder([
                            "intent" => "CAPTURE",
                            "application_context" => [
                                "return_url" => route('payment.success'),
                                "cancel_url" => route('payment.unsuccess')
                            ],
                            "purchase_units" => [
                                0 => [
                                    "amount" => [
                                        "currency_code" => "GBP",
                                        "value" => $bill
                                    ]
                                ]
                            ]
                        ]);
                        if (isset($response['id']) && $response != null) {
                            foreach ($response['links'] as $links) {
                                if ($links['rel'] == 'approve') {
                                    return redirect()->away($links['href']);
                                }
                            }
                            notify()->info('Contact Admin for further Detail', '', 'topRight');
                            return url('/');
                        } else {
                            notify()->error($response['error']['message'], '', 'topRight');
                            return url('/');
                        }
                    }else{
                        session()->put('order_bill',$bill);
                        return redirect(route('stripe.form'));
                    }
                }
            } else {
                notify()->error('Try Again.', '', 'topRight');
                return redirect()->back();
            }
        }
    }

    public function currency_load(Request $request)
    {
        if ($request->ajax()) {

            $currency = Currencies::where('code', '=', $request->currency_code)->first();
            if (!is_null($currency)) {
                session()->put('currency_code', $request->currency_code);
                session()->put('currency_symbol', $currency->symbol);
                session()->put('currency_exchange_rate', $currency->exchange_rate);
                return response()->json([
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Server Error'
                ]);
            }
        }
    }

    public function track_order(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        if (str_contains($request->id, "SDRO")) {
            $id = str_replace("SDRO", "", $request->id);
            $status = Orders::where('id', '=', $id)->first();
            if (!empty($status)) {
                return response()->json([
                    'success' => true,
                    'message' => $status
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Order Not Found.'
                ]);
            }
        } else if (str_contains($request->id, "SDVO")) {
            $id = str_replace("SDVO", "", $request->id);
            $status = VistorOrders::where('id', '=', $id)->first();
            if (!empty($status)) {
                return response()->json([
                    'success' => true,
                    'message' => $status
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Order Not Found.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Enter Valid Id.'
            ]);
        }
    }

    public function rating(Request $request)
    {
        $request->validate([
            'product_rating'=>'required',
            'comment'=>'required',
            'name'=>'required',
            'email'=>'required|email',
            'id'=>'required'
        ]);
        $review =Reviews::where('email','=',$request->email)->first();
        if(empty($review)){
            $review= new Reviews();
            $review->products_id=$request->id;
            $review->name=$request->name;
            $review->email=$request->email;
            $review->comment=$request->comment;
            $review->rating=$request->product_rating;
            if($review->save()){
                notify()->success('Thanks For Your Comment','','topRight');
                return redirect()->back();
            }else{
                notify()->error('Try Again','','topRight');
                return redirect()->back();
            }
        }else{
            notify()->warning('You already Added Your Review','','topRight');
            return redirect()->back();
        }

    }

    public function apply_coupon(Request $request)
    {
        if($request->ajax()){
            $coupon=Coupons::where('coupon','=',$request->coupon)->where('status','=','Active')->first();
            if(!is_null($coupon)){
                $check=UsedCoupons::where('email','=',$request->email)->where('coupons_id','=',$coupon->id)->first();
                if(is_null($check)){
                    $bill=$request->bill;
                    if($coupon->discount_amount>0 ){
                        if($bill>$coupon->discount_amount){
                            return response()->json([
                                'success' => true,
                                'data' => currency_converter(floatval($bill)-floatval($coupon->discount_amount))
                            ]);
                        }else{
                            return response()->json([
                                'success' => 'info',
                                'message' => 'Please Add Some Items to Your Cart.'
                            ]);
                        }
                    }else{
                        return response()->json([
                            'success' => true,
                            'data' => currency_converter(floatval($bill)-floatval(($bill*$coupon->discount_percentage)/100))
                        ]);
                    }
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'You Already Use This Coupon.'
                    ]);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Coupon Code.'
                ]);
            }
        }
    }

    public function stripe_payment(Request $request)
    {
        \Stripe\Stripe::setApiKey('sk_test_51Laj1vHkcyJzI4km87zzkaJuo4JRZ6vfIaitM042jwYuBgy9IYDAZ5BUbjVMJj4OtoSgEB4Y7x6H6X0OLeN2OpWn00WRRhzNxq');
        $charge = \Stripe\Charge::create([
            'source' => $_POST['stripeToken'],
            'description' => session()->get('order_id'),
            'amount' => (session()->get('order_bill') * 100),
            'currency' => 'gbp',
          ]);
        if($charge->status=='succeeded'){
            session()->forget('order_bill');
            session()->put('payment_id',$charge->id);
            return redirect(route('payment.success'));
        }else{
            return redirect(route('payment.unsuccess'));
        }
    }
}
