<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriesModel;
use App\Models\Products;
use App\Models\SubCategoriesModel;
use App\Models\ProductsAccountDetail;
use App\Models\ProductsShippingDetail;
use App\Models\Attribute;
use App\Models\ProductsAttributePrice;
use App\Models\Wishlists;
use App\Models\Carts;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Reviews;
use App\Models\BlogCategories;
use App\Models\Blogs;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function home()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $blogs=Blogs::where('status', '=', 'Active')->with('blog_categories')->orderBy('created_at', 'desc')->limit(2)->get();
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        $products = Products::where('status', '=', 'Active')->where('is_publish', '=', 'Publish')->with('brand')->orderBy('created_at', 'desc')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "home";
        $data = compact('active', 'categories', 'sub_categories', 'products', 'wishlist', 'cart','blogs');

        return view('home')->with($data);
    }
    public function about()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "about";
        $data = compact('active', 'categories', 'sub_categories', 'wishlist', 'cart');
        return view('about')->with($data);
    }
    public function shop()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $cat = $sub_cat = '';
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        $products = Products::where('status', '=', 'Active')->where('is_publish', '=', 'Publish')->with('brand')->orderBy('created_at', 'desc')->paginate(20);
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "shop";
        $data = compact('active', 'categories', 'sub_categories', 'products', 'sub_cat', 'cat', 'wishlist', 'cart');
        return view('shop')->with($data);
    }

    public function shop_cat($cat)
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $sub_cat = '';
        $cate = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->where('category_slug', '=', $cat)->get();
        if (count($cate) > 0) {
            $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
            foreach ($cate as $value) {
                $products = Products::where('cat_id', '=', $value->id)->where('status', '=', 'Active')->where('is_publish', '=', 'Publish')->with('brand')->orderBy('created_at', 'desc')->paginate(20);
            }
            foreach ($categories as $category) {
                $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
            }
            $active = "shop";
            $data = compact('active', 'categories', 'sub_categories', 'products', 'cat', 'sub_cat', 'wishlist', 'cart');
            return view('shop')->with($data);
        } else {
            notify()->info('Data Not found.', '', 'topRight');
            return redirect()->back();
        }
    }
    public function shop_cat_sub($cat, $sub_cat)
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $cate = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->where('category_slug', '=', $cat)->get();
        $sub_cate = SubCategoriesModel::where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->where('sub_category_slug', '=', $sub_cat)->get();
        if (count($cate) > 0) {
            $sub_cate = $sub_cate->toArray();
            $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
            foreach ($cate as $value) {
                $products = Products::where('cat_id', '=', $value->id)->where('sub_cat_id', '=', $sub_cate[0]['id'])->where('status', '=', 'Active')->where('is_publish', '=', 'Publish')->with('brand')->orderBy('created_at', 'desc')->paginate(20);
            }
            foreach ($categories as $category) {
                $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
            }
            $active = "shop";
            $data = compact('active', 'categories', 'sub_categories', 'products', 'cat', 'sub_cat', 'wishlist', 'cart');
            return view('shop')->with($data);
        } else {
            notify()->info('Data Not found.', '', 'topRight');
            return redirect()->back();
        }
    }

    public function contact()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "contact";
        $data = compact('active', 'categories', 'sub_categories', 'wishlist', 'cart');
        return view('contact')->with($data);
    }
    public function blog()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        $blog_categories = BlogCategories::where('status', '=', 'Active')->get();
        $blogs = Blogs::where('status', '=', 'Active')->with('blog_categories')->orderBy('created_at', 'desc')->paginate(5);
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "blog";
        $data = compact('active', 'categories', 'sub_categories', 'wishlist', 'cart', 'blog_categories', 'blogs');
        return view('blog')->with($data);
    }
    public function wishlist()
    {
        if (session()->has('customer')) {
            $wishlists = Wishlists::where(function ($query) {
                $query->where('customers_id', '=', session()->get('customer.user_id'));
            })->get();
        } else {
            $wishlists = session()->get('wishlist');
        }
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        $products = Products::where('status', '=', 'Active')->where('is_publish', '=', 'Publish')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "";
        $data = compact('active', 'categories', 'sub_categories', 'products', 'wishlist', 'wishlists', 'cart');
        return view('wishlist')->with($data);
    }
    public function cart()
    {
        if (session()->has('customer')) {
            $carts = Carts::where(function ($query) {
                $query->where('customers_id', '=', session()->get('customer.user_id'));
            })->get();
        } else {
            $carts = session()->get('cart');
        }
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        $products = Products::where('status', '=', 'Active')->where('is_publish', '=', 'Publish')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "";
        $data = compact('active', 'categories', 'sub_categories', 'products', 'wishlist', 'cart', 'carts');
        return view('cart')->with($data);
    }
    public function product_detail($id)
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $product = Products::where('status', '=', 'Active')->where('id', '=', $id)->get();
        if (count($product) > 0) {
            $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
            $sub_categories_for_bread = SubCategoriesModel::where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
            $account_detail = ProductsAccountDetail::where('product_id', '=', $id)->get();
            $shipping_detail = ProductsShippingDetail::where('product_id', '=', $id)->get();
            foreach ($product as $value) {
                $related_products = Products::where('status', '=', 'Active')->where('cat_id', '=', $value->cat_id)->where('sub_cat_id', '=', $value->sub_cat_id)->where('id', '<>', $id)->orderBy('created_at', 'desc')->get();
                $reviews = Reviews::where('products_id', '=', $value->id)->where('status', '=', 'Approved')->get();
            }
            foreach ($categories as $category) {
                $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
            }
            $attributes = Attribute::where('status', '=', 1)->with('attributeValues')->get();
            $selected_attributes = ProductsAttributePrice::where('product_id', '=', $id)->get();
            $attribute_array = array();
            $attribute_value_array = array();
            $attribute_price = array();
            foreach ($selected_attributes as $value) {
                $attribute_array[] = $value->attribute_id;
                $attribute_value_array[] = $value->attribute_value_id;
                $attribute_price[$value->attribute_value_id] = $value->price;
            }
            $active = "";
            $data = compact('active', 'categories', 'sub_categories', 'product', 'attributes', 'attribute_array', 'attribute_value_array', 'attribute_price', 'related_products', 'sub_categories_for_bread', 'wishlist', 'cart', 'reviews');
            return view('product-detail')->with($data);
        } else {
            return redirect()->back();
        }
    }
    public function blog_detail($id)
    {
        $find = Blogs::find($id);
        if (!is_null($find)) {
            $wishlist = 0;
            $cart = 0;
            if ($this->get_cart() > 0) {
                $cart = $this->get_cart();
            }
            if ($this->get_wishlist() > 0) {
                $wishlist = $this->get_wishlist();
            }
            $blog = Blogs::where('id', '=', $id)->where('status', '=', 'Active')->orderBy('id', 'desc')->first();
            $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
            foreach ($categories as $category) {
                $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
            }
            $active = "";
            $data = compact('active', 'categories', 'sub_categories', 'wishlist', 'cart', 'blog');
            return view('blog-detail')->with($data);
        } else {
            notify()->info('Blog not found', '', 'topRight');
            return redirect()->back();
        }
    }
    public function privacy_policy()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "";
        $data = compact('active', 'categories', 'sub_categories', 'wishlist', 'cart');
        return view('privacy-policy')->with($data);
    }
    public function terms()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "";
        $data = compact('active', 'categories', 'sub_categories', 'wishlist', 'cart');
        return view('terms')->with($data);
    }
    public function account()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $orders = Orders::where('customers_id', '=', session()->get('customer.user_id'))->with('order_details','order_details.products')->orderBy('created_at', 'desc')->get();
        $customer = Customers::where('id', '=', session()->get('customer.user_id'))->where('status', '=', 'Active')->get();
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "";
        $data = compact('active', 'categories', 'sub_categories', 'wishlist', 'cart', 'customer', 'orders');
        return view('account')->with($data);
    }
    public function login()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "";
        $data = compact('active', 'categories', 'sub_categories', 'wishlist', 'cart');
        return view('login')->with($data);
    }

    public function check_out()
    {
        if (session()->has('customer')) {
            $carts = Carts::where(function ($query) {
                $query->where('customers_id', '=', session()->get('customer.user_id'));
            })->get();
        } else {
            $carts = session()->get('cart');
        }
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }

        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        $products = Products::where('status', '=', 'Active')->where('is_publish', '=', 'Publish')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "";
        if (session()->has('customer')) {
            $customer = Customers::where('id', '=', session()->get('customer.user_id'))->where('status', '=', 'Active')->get();
            $data = compact('active', 'categories', 'sub_categories', 'products', 'wishlist', 'cart', 'carts', 'customer');
        } else {
            $data = compact('active', 'categories', 'sub_categories', 'products', 'wishlist', 'cart', 'carts');
        }

        return view('check-out')->with($data);
    }

    function get_cart()
    {
        if (session()->has('customer')) {
            $u_id = session()->get('customer.user_id');
            $check_cart = Carts::where(function ($query) use ($u_id) {
                $query->where('customers_id', '=', $u_id);
            })->get();
            $count_cart = count($check_cart);
            if ($count_cart > 0) {
                return $count_cart;
            }
        } else {
            if (!is_null(session()->get('cart'))) {
                return count(session()->get('cart'));
            }
        }
    }
    function get_wishlist()
    {
        if (session()->has('customer')) {
            $u_id = session()->get('customer.user_id');
            $check = Wishlists::where(function ($query) use ($u_id) {
                $query->where('customers_id', '=', $u_id);
            })->get();
            $count = count($check);
            if ($count > 0) {
                return $count;
            }
        } else {
            if (!is_null(session()->get('wishlist'))) {
                return count(session()->get('wishlist'));
            }
        }
    }

    public function order_tracking()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "";
        $data = compact('active', 'categories', 'sub_categories', 'wishlist', 'cart');
        return view('trackOrder')->with($data);
    }

    public function order_success()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "";
        $data = compact('active', 'categories', 'sub_categories', 'wishlist', 'cart');
        return view('payments.success')->with($data);
    }

    public function order_unsuccess()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "";
        $data = compact('active', 'categories', 'sub_categories', 'wishlist', 'cart');
        return view('payments.fail')->with($data);
    }

    public function stripe_payment_form()
    {
        $wishlist = 0;
        $cart = 0;
        if ($this->get_cart() > 0) {
            $cart = $this->get_cart();
        }
        if ($this->get_wishlist() > 0) {
            $wishlist = $this->get_wishlist();
        }
        $categories = CategoriesModel::where('category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        foreach ($categories as $category) {
            $sub_categories[$category->id] = SubCategoriesModel::where('cat_id', '=', $category->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
        }
        $active = "";
        $data = compact('active', 'categories', 'sub_categories', 'wishlist', 'cart');
        return view('payments.stripeForm')->with($data);
    }
}
