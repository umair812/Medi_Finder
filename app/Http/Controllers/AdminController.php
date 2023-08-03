<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminModel;
use App\Models\CategoriesModel;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\SubCategoriesModel;
use App\Models\Products;
use App\Models\ProductsAccountDetail;
use App\Models\ProductsShippingDetail;
use App\Models\ProductsAttributePrice;
use App\Models\Brands;
use App\Models\Currencies;
use App\Models\Orders;
use App\Models\ContactModel;
use App\Models\SentMails;
use App\Models\MailsTemplates;
use App\Models\Reviews;
use App\Models\VistorOrders;
use App\Models\BlogCategories;
use App\Models\Blogs;
use App\Models\CMS;
use App\Models\Coupons;
use App\Models\Customers;
use App\Models\OrderShippingDetail;
use App\Models\UsedCoupons;
use App\Models\ShippingCompanies;
use App\Models\SubscribedEmailModel;
use App\Models\VisitorOrderShippingDetail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Stripe\Customer;
use Stripe\Order;

class AdminController extends Controller
{
    public function index()
    {
        $products = Products::where('status', '=', 'Active')->get();
        $categories = CategoriesModel::where('status', '=', 'Active')->get();
        $orders = Orders::where('status', '=', 'New Order')->with('customers')->orderBy('created_at', 'desc')->get();
        $order = Orders::all();
        $ro = count($order);
        $vistors_orders = VistorOrders::where('status', '=', 'New Order')->orderBy('created_at', 'desc')->get();
        $vistors_order = VistorOrders::all();
        $vo = count($vistors_order);
        $order_count = $ro + $vo;
        $ros = Orders::where('status', '=', 'Completed')->sum('bill');
        $vos = VistorOrders::where('status', '=', 'Completed')->sum('bill');
        $sum = $ros + $vos;
        $data = array();
        $active = "dashboard";
        $data = compact('active', 'orders', 'categories', 'products', 'vistors_orders', 'order_count', 'sum');
        return view('admin.index')->with($data);
    }

    public function loginPage()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
       
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $username = $request['username'];
        $password = md5($request['password']);
        $data = array();
        $admin = AdminModel::Where('username', '=', $username)->where('password', '=', $password)->get();
        
        $admin = $admin->toArray();
        if (!empty($admin)) {
            $data['admin_id'] = $admin[0]['id'];
            $data['admin_username'] = $admin[0]['username'];
            $data['admin_name'] = $admin[0]['name'];
            $data['admin_email'] = $admin[0]['email'];
            $data['admin_role'] = $admin[0]['role'];
            $data['admin_media'] = $admin[0]['media'];
            session()->put('admin', $data);
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
        session()->forget('admin');
        return redirect('/admin/login');
    }

    public function category()
    {
        $categories = CategoriesModel::where('status', '=', 'Active')->get();
        $data = array();
        $active = "category";
        $data = compact('active', 'categories');
        return view('admin.categories')->with($data);
    }

    public function brands()
    {
        $brands = Brands::where('status', '=', 'Active')->get();
        $data = array();
        $active = "category";
        $data = compact('active', 'brands');
        return view('admin.brands')->with($data);
    }

    public function show_category(Request $request)
    {
        if ($request->ajax()) {
            $update = CategoriesModel::where('id', '=', $request->id)->update(['category_action' => $request->status]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category ' . $request->status
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function delete_category(Request $request)
    {
        if ($request->ajax()) {
            $update = CategoriesModel::where('id', '=', $request->id)->update(['status' => 'Deleted']);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category Deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function delete_brand(Request $request)
    {
        if ($request->ajax()) {
            $update = Brands::where('id', '=', $request->id)->update(['status' => 'Deleted']);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Brand Deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function add_category(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'show' => 'required'
        ]);
    
        $category = new CategoriesModel();
        $category->category_title = $request->input('name');
        $category->category_slug = $request->input('slug');
        $category->category_description = $request->input('description');
        $category->category_order = 0;
        $category->category_action = $request->input('show');
        $category->status = 'Active';
    
        if ($category->save()) {
            notify()->success("Category Added.", "", "topRight");
        } else {
            notify()->error("Try Again Later.", "", "topRight");
        }
    
        return redirect()->back();
    }
    
    public function add_brand(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'media' => 'required'
        ]);
        $image = $request->file('media');
        $path_image = Storage::disk('public')->put('brands', $image);
        if (!empty($path_image)) {
            $brand = new Brands();
            $brand->name = stripslashes($request->name);
            $brand->slug = stripslashes($request->slug);
            $brand->media = stripslashes($path_image);
            $brand->status = 'Active';
            if ($brand->save()) {
                notify()->success("Brand Added.", "", "topRight");
            } else {
                notify()->error("Try Again Later.", "", "topRight");
            }
            return redirect()->back();
        } else {
            notify()->error("Image not uploaded. Try Again Later.", "", "topRight");
            return redirect()->back();
        }
    }

    public function sub_category()
    {
        $categories = CategoriesModel::where('status', '=', 1)->where('category_action', '=', 1)->get();
        $sub_categories = SubCategoriesModel::leftJoin('categories', 'sub_categories.cat_id', '=', 'categories.id')->select(['sub_categories.id as id', 'sub_categories.sub_category_title as sub_category_title', 'sub_categories.sub_category_slug as sub_category_slug', 'sub_categories.sub_category_description as sub_category_description', 'sub_categories.sub_category_order as sub_category_order', 'categories.category_title as category_title', 'sub_categories.sub_category_action as sub_category_action'])
            ->where('sub_categories.status', '=', 1)->get();
        $data = array();
        $active = "category";
        $data = compact('active', 'categories', 'sub_categories');
        return view('admin.sub-categories')->with($data);
    }

    public function show_sub_category(Request $request)
    {
        if ($request->ajax()) {
            $update = SubCategoriesModel::where('id', '=', $request->id)->update(['sub_category_action' => $request->status]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sub Category ' . stripslashes($request->status)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function delete_sub_category(Request $request)
    {
        if ($request->ajax()) {
            $update = SubCategoriesModel::where('id', '=', $request->id)->update(['status' => 'Deleted']);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sub Category Deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function add_sub_category(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'parent' => 'required',
            'show' => 'required'
        ]);
        $sub_category = new SubCategoriesModel();
        $sub_category->sub_category_title = stripslashes($request->name);
        $sub_category->sub_category_slug = stripslashes($request->slug);
        $sub_category->sub_category_description = stripslashes($request->description);
        $sub_category->sub_category_order = '0';
        $sub_category->cat_id = stripslashes($request->parent);
        $sub_category->sub_category_action = stripslashes($request->show);
        $sub_category->status = 'Active';
        if ($sub_category->save()) {
            notify()->success("Sub Category Added.", "", "topRight");
        } else {
            notify()->error("Try Again Later.", "", "topRight");
        }
        return redirect()->back();
    }

    public function product()
    {
        $cat = 'All';
        $filter = 'Latest added';
        $categories = CategoriesModel::where('status', '=', 1)->where('category_action', '=', 1)->get();
        $products = Products::where('status', '=', 'Active')->orderBy('created_at', 'desc')->paginate(20);
        $active = "product";
        $data = compact('active', 'categories', 'products', 'cat', 'filter');
        return view('admin.products')->with($data);
    }

    public function add_product_page()
    {
        $data = array();
        $brands = Brands::where('status', '=', 1)->get();
        $categories = CategoriesModel::where('status', '=', 1)->where('category_action', '=', 1)->get();
        $attributes = Attribute::where('status', '=', 1)->with('attributeValues')->get();
        $active = "product";
        $data = compact('active', 'categories', 'attributes', 'brands');
        return view('admin.add-product')->with($data);
    }

    public function sub_categories(Request $request)
    {
        if ($request->ajax()) {
            $sub_categories = SubCategoriesModel::where('cat_id', '=', $request->id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
            if (!is_null($sub_categories)) {
                return response()->json([
                    'success' => true,
                    'data' => $sub_categories->toArray()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No Sub Category found.'
                ]);
            }
        }
    }

    public function sub_categories_slug(Request $request)
    {
        if ($request->ajax()) {
            $id=CategoriesModel::where('category_slug','=',$request->id)->first()->id;
            $sub_categories = SubCategoriesModel::where('cat_id', '=', $id)->where('sub_category_action', '=', 'Enable')->where('status', '=', 'Active')->get();
            if (!is_null($sub_categories)) {
                return response()->json([
                    'success' => true,
                    'data' => $sub_categories->toArray()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No Sub Category found.'
                ]);
            }
        }
    }

    public function add_product(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'allow_checkout' => 'required',
            'feature' => 'required',
            'new_added' => 'required',
            'main_media' => 'required',
            'category' => 'required',
            'sub_category' => 'required'
        ]);
        $product = new Products();
        $main_image = $request->file('main_media');
        $path_main_image = Storage::disk('public')->put('product', $main_image);
        if (!empty($path_main_image)) {
            if (!empty($request->file('media'))) {
                $images = array();
                $images = $request->file('media');
                $gallery_path = '';
                foreach ($images as $image) {
                    $name = $image->getClientOriginalName();
                    $gallery_path .= Storage::disk('public')->put('product', $image) . ',';
                }
                if (!empty($gallery_path)) {
                    $product->title = stripslashes($request->name);
                    $product->sku = !empty($request->sku) ? stripslashes($request->sku) : '';
                    $product->brand_id = !empty($request->brand) ? stripslashes($request->brand) : 0;
                    $product->content = !empty($request->content) ? stripslashes($request->content) : '';
                    $product->description = stripslashes($request->description);
                    $product->price = stripslashes($request->price);
                    $product->sale_price = !empty($request->sale_price) ? stripslashes($request->sale_price) : 0.0;
                    $product->sale_in_percentage = !empty($request->discount) ? stripslashes($request->discount) : 0.0;
                    $product->quantity = stripslashes($request->quantity);
                    $product->main_media = $path_main_image;
                    $product->suppornting_media = $gallery_path;
                    $product->cat_id  = stripslashes($request->category);
                    $product->sub_cat_id  = stripslashes($request->sub_category);
                    $product->tags = !empty($request->tags) ? stripslashes($request->tags) : '';
                    $badges = "";
                    foreach ($request->badges as $badge) {
                        $badges .= $badge . ',';
                    }
                    $product->badges = stripslashes($badges);
                    if ($request->quantity > 0) {
                        $product->stock_availability = 'In Stock';
                    } else {
                        $product->stock_availability = 'Out Of Stock';
                    }
                    $product->allow_checkout = stripslashes($request->allow_checkout);
                    $product->is_feature = stripslashes($request->feature);
                    $product->new_added  = stripslashes($request->new_added);
                    $product->is_publish = 'Publish';
                    $product->status = "Active";
                    if ($product->save()) {
                        $account_detail = new ProductsAccountDetail();
                        $account_detail->product_id = $product->id;
                        $account_detail->taxable = ($request->taxable == 'Yes') ? 'Yes' : 'No';
                        $account_detail->tax_rate = !empty($request->tax_rate) ? stripslashes($request->tax_rate) : 0.0;
                        $account_detail->cost_price  = !empty($request->cost_price) ? stripslashes($request->cost_price) : 0.0;
                        $account_detail->save();

                        $shipping_detail = new ProductsShippingDetail();
                        $shipping_detail->product_id = $product->id;
                        $shipping_detail->width = !empty($request->width) ? stripslashes($request->width) : 0.0;
                        $shipping_detail->height = !empty($request->height) ? stripslashes($request->height) : 0.0;
                        $shipping_detail->weight  = !empty($request->weight) ? stripslashes($request->weight) : 0.0;
                        $shipping_detail->weight_unit  = !empty($request->weight_unit) ? stripslashes(strtoupper($request->weight_unit)) : '';
                        $shipping_detail->fee  = !empty($request->shipping_fee) ? stripslashes($request->shipping_fee) : 0.0;
                        $shipping_detail->save();

                        if (!empty($request['attributes'])) {
                            foreach ($request['attributes'] as $attribute) {
                                foreach ($request['attribute_values_' . $attribute] as $attribute_value) {
                                    $product_attribute_price = new ProductsAttributePrice();
                                    $product_attribute_price->product_id = $product->id;
                                    $product_attribute_price->attribute_id = $attribute;
                                    $product_attribute_price->attribute_value_id = $attribute_value;
                                    $product_attribute_price->save();
                                }
                            }
                        }
                        notify()->success("Product Added.", "", "topRight");
                        return redirect('/admin/products');
                    } else {
                        notify()->error("Try Again Later.", "", "topRight");
                        return redirect()->back();
                    }
                } else {
                    notify()->error("Images not uploaded. Try Again Later.", "", "topRight");
                    return redirect()->back();
                }
            } else {
                $product->title = stripslashes($request->name);
                $product->sku = !empty($request->sku) ? stripslashes($request->sku) : '';
                $product->brand_id = !empty($request->brand) ? stripslashes($request->brand) : 0;
                $product->content = !empty($request->content) ? stripslashes($request->content) : '';
                $product->description = stripslashes($request->description);
                $product->price = stripslashes($request->price);
                $product->sale_price = !empty($request->sale_price) ? stripslashes($request->sale_price) : 0.0;
                $product->sale_in_percentage = !empty($request->discount) ? stripslashes($request->discount) : 0.0;
                $product->quantity = stripslashes($request->quantity);
                $product->main_media = $path_main_image;
                $product->cat_id  = stripslashes($request->category);
                $product->sub_cat_id  = stripslashes($request->sub_category);
                $product->tags = !empty($request->tags) ? stripslashes($request->tags) : '';
                $badges = "";
                foreach ($request->badges as $badge) {
                    $badges .= $badge . ',';
                }
                $product->badges = $badges;
                if ($request->quantity > 0) {
                    $product->stock_availability = 'In Stock';
                } else {
                    $product->stock_availability = 'Out Of Stock';
                }
                $product->allow_checkout = stripslashes($request->allow_checkout);
                $product->is_feature = stripslashes($request->feature);
                $product->new_added  = stripslashes($request->new_added);
                $product->is_publish = 'Publish';
                $product->status = "Active";
                if ($product->save()) {
                    $account_detail = new ProductsAccountDetail();
                    $account_detail->product_id = $product->id;
                    $account_detail->taxable = ($request->taxable == 'Yes') ? 'Yes' : 'No';
                    $account_detail->tax_rate = !empty($request->tax_rate) ? stripslashes($request->tax_rate) : 0.0;
                    $account_detail->cost_price  = !empty($request->cost_price) ? stripslashes($request->cost_price) : 0.0;
                    $account_detail->save();

                    $shipping_detail = new ProductsShippingDetail();
                    $shipping_detail->product_id = $product->id;
                    $shipping_detail->width = !empty($request->width) ? stripslashes($request->width) : 0.0;
                    $shipping_detail->height = !empty($request->height) ? stripslashes($request->height) : 0.0;
                    $shipping_detail->weight  = !empty($request->weight) ? stripslashes($request->weight) : 0.0;
                    $shipping_detail->weight_unit  = !empty($request->weight_unit) ? stripslashes(strtoupper($request->weight_unit)) : '';
                    $shipping_detail->fee  = !empty($request->shipping_fee) ? stripslashes($request->shipping_fee) : 0.0;
                    $shipping_detail->save();

                    if (!empty($request['attributes'])) {
                        foreach ($request['attributes'] as $attribute) {
                            foreach ($request['attribute_values_' . $attribute] as $attribute_value) {
                                $product_attribute_price = new ProductsAttributePrice();
                                $product_attribute_price->product_id = $product->id;
                                $product_attribute_price->attribute_id = $attribute;
                                $product_attribute_price->attribute_value_id = $attribute_value;
                                $product_attribute_price->save();
                            }
                        }
                    }
                    notify()->success("Product Added.", "", "topRight");
                    return redirect('/admin/products');
                } else {
                    notify()->error("Try Again Later.", "", "topRight");
                    return redirect()->back();
                }
            }
        } else {
            notify()->error("Main Image not uploaded. Try Again Later.", "", "topRight");
            return redirect()->back();
        }
    }

    public function delete_product($id)
    {
        $product = Products::find($id);
        if (!is_null($product)) {
            $product = Products::where('id', '=', $id)->update(['status' => 'Deleted']);
            if (!is_null($product)) {
                ProductsAccountDetail::where('product_id', $id)->delete();
                ProductsShippingDetail::where('product_id', $id)->delete();
                ProductsAttributePrice::where('product_id', $id)->delete();
                notify()->success('Product Deleted.', '', 'topRight');
            } else {
                notify()->error('Try Again.', '', 'topRight');
            }
        } else {
            notify()->error('Product not Found', '', 'topRight');
        }
        return redirect()->back();
    }

    public function edit_product($id)
    {
        $product = Products::where('id', '=', $id)->get();
        if (count($product) > 0) {
            $brands = Brands::where('status', '=', 1)->get();
            $account_detail = ProductsAccountDetail::where('product_id', '=', $id)->get();
            $shipping_detail = ProductsShippingDetail::where('product_id', '=', $id)->get();
            $categories = CategoriesModel::where('status', '=', 1)->where('category_action', '=', 1)->get();
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
            $active = "product";
            $data = compact('active', 'categories', 'attributes', 'product', 'account_detail', 'shipping_detail', 'attribute_array', 'attribute_value_array', 'attribute_price', 'brands');
            return view('admin.edit-product')->with($data);
        } else {
            notify()->info('Data Not Found', '', 'topRight');
            return redirect()->back();
        }
    }

    public function attribute()
    {
        $attributes = Attribute::where('status', '=', 'Active')->get();
        $active = "category";
        $data = compact('active', 'attributes');
        return view('admin.attribute')->with($data);
    }

    public function add_attribute(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'widget' => 'required'
        ]);
        $attribute = new Attribute();
        $attribute->name = $request->name;
        $attribute->widget = $request->widget;
        $attribute->status = 'Active';
        if ($attribute->save()) {
            notify()->success('Attribute Added.', '', 'topRight');
        } else {
            notify()->error('Try Again.', '', 'topRight');
        }
        return redirect()->back();
    }

    public function attribute_value()
    {
        $attributes = Attribute::where('status', '=', 'Active')->get();
        $attribute_values = AttributeValue::where('status', '=', 'Active')->get();
        $active = "category";
        $data = compact('active', 'attributes', 'attribute_values');
        return view('admin.attributeValue')->with($data);
    }
    public function add_attribute_value(Request $request)
    {
        $request->validate([
            'value' => 'required',
            'attribute' => 'required'
        ]);
        $attribute_value = new AttributeValue();
        $attribute_value->value = stripslashes($request->value);
        $attribute_value->attribute_id = $request->attribute;
        $attribute_value->status = 'Active';
        if ($attribute_value->save()) {
            notify()->success('Value Added.', '', 'topRight');
        } else {
            notify()->error('Try Again.', '', 'topRight');
        }
        return redirect()->back();
    }

    public function delete_attribute_value(Request $request)
    {
        if ($request->ajax()) {
            $update = AttributeValue::where('id', '=', $request->id)->update(['status' => 'Deleted']);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Value Deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function delete_attribute(Request $request)
    {
        if ($request->ajax()) {
            $update = Attribute::where('id', '=', $request->id)->update(['status' => 'Deleted']);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Value Deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function admins()
    {
        $admins = AdminModel::all();
        $active = "admin";
        $data = compact('active', 'admins');
        return view('admin.admins')->with($data);
    }

    public function delete_admin(Request $request)
    {
        if ($request->ajax()) {
            $update = AdminModel::find($request->id)->delete();
            if ($update) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin Deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }
    public function add_admin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'paasword' => 'required'
        ]);
        $admin = new AdminModel();
        $usernameExist = AdminModel::where('username', '=', $request->username)->get();
        if (empty($usernameExist->toArray())) {
            $emailExist = AdminModel::where('email', '=', $request->email)->get();
            if (empty($emailExist->toArray())) {
                $admin->name = stripslashes($request['name']);
                $admin->username = stripslashes($request['username']);
                $admin->email = stripslashes($request['email']);
                $admin->role = stripslashes($request['role']);
                $admin->password = md5(stripslashes($request['password']));
                if ($admin->save()) {
                    notify()->success('Admin Added.', '', 'topRight');
                } else {
                    notify()->error('Try Again', '', 'topRight');
                }
            } else {
                notify()->error('Email Already Register.', '', 'topRight');
            }
        } else {
            notify()->error('Username Taken.', '', 'topRight');
        }
        return redirect()->back();
    }

    public function update_basic(Request $request)
    {
        if ($request->ajax()) {
            $update = Products::where('id', '=', $request->id)->update(['title' => stripslashes($request->name), 'sku' => stripslashes($request->sku), 'brand_id' => stripslashes($request->brand), 'content' => !empty($request->discount) ? stripslashes($request->discount) : 0.0, 'description' => stripslashes($request->description), 'price' => stripslashes($request->price), 'sale_price' => stripslashes($request->sale_price), 'sale_in_percentage' => stripslashes($request->discount), 'quantity' => stripslashes($request->quantity)]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Basic Detail Updated'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function update_extra(Request $request)
    {
        if ($request->ajax()) {
            $update = Products::where('id', '=', $request->id)->update(['stock_availability' => $request->stock, 'allow_checkout' => $request->allow_checkout, 'is_feature' => $request->feature, 'new_added' => $request->new_added]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Extra Detail Updated'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function update_shipping(Request $request)
    {
        if ($request->ajax()) {
            $update = ProductsShippingDetail::where('product_id', '=', $request->id)->update(['width' => $request->width, 'height' => $request->height, 'weight' => $request->weight, 'weight_unit' => strtoupper($request->weight_unit), 'fee' => $request->shipping_fee]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Shipping Detail Updated'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function update_tags(Request $request)
    {
        if ($request->ajax()) {
            $update = Products::where('id', '=', $request->id)->update(['cat_id' => $request->cat_id, 'sub_cat_id' => $request->sub_cat_id, 'tags' => $request->tags]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Organization Detail Updated'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function update_badges(Request $request)
    {
        if ($request->ajax()) {
            $update = Products::where('id', '=', $request->id)->update(['badges' => $request->badges]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Badges Updated'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function update_account(Request $request)
    {
        if ($request->ajax()) {
            $update = ProductsAccountDetail::where('id', '=', $request->id)->update(['taxable' => $request->taxable, 'tax_rate' => $request->tax_rate, 'cost_price' => $request->cost_price]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Account Detail Updated'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function update_main_image(Request $request)
    {
        $request->validate([
            'main_media' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $main_image = $request->file('main_media');
        $name_main_image = $main_image->getClientOriginalName();
        $path_main_image = Storage::disk('public')->put('products', $main_image);
        if ($path_main_image) {
            $update = Products::where('id', '=', $request->main_image_id)->update(['main_media' => $path_main_image]);
            if (!is_null($update)) {
                $url = url('public/uploads/' . $path_main_image);
                return response()->json([
                    'success' => true,
                    'message' => 'Main Image Updated.',
                    'img' => $url
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
                'message' => 'Image Not Uploaded.'
            ]);
        }
    }

    public function update_supporting_image(Request $request)
    {
        $images = array();
        $url = array();
        $images = $request->file('media');
        $gallery_path = '';
        foreach ($images as $image) {
            $name = $image->getClientOriginalName();
            $path = Storage::disk('public')->put('products', $image);
            $gallery_path .= $path . ',';
            $url[] = url('public/uploads/' . $path);
        }
        if (!empty($gallery_path)) {
            $update = Products::where('id', '=', $request->supporting_image_id)->update(['suppornting_media' => $gallery_path]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Supporting Images Updated.',
                    'img' => $url
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
                'message' => 'Images Not Uploaded.'
            ]);
        }
    }

    public function update_attribute_value_price(Request $request)
    {
        if ($request->ajax()) {
            $find = ProductsAttributePrice::where('product_id', '=', $request->pro_id)->where('attribute_id', '=', $request->att_id)->where('attribute_value_id', '=', $request->att_val_id)->get();
            $find = $find->toArray();
            if (!empty($find)) {
                $update = ProductsAttributePrice::where('product_id', '=', $request->pro_id)->where('attribute_id', '=', $request->att_id)->where('attribute_value_id', '=', $request->att_val_id)->update(['price' => $request->price]);
                if ($update == 1) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Price Updated'
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
                    'message' => 'First Add Attribute.'
                ]);
            }
        }
    }

    public function update_attribute(Request $request)
    {
        foreach ($request['attributes'] as $attribute) {
            foreach ($request['attribute_values_' . $attribute] as $attribute_value) {
                $find = ProductsAttributePrice::where('product_id', '=', $request->att_pro_id)->where('attribute_id', '=', $attribute)->where('attribute_value_id', '=', $attribute_value)->get();
                $find = $find->toArray();
                if (empty($find)) {
                    $product_attribute_price = new ProductsAttributePrice();
                    $product_attribute_price->product_id = $request->att_pro_id;
                    $product_attribute_price->attribute_id = $attribute;
                    $product_attribute_price->attribute_value_id = $attribute_value;
                    if ($product_attribute_price->save()) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Attribute Added.'
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Try Again.'
                        ]);
                    }
                }
            }
        }
    }

    public function remove_attribute_value(Request $request)
    {
        $delete = ProductsAttributePrice::where('product_id', $request->pro_id)->where('attribute_id', $request->att_id)->where('attribute_value_id', $request->att_val_id)->delete();
        if (!is_null($delete)) {
            return response()->json([
                'success' => true,
                'message' => 'Attribute Value Deleted.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Try Again.'
            ]);
        }
    }

    public function remove_attribute(Request $request)
    {
        $delete = ProductsAttributePrice::where('product_id', $request->pro_id)->where('attribute_id', $request->att_id)->delete();
        if (!is_null($delete)) {
            return response()->json([
                'success' => true,
                'message' => 'Attribute Value Deleted.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Try Again.'
            ]);
        }
    }

    public function product_publish(Request $request)
    {
        if ($request->ajax()) {
            $update = Products::where('id', '=', $request->id)->update(['is_publish' => $request->value]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product ' . $request->value . 'ed'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function reg_users_new_orders()
    {
        $record_perpage = "20";
        $orders = Orders::where('status', '=', 'New Order')->with('customers')->orderBy('created_at', 'desc')->paginate($record_perpage);
        $active = "order";
        $data = compact('active', 'orders', 'record_perpage');
        return view('admin.regUserOrder')->with($data);
    }

    public function reg_users_orders()
    {   
        $status="All";
        $record_perpage = "20";
        $orders = Orders::with('customers')->orderBy('created_at', 'desc')->paginate($record_perpage);
        $active = "order";
        $data = compact('active', 'orders', 'record_perpage','status');
        return view('admin.regUserAcceptedOrder')->with($data);
    }

    public function get_reg_users_new_orders_by_status(Request $request)
    {
        $orders = Orders::where('status', '=', 'New Order')->with('customers')->orderBy('created_at', 'desc')->paginate($request->record);
        if (count($orders) > 0) {
            $record_perpage = $request->record;
            $active = "order";
            $data = compact('active', 'orders', 'record_perpage');
            return view('admin.regUserOrder')->with($data);
        } else {
            notify()->info('Orders Not found', '', 'topRight');
            return redirect()->back();
        }
    }

    public function get_reg_users_orders_by_status(Request $request)
    {
        if($request->status=="All"){
            $orders = Orders::with('customers')->orderBy('created_at', 'desc')->paginate($request->record);
        }else{
            $orders = Orders::where('status', '=', $request->status)->with('customers')->orderBy('created_at', 'desc')->paginate($request->record);
        }
        if (count($orders) > 0) {
            $record_perpage = $request->record;
            $active = "order";
            $status=$request->status;
            $data = compact('active', 'orders', 'record_perpage','status');
            return view('admin.regUserAcceptedOrder')->with($data);
        } else {
            notify()->info('Orders Not found', '', 'topRight');
            $status="All";
            $record_perpage = "20";
            $orders = Orders::with('customers')->orderBy('created_at', 'desc')->paginate($record_perpage);
            $active = "order";
            $data = compact('active', 'orders', 'record_perpage','status');
            return view('admin.regUserAcceptedOrder')->with($data);
        }
    }

    public function get_reg_users_new_orders_by_id(Request $request)
    {
        $orders = Orders::where('status', '=', 'New Order')->where('id', '=', $request->id)->with('customers')->orderBy('created_at', 'desc')->paginate(20);
        if (count($orders) > 0) {
            $record_perpage = "20";
            $active = "order";
            $data = compact('active', 'orders', 'record_perpage');
            return view('admin.regUserOrder')->with($data);
        } else {
            notify()->info('Orders Not found', '', 'topRight');
            return redirect()->back();
        }
    }

    public function get_reg_users_orders_by_id(Request $request)
    {
        $id=$request->id;
        $orders = Orders::where(function ($query) use($id){
            $query->where('id', '=', $id);
        })->with('customers')->orderBy('created_at', 'desc')->paginate(20);
        if (count($orders) > 0) {
            $record_perpage = "20";
            $active = "order";
            $data = compact('active', 'orders', 'record_perpage');
            return view('admin.regUserAcceptedOrder')->with($data);
        } else {
            notify()->info('Orders Not found', '', 'topRight');
            $status="All";
            $record_perpage = "20";
            $orders = Orders::with('customers')->orderBy('created_at', 'desc')->paginate($record_perpage);
            $active = "order";
            $data = compact('active', 'orders', 'record_perpage','status');
            return view('admin.regUserAcceptedOrder')->with($data);
        }
    }

    public function visitors_new_orders()
    {
        $record_perpage = "20";
        $orders = VistorOrders::where('status', '=', 'New Order')->orderBy('created_at', 'desc')->paginate($record_perpage);
        $active = "order";
        $data = compact('active', 'orders', 'record_perpage');
        return view('admin.visitorsOrders')->with($data);
    }

    public function visitors_orders()
    {
        $status="All";
        $record_perpage = "20";
        $orders = VistorOrders::orderBy('created_at', 'desc')->paginate($record_perpage);
        $active = "order";
        $data = compact('active', 'orders', 'record_perpage','status');
        return view('admin.visitorsAcceptedOrders')->with($data);
    }

    public function get_risitors_new_orders_by_status(Request $request)
    {
        $orders = VistorOrders::where('status', '=', 'New Order')->orderBy('created_at', 'desc')->paginate($request->record);
        if (count($orders) > 0) {
            $record_perpage = $request->record;
            $active = "order";
            $data = compact('active', 'orders', 'record_perpage');
            return view('admin.visitorsOrders')->with($data);
        } else {
            notify()->info('Orders Not found', '', 'topRight');
            return redirect()->back();
        }
    }

    public function get_visitors_orders_by_status(Request $request)
    {   
        if($request->status=="All"){
            $orders = VistorOrders::orderBy('created_at', 'desc')->paginate($request->record);
        }else{
            $orders = VistorOrders::where('status', '=', $request->status)->orderBy('created_at', 'desc')->paginate($request->record);
        }
        if (count($orders) > 0) {
            $record_perpage = $request->record;
            $status=$request->status;
            $active = "order";
            $data = compact('active', 'orders', 'record_perpage','status');
            return view('admin.visitorsAcceptedOrders')->with($data);
        } else {
            notify()->info('Orders Not found', '', 'topRight');
            $status="All";
            $record_perpage = "20";
            $orders = VistorOrders::orderBy('created_at', 'desc')->paginate($record_perpage);
            $active = "order";
            $data = compact('active', 'orders', 'record_perpage','status');
            return view('admin.visitorsAcceptedOrders')->with($data);
        }
    }

    public function get_visitors_new_orders_by_id(Request $request)
    {
        $orders = VistorOrders::where('status', '=', 'New Order')->where('id', '=', $request->id)->orderBy('created_at', 'desc')->paginate(20);
        if (count($orders) > 0) {
            $status = "All";
            $record_perpage = "20";
            $active = "order";
            $data = compact('active', 'orders', 'status', 'record_perpage');
            return view('admin.visitorsOrders')->with($data);
        } else {
            notify()->info('Orders Not found', '', 'topRight');
            return redirect()->back();
        }
    }

    public function get_visitors_orders_by_id(Request $request)
    {
        $id=$request->id;
        $orders = VistorOrders::where(function ($query) use($id){
            $query->where('id', '=', $id)->orWhere('email','=',$id);
        })->orderBy('created_at', 'desc')->paginate(20);
        if (count($orders) > 0) {
            $status = "All";
            $record_perpage = "20";
            $active = "order";
            $data = compact('active', 'orders', 'status', 'record_perpage');
            return view('admin.visitorsAcceptedOrders')->with($data);
        } else {
            notify()->info('Orders Not found', '', 'topRight');
            $this->visitors_orders();
        }
    }

    public function ru_order_detail($id)
    {
        $shipping_companies=ShippingCompanies::where('is_enable','=','Yes')->where('status','=','Active')->get();
        $order = Orders::where('id', '=', $id)->with('customers', 'order_details', 'order_details.products', 'order_billing_addresses','order_shipping','order_shipping.shipping_companies')->first();
        if (!is_null($order)) {
            $active = "order";
            $data = compact('active', 'order','shipping_companies');
            return view('admin.regUserOrderDetail')->with($data);
        } else {
            return redirect()->back();
        }
    }

    public function v_order_detail($id)
    {
        $shipping_companies=ShippingCompanies::where('is_enable','=','Yes')->where('status','=','Active')->get();
        $order = VistorOrders::where('id', '=', $id)->with('vistor_order_details', 'vistor_order_details.products','order_shipping','order_shipping.shipping_companies')->first();
        if (!is_null($order)) {
            $active = "order";
            $data = compact('active', 'order','shipping_companies');
            return view('admin.visitorOrderDetail')->with($data);
        } else {
            return redirect()->back();
        }
    }

    public function ru_order_change_status(Request $request)
    {
        if ($request->ajax()) {
            $update = Orders::where('id', '=', $request->id)->update(['status' => $request->status]);
            if ($update) {
                Mail::to($request->email)->send(new \App\Mail\OrderMail("SDRO" . $request->id, $request->status));
                if (Mail::flushMacros()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Status Changed But Mail Not Sent.'
                    ]);
                } else {
                    return response()->json([
                        'success' => true,
                        'message' => 'Status Changed And Mail Sent.'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function ru_order_change_status_dispatched(Request $request)
    {
        $update = Orders::where('id', '=', $request->id)->update(['status' => $request->status]);
        if ($update) {
            Mail::to($request->email)->send(new \App\Mail\OrderMail("SDRO" . $request->id, $request->status));
            if (Mail::flushMacros()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status Changed But Mail Not Sent.'
                ]);
            } else {
                $shipping_order=new OrderShippingDetail();
                $shipping_order->shipping_companies_id=$request->shipping_companies_id;
                $shipping_order->orders_id=$request->id;
                $shipping_order->tracking_id=$request->tracking_id;
                $shipping_order->days=$request->days;
                $shipping_order->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Status Changed And Mail Sent.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Try Again.'
            ]);
        }
    }

    public function ru_order_change_status_return(Request $request)
    {
        $update = Orders::where('id', '=', $request->id)->update(['status' => $request->status,'return_reason'=>$request->return_reason]);
        if ($update) {
            Mail::to($request->email)->send(new \App\Mail\OrderMail("SDRO" . $request->id, $request->status));
            if (Mail::flushMacros()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status Changed But Mail Not Sent.'
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Status Changed And Mail Sent.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Try Again.'
            ]);
        }
    }

    public function ru_order_change_status_cancel(Request $request)
    {
        $update = Orders::where('id', '=', $request->id)->update(['status' => $request->status,'cancel_reason'=>$request->cancel_reason]);
        if ($update) {
            Mail::to($request->email)->send(new \App\Mail\OrderMail("SDRO" . $request->id, $request->status));
            if (Mail::flushMacros()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status Changed But Mail Not Sent.'
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Status Changed And Mail Sent.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Try Again.'
            ]);
        }
    }

    public function v_order_change_status(Request $request)
    {
        if ($request->ajax()) {
            $update = VistorOrders::where('id', '=', $request->id)->update(['status' => $request->status]);
            if ($update) {
                Mail::to($request->email)->send(new \App\Mail\OrderMail("SDVO" . $request->id, $request->status));
                if (Mail::flushMacros()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Status Changed But Mail Not Sent.'
                    ]);
                } else {
                    return response()->json([
                        'success' => true,
                        'message' => 'Status Changed And Mail Sent.'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function v_order_change_status_dispatched(Request $request)
    {
        $update = VistorOrders::where('id', '=', $request->id)->update(['status' => $request->status]);
        if ($update) {
            Mail::to($request->email)->send(new \App\Mail\OrderMail("SDVO" . $request->id, $request->status));
            if (Mail::flushMacros()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status Changed But Mail Not Sent.'
                ]);
            } else {
                $shipping_order=new VisitorOrderShippingDetail();
                $shipping_order->shipping_companies_id=$request->shipping_companies_id;
                $shipping_order->vistor_orders_id=$request->id;
                $shipping_order->tracking_id=$request->tracking_id;
                $shipping_order->days=$request->days;
                $shipping_order->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Status Changed And Mail Sent.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Try Again.'
            ]);
        }
    }

    public function v_order_change_status_return(Request $request)
    {
        $update = VistorOrders::where('id', '=', $request->id)->update(['status' => $request->status,'return_reason'=>$request->return_reason]);
        if ($update) {
            Mail::to($request->email)->send(new \App\Mail\OrderMail("SDVO" . $request->id, $request->status));
            if (Mail::flushMacros()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status Changed But Mail Not Sent.'
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Status Changed And Mail Sent.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Try Again.'
            ]);
        }
    }

    public function v_order_change_status_cancel(Request $request)
    {
        $update = VistorOrders::where('id', '=', $request->id)->update(['status' => $request->status,'cancel_reason'=>$request->cancel_reason]);
        if ($update) {
            Mail::to($request->email)->send(new \App\Mail\OrderMail("SDVO" . $request->id, $request->status));
            if (Mail::flushMacros()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status Changed But Mail Not Sent.'
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Status Changed And Mail Sent.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Try Again.'
            ]);
        }
    }

    public function currency()
    {
        $currencies = Currencies::paginate(10);
        $data = array();
        $active = "currency";
        $data = compact('active', 'currencies');
        return view('admin.currencies')->with($data);
    }

    public function add_currency(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'symbol' => 'required',
            'exchange_rate' => 'numeric|required',
            'code' => 'required',
            'status' => 'required'
        ]);
        $currency = new Currencies();
        $currency->name = stripslashes($request->name);
        $currency->symbol = stripslashes($request->symbol);
        $currency->exchange_rate = stripslashes($request->exchange_rate);
        $currency->code = stripslashes($request->code);
        $currency->status = stripslashes($request->status);
        if ($currency->save()) {
            notify()->success("Currency Added.", "", "topRight");
        } else {
            notify()->error("Try Again Later.", "", "topRight");
        }
        return redirect()->back();
    }

    public function show_currency(Request $request)
    {
        if ($request->ajax()) {
            $update = Currencies::where('id', '=', $request->id)->update(['status' => $request->status]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Currency ' . $request->status
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function delete_currency(Request $request)
    {
        if ($request->ajax()) {
            $find = Currencies::find($request->id);
            if ($find) {
                $update = Currencies::where('id', '=', $request->id)->delete();
                if ($update) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Currency Deleted'
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
                    'message' => 'Data Not Found.'
                ]);
            }
        }
    }

    public function edit_currency(Request $request)
    {
        if ($request->ajax()) {
            $update = Currencies::where('id', '=', $request->id)->update(['name' => $request->name, 'symbol' => $request->symbol, 'exchange_rate' => $request->exchange_rate, 'code' => $request->code]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Currency Updated'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }
    public function order_confirmation($id)
    {
    
        return view('emails.orderConfirmation1')->with(compact('id'));
    }

    public function sent_mails()
    {
        $record_perpage = 20;
        $sent_mails = SentMails::orderBy('created_at', 'desc')->paginate($record_perpage);
        $data = array();
        $active = "mail";
        $data = compact('active', 'sent_mails', 'record_perpage');
        return view('admin.sent-mails')->with($data);
    }

    public function sent_mails_pagination(Request $request)
    {
        $record_perpage = $request->record;
        $sent_mails = SentMails::orderBy('created_at', 'desc')->paginate($record_perpage);
        $data = array();
        $active = "mail";
        $data = compact('active', 'sent_mails', 'record_perpage');
        return view('admin.sent-mails')->with($data);
    }

    public function sent_mails_search(Request $request)
    {
        $email = $request->id;
        $record_perpage = 20;
        $sent_mails = SentMails::where(function ($query) use ($email) {
            $query->where('mail', '=', $email)->orWhere('order_number', '=', $email);
        })->orderBy('created_at', 'desc')->paginate($record_perpage);
        $data = array();
        $active = "mail";
        if (count($sent_mails) > 0) {
            $data = compact('active', 'sent_mails', 'record_perpage');
            return view('admin.sent-mails')->with($data);
        } else {
            notify()->info('Mail not Found', '', 'topRight');
            return redirect()->back();
        }
    }

    public function contact_us()
    {
        $record_perpage = 20;
        $messages = ContactModel::orderBy('created_at', 'desc')->paginate($record_perpage);
        $data = array();
        $active = "mail";
        $data = compact('active', 'messages', 'record_perpage');
        return view('admin.contactUsMessages')->with($data);
    }

    public function contact_us_pagination(Request $request)
    {
        $record_perpage = $request->record;
        $messages = ContactModel::orderBy('created_at', 'desc')->paginate($record_perpage);
        $data = array();
        $active = "mail";
        $data = compact('active', 'messages', 'record_perpage');
        return view('admin.contactUsMessages')->with($data);
    }

    public function order_confirmation_template()
    {
        $template = MailsTemplates::where('id', '=', 1)->first();
        $active = 'mail';
        return view('admin.orderConfirmationTemplate')->with(compact('template', 'active'));
    }

    public function order_confirmation_template_set(Request $request)
    {
        $template = MailsTemplates::where('id', '=', 1)->update(['content' => $request->content, 'extra_content' => $request->extra_content]);
        if ($template) {
            notify()->success('Template Updated', '', 'topRight');
            return redirect()->back();
        } else {
            notify()->error('Try Again', '', 'topRight');
            return redirect()->back();
        }
    }

    public function order_acceptence_template()
    {
        $template = MailsTemplates::where('id', '=', 2)->first();
        $active = 'mail';
        return view('admin.orderAcceptTemplate')->with(compact('template', 'active'));
    }

    public function order_acceptence_template_set(Request $request)
    {
        $template = MailsTemplates::where('id', '=', 2)->update(['content' => $request->content, 'extra_content' => $request->extra_content]);
        if ($template) {
            notify()->success('Template Updated', '', 'topRight');
            return redirect()->back();
        } else {
            notify()->error('Try Again', '', 'topRight');
            return redirect()->back();
        }
    }

    public function order_dispatching_template()
    {
        $template = MailsTemplates::where('id', '=', 3)->first();
        $active = 'mail';
        return view('admin.orderDispatchTemplate')->with(compact('template', 'active'));
    }

    public function order_dispatching_template_set(Request $request)
    {
        $template = MailsTemplates::where('id', '=', 3)->update(['content' => $request->content, 'extra_content' => $request->extra_content]);
        if ($template) {
            notify()->success('Template Updated', '', 'topRight');
            return redirect()->back();
        } else {
            notify()->error('Try Again', '', 'topRight');
            return redirect()->back();
        }
    }

    public function order_cancelation_template()
    {
        $template = MailsTemplates::where('id', '=', 4)->first();
        $active = 'mail';
        return view('admin.orderCancelTemplate')->with(compact('template', 'active'));
    }

    public function order_cancelation_template_set(Request $request)
    {
        $template = MailsTemplates::where('id', '=', 4)->update(['content' => $request->content, 'extra_content' => $request->extra_content]);
        if ($template) {
            notify()->success('Template Updated', '', 'topRight');
            return redirect()->back();
        } else {
            notify()->error('Try Again', '', 'topRight');
            return redirect()->back();
        }
    }

    public function order_returning_template()
    {
        $template = MailsTemplates::where('id', '=', 5)->first();
        $active = 'mail';
        return view('admin.orderReturnTemplate')->with(compact('template', 'active'));
    }

    public function order_returning_template_set(Request $request)
    {
        $template = MailsTemplates::where('id', '=', 5)->update(['content' => $request->content, 'extra_content' => $request->extra_content]);
        if ($template) {
            notify()->success('Template Updated', '', 'topRight');
            return redirect()->back();
        } else {
            notify()->error('Try Again', '', 'topRight');
            return redirect()->back();
        }
    }

    public function order_completion_template()
    {
        $template = MailsTemplates::where('id', '=', 6)->first();
        $active = 'mail';
        return view('admin.orderCompleteTemplate')->with(compact('template', 'active'));
    }

    public function order_completion_template_set(Request $request)
    {
        $template = MailsTemplates::where('id', '=', 6)->update(['content' => $request->content, 'extra_content' => $request->extra_content]);
        if ($template) {
            notify()->success('Template Updated', '', 'topRight');
            return redirect()->back();
        } else {
            notify()->error('Try Again', '', 'topRight');
            return redirect()->back();
        }
    }

    public function marketing_template()
    {
        $template = MailsTemplates::where('id', '=', 7)->first();
        $active = 'mail';
        return view('admin.marketingTemplate')->with(compact('template', 'active'));
    }

    public function marketing_template_set(Request $request)
    {
        $template = MailsTemplates::where('id', '=', 7)->update(['extra_content' => $request->extra_content]);
        if ($template) {
            notify()->success('Template Updated', '', 'topRight');
            return redirect()->back();
        } else {
            notify()->error('Try Again', '', 'topRight');
            return redirect()->back();
        }
    }

    public function reviews()
    {
        $record_perpage = 20;
        $status = 'All';
        $reviews = Reviews::orderBy('id', 'desc')->with('products')->paginate($record_perpage);
        $active = "review";
        $data = compact('active', 'reviews', 'record_perpage', 'status');
        return view('admin.productReviews')->with($data);
    }

    public function change_review_status(Request $request)
    {
        if ($request->ajax()) {
            $update = Reviews::where('id', '=', $request->id)->update(['status' => $request->status]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reivew ' . stripslashes($request->status)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function get_reviews_by_status(Request $request)
    {
        if ($request->status == 'All') {
            $record_perpage = $request->record;
            $status = $request->status;
            $reviews = Reviews::orderBy('id', 'desc')->with('products')->paginate($record_perpage);
            $active = "review";
            $data = compact('active', 'reviews', 'record_perpage', 'status');
            return view('admin.productReviews')->with($data);
        } else {
            $reviews = Reviews::where('status', '=', $request->status)->orderBy('id', 'desc')->paginate($request->record);
            if (count($reviews) > 0) {
                $record_perpage = $request->record;
                $status = $request->status;
                $active = "review";
                $data = compact('active', 'reviews', 'record_perpage', 'status');
            } else {
                $record_perpage = $request->record;
                $status = $request->status;
                $active = "review";
                $data = compact('active', 'reviews', 'record_perpage', 'status');
                notify()->info('Reviews Not found', '', 'topRight');
            }
            return view('admin.productReviews')->with($data);
        }
    }

    public function get_reviews_by_id(Request $request)
    {
        $record_perpage = 20;
        $status = 'All';
        $reviews = Reviews::where('id', '=', $request->id)->orderBy('id', 'desc')->with('products')->paginate($record_perpage);
        $active = "review";
        if (count($reviews) > 0) {
            $data = compact('active', 'reviews', 'record_perpage', 'status');
            return view('admin.productReviews')->with($data);
        } else {
            notify()->info('Reviews Not found', '', 'topRight');
            $data = compact('active', 'reviews', 'record_perpage', 'status');
            return view('admin.productReviews')->with($data);
        }
    }

    public function product_filter(Request $request)
    {
        $categories = CategoriesModel::where('status', '=', 1)->where('category_action', '=', 1)->get();
        $cat = $request->cat;
        $filter = $request->filter;
        $products = array();
        if ($cat == 'All') {
            if ($filter == 'Latest added') {
                $products = Products::where('status', '=', 'Active')->orderBy('created_at', 'desc')->paginate(20);
            } else if ($filter == 'Published') {
                $products = Products::where('is_publish', '=', 'Publish')->where('status', '=', 'Active')->paginate(20);
            } else if ($filter == 'Not Published') {
                $products = Products::where('is_publish', '=', 'Draft')->where('status', '=', 'Active')->paginate(20);
            }
        } else {
            if ($filter == 'Latest added') {
                $products = Products::where('cat_id', '=', $cat)->where('status', '=', 'Active')->orderBy('created_at', 'desc')->paginate(20);
            } else if ($filter == 'Published') {
                $products = Products::where('cat_id', '=', $cat)->where('is_publish', '=', 'Publish')->where('status', '=', 'Active')->paginate(20);
            } else if ($filter == 'Not Published') {
                $products = Products::where('cat_id', '=', $cat)->where('is_publish', '=', 'Draft')->where('status', '=', 'Active')->paginate(20);
            }
        }
        $active = "product";
        $data = compact('active', 'categories', 'products', 'cat', 'filter');
        return view('admin.products')->with($data);
    }

    public function product_by_id(Request $request)
    {
        $cat = 'All';
        $filter = 'Latest added';
        $categories = CategoriesModel::where('status', '=', 1)->where('category_action', '=', 1)->get();
        $products = Products::where('id', '=', $request->id)->where('status', '=', 'Active')->orderBy('created_at', 'desc')->paginate(20);
        $active = "product";
        if (count($products) == 0) {
            notify()->info('Product Not found', '', 'topRight');
        }
        $data = compact('active', 'categories', 'products', 'cat', 'filter');
        return view('admin.products')->with($data);
    }

    public function blog_categories()
    {
        $blog_categories = BlogCategories::where('status', '=', 'Active')->get();
        $data = array();
        $active = "category";
        $data = compact('active', 'blog_categories');
        return view('admin.blogCategories')->with($data);
    }

    public function add_blog_category(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required'
        ]);
        $category = new BlogCategories();
        $category->name = stripslashes($request->name);
        $category->slug = stripslashes($request->slug);
        $category->status = 'Active';
        if ($category->save()) {
            notify()->success("Category Added.", "", "topRight");
        } else {
            notify()->error("Try Again Later.", "", "topRight");
        }
        return redirect()->back();
    }

    public function delete_blog_category(Request $request)
    {
        if ($request->ajax()) {
            Blogs::where('blog_categories_id ', '=', $request->id)->update(['status' => 'Deleted']);
            $update = BlogCategories::where('id', '=', $request->id)->update(['status' => 'Deleted']);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category Deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function blogs()
    {
        $record_perpage = 20;
        $category = 'All';
        $active = 'blog';
        $blog_categories = BlogCategories::where('status', '=', 'Active')->get();
        $blogs = Blogs::where('status', '=', 'Active')->with('blog_categories')->orderBy('created_at', 'desc')->paginate(20);
        $data = compact('active', 'blogs', 'category', 'record_perpage', 'blog_categories');
        return view('admin.blogs')->with($data);
    }

    public function change_trending(Request $request)
    {
        if ($request->ajax()) {
            $update = Blogs::where('id', '=', $request->id)->update(['trending_priority' => $request->periority]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Trending Priority Updated'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function get_blogs_by_category(Request $request)
    {
        if ($request->category == 'All') {
            $record_perpage = $request->record;
            $category = $request->category;
            $blog_categories = BlogCategories::where('status', '=', 'Active')->get();
            $blogs = Blogs::orderBy('id', 'desc')->with('blog_categories')->paginate($record_perpage);
            $active = "blog";
            $data = compact('active', 'blogs', 'record_perpage', 'category', 'blog_categories');
            return view('admin.blogs')->with($data);
        } else {
            $blog_categories = BlogCategories::where('status', '=', 'Active')->get();
            $blogs = Blogs::where('blog_categories_id', '=', $request->category)->orderBy('id', 'desc')->paginate($request->record);
            if (count($blogs) > 0) {
                $record_perpage = $request->record;
                $category = $request->category;
                $active = "blog";
                $data = compact('active', 'blogs', 'record_perpage', 'category', 'blog_categories');
            } else {
                $record_perpage = $request->record;
                $category = $request->category;
                $active = "blog";
                $data = compact('active', 'blogs', 'record_perpage', 'category', 'blog_categories');
                notify()->info('Blogs Not found', '', 'topRight');
            }
            return view('admin.blogs')->with($data);
        }
    }

    public function get_blogs_by_term(Request $request)
    {
        $record_perpage = 20;
        $category = 'All';
        $term = $request->term;
        $blog_categories = BlogCategories::where('status', '=', 'Active')->get();
        $blogs = blogs::where(function ($query) use ($term) {
            $query->where('id', '=', $term)->orWhere('title', 'LIKE', '%' . $term . '%')->orWhere('short_description', 'LIKE', '%' . $term . '%')
                ->orWhere('description', 'LIKE', '%' . $term . '%');
        })->orderBy('id', 'desc')->with('blog_categories')->paginate($record_perpage);
        $active = "blog";
        if (count($blogs) > 0) {
            $data = compact('active', 'blogs', 'category', 'record_perpage', 'blog_categories');
            return view('admin.blogs')->with($data);
        } else {
            notify()->info('Blogs Not found', '', 'topRight');
            $data = compact('active', 'blogs', 'category', 'record_perpage', 'blog_categories');
            return view('admin.blogs')->with($data);
        }
    }

    public function add_blog_page()
    {
        $blog_categories = BlogCategories::where('status', '=', 'Active')->get();
        $active = 'blog';
        $data = compact('active', 'blog_categories');
        return view('admin.addBlog')->with($data);
    }

    public function add_blog(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'content' => 'required',
            'description' => 'required',
            'main_media' => 'required'
        ]);
        $main_image = $request->file('main_media');
        $path_main_image = Storage::disk('public')->put('blogs', $main_image);
        if (!empty($path_main_image)) {
            $blog = new Blogs();
            $blog->title = $request->name;
            $blog->short_description = $request->content;
            $blog->description = $request->description;
            $blog->media = $path_main_image;
            $blog->blog_categories_id = $request->category;
            $blog->trending_priority = $request->priority;
            if ($blog->save()) {
                notify()->success('Blog Added.', '', 'topRight');
                return redirect()->back();
            } else {
                notify()->error('Try Again.', '', 'topRight');
                return redirect()->back();
            }
        } else {
            notify()->error('Image Not Uploaded.', '', 'topRight');
            return redirect()->back();
        }
    }

    public function edit_blog($id)
    {
        $blog_categories = BlogCategories::where('status', '=', 'Active')->get();
        $blog = Blogs::where('id', '=', $id)->where('status', '=', 'Active')->with('blog_categories')->orderBy('created_at', 'desc')->first();
        $active = 'blog';
        $data = compact('active', 'blog_categories', 'blog');
        return view('admin.editBlog')->with($data);
    }

    public function update_blog(Request $request)
    {
        $find = Blogs::find($request->id);
        if (!is_null($find)) {
            if (!empty($request->file('main_media'))) {
                $main_image = $request->file('main_media');
                $path_main_image = Storage::disk('public')->put('blogs', $main_image);
                if (!empty($path_main_image)) {
                    $find->title = $request->name;
                    $find->short_description = $request->content;
                    $find->description = $request->description;
                    $find->media = $path_main_image;
                    $find->blog_categories_id = $request->category;
                    $find->trending_priority = $request->priority;
                    if ($find->save()) {
                        notify()->success('Blog Updated.', '', 'topRight');
                        return redirect()->back();
                    } else {
                        notify()->error('Try Again.', '', 'topRight');
                        return redirect()->back();
                    }
                } else {
                    notify()->error('Image Not Uploaded.', '', 'topRight');
                    return redirect()->back();
                }
            } else {
                $find->title = $request->name;
                $find->short_description = $request->content;
                $find->description = $request->description;
                $find->blog_categories_id = $request->category;
                $find->trending_priority = $request->priority;
                if ($find->save()) {
                    notify()->success('Blog Updated.', '', 'topRight');
                    return redirect()->back();
                } else {
                    notify()->error('Try Again.', '', 'topRight');
                    return redirect()->back();
                }
            }
        } else {
            notify()->error('Blog Not Found.', '', 'topRight');
            return redirect()->back();
        }
    }

    public function delete_blog(Request $request)
    {
        if ($request->ajax()) {
            $update = Blogs::where('id', '=', $request->id)->update(['status' => 'Deleted']);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Blog Deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function coupons()
    {
        $active = 'coupon';
        $coupons = Coupons::all();
        $data = compact('active', 'coupons');
        return view('admin.coupons')->with($data);
    }

    public function add_coupon(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'usage' => 'required'
        ]);
        $coupon = new Coupons();
        $coupon->coupon = strtoupper($request->name);
        $coupon->discount_amount = !empty($request->discount_amount)? $request->discount_amount:0;
        $coupon->discount_percentage = !empty($request->discount_percentage)? $request->discount_percentage:0;
        $coupon->usage = $request->usage;
        if ($coupon->save()) {
            notify()->success("Coupon Added.", "", "topRight");
        } else {
            notify()->error("Try Again Later.", "", "topRight");
        }
        return redirect()->back();
    }

    public function change_coupon_status(Request $request)
    {
        if ($request->ajax()) {
            $update = Coupons::where('id', '=', $request->id)->update(['status' => $request->status]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Coupon '.$request->status
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function used_coupons()
    {
        $record_perpage='20';
        $active = 'coupon';
        $coupons = UsedCoupons::with('coupons')->paginate(20);
        $data = compact('active', 'coupons','record_perpage');
        return view('admin.usedCoupons')->with($data);
    }

    public function get_used_coupon_by_record(Request $request)
    {
        $record_perpage=$request->record;
        $active = 'coupon';
        $coupons = UsedCoupons::with('coupons')->paginate($request->record);
        $data = compact('active', 'coupons','record_perpage');
        return view('admin.usedCoupons')->with($data);
    }

    public function get_used_coupon_by_term(Request $request)
    {
        $record_perpage = 20;
        $active = 'coupon';
        $term = $request->term;
        $validator = Validator::make(['term' => $term],[
            'term' => 'required|email'
          ]);
        if ($validator->fails()){         
            $coupon = Coupons::where('coupon','=',$term)->first();
            if(!empty($coupon)){
                $coupons = UsedCoupons::where('coupons_id','=',$coupon->id)->with('coupons')->paginate($request->record);
            }else{
                notify()->info('Data not Found','','topRight');
                $coupons = array();
            }   
        }else{
            $coupons = UsedCoupons::where('email','=',$term)->with('coupons')->paginate($request->record);
        }
        $data = compact('active', 'coupons','record_perpage');
        return view('admin.usedCoupons')->with($data);
    }

    public function cms_about()
    {
        $active = 'cms';
        $content = CMS::where('page','=','about')->first();
        $categories=CategoriesModel::where('category_action','=','Enable')->where('status','=','Active')->get();
        $data = compact('active', 'content','categories');
        return view('admin.aboutCMS')->with($data);
    }

    public function cms_policy()
    {
        $active = 'cms';
        $content = CMS::where('page','=','policy')->first();
        $categories=CategoriesModel::where('category_action','=','Enable')->where('status','=','Active')->get();
        $data = compact('active', 'content','categories');
        return view('admin.policyCMS')->with($data);
    }

    public function cms_terms()
    {
        $active = 'cms';
        $content = CMS::where('page','=','terms')->first();
        $categories=CategoriesModel::where('category_action','=','Enable')->where('status','=','Active')->get();
        $data = compact('active', 'content','categories');
        return view('admin.termsCMS')->with($data);
    }

    public function cms_blog()
    {
        $active = 'cms';
        $content = CMS::where('page','=','blog')->first();
        $categories=CategoriesModel::where('category_action','=','Enable')->where('status','=','Active')->get();
        $data = compact('active', 'content','categories');
        return view('admin.blogCMS')->with($data);
    }

    public function cms_shop()
    {
        $active = 'cms';
        $content = CMS::where('page','=','shop')->first();
        $categories=CategoriesModel::where('category_action','=','Enable')->where('status','=','Active')->get();
        $data = compact('active', 'content','categories');
        return view('admin.shopCMS')->with($data);
    }

    public function cms_blog_detail()
    {
        $active = 'cms';
        $content = CMS::where('page','=','blog_detail')->first();
        $categories=CategoriesModel::where('category_action','=','Enable')->where('status','=','Active')->get();
        $data = compact('active', 'content','categories');
        return view('admin.blogDetailCMS')->with($data);
    }

    public function cms_product_detail()
    {
        $active = 'cms';
        $content = CMS::where('page','=','product_detail')->first();
        $categories=CategoriesModel::where('category_action','=','Enable')->where('status','=','Active')->get();
        $data = compact('active', 'content','categories');
        return view('admin.productDetailCMS')->with($data);
    }

    public function cms_update_content(Request $request)
    {
        $content = CMS::find($request->id);
        if (!is_null($content)) {
            $content->content = strtoupper($request->content);
            if ($content->save()) {
                notify()->success("Content Added.", "", "topRight");
            } else {
                notify()->error("Try Again Later.", "", "topRight");
            }
        }
        return redirect()->back();
    }

    public function cms_update_ad(Request $request)
    {
        $content = CMS::find($request->id);
        if (!is_null($content)) {
            $main_image = $request->file('main_media');
            $path_main_image = Storage::disk('public')->put('deals', $main_image);
            if (!empty($path_main_image)) {
                $content->ad = $path_main_image;
                if(isset($content->ad_content)){
                    $content->content = $request->content;  
                }
                $content->ad_status = 'Show';
                $content->category_slug = (!empty($request->category)) ? $request->category : '' ;
                $content->sub_category_slug = (!empty($request->sub_category)) ? $request->sub_category : '' ;
                if ($content->save()) {
                    notify()->success("Ads Live.", "", "topRight");
                } else {
                    notify()->error("Try Again Later.", "", "topRight");
                }
            } else {
                notify()->error("Image Not Uploaded.", "", "topRight");
            }                    
        }
        return redirect()->back();
    }

    public function show_ad(Request $request)
    {
        if ($request->ajax()) {
            $update = CMS::where('id', '=', $request->id)->update(['ad_status' => $request->status]);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ads ' . stripslashes($request->status)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function subscribers()
    {
        $active = 'customer';
        $record_perpage='20';
        $emails = SubscribedEmailModel::paginate(20);
        $data = compact('active', 'emails','record_perpage');
        return view('admin.subscribers')->with($data);
    }

    public function customers()
    {
        $active = 'customer';
        $record_perpage='20';
        $customers = Customers::where('status','=','Active')->paginate(20);
        $data = compact('active', 'customers','record_perpage');
        return view('admin.customers')->with($data);
    }

    public function delete_customer(Request $request)
    {
        if ($request->ajax()) {
            $update = Customers::find($request->id);
            if ($update) {
                Customers::where('id','=',$request->id)->update(['status'=>'Deleted']);
                return response()->json([
                    'success' => true,
                    'message' => 'Customer Deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function visitors()
    {
        $active = 'customer';
        $record_perpage='20';
        $customers = VistorOrders::select('first_name','last_name','email')->distinct()->paginate(20);
        $data = compact('active', 'customers','record_perpage');
        return view('admin.visitors')->with($data);
    }

    public function delete_visitor(Request $request)
    {
        if ($request->ajax()) {
            $update = Customers::find($request->id);
            if ($update) {
                Customers::where('id','=',$request->id)->update(['status'=>'Deleted']);
                return response()->json([
                    'success' => true,
                    'message' => 'Customer Deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function edit_profile()
    {
        $active='';
        $admin = AdminModel::where('id','=',session()->get('admin.admin_id'))->first();
        $data = compact('active', 'admin');
        return view('admin.editProfile')->with($data);
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'password'=>'required|confirmed',
            'password_confirmation'=>'required'
        ]);
        $update = AdminModel::where('id','=',session()->get('admin.admin_id'))->update(['password'=>md5($request->password)]);
        if($update){
            notify()->success('Password Changed.','','topRight');
            return redirect(url('/admin/logout'));
        }else{
            notify()->error('Try Again.','','topRight');
            return redirect()->back();
        }        
    }

    public function update_profile(Request $request)
    {
        if(!empty($request->file('media'))){
            $main_image = $request->file('media');
            $path_main_image = Storage::disk('public')->put('admins', $main_image);
            if(!empty($path_main_image)){
                $update = AdminModel::where('id','=',session()->get('admin.admin_id'))->update(['name'=>$request->name,'media'=>$path_main_image]);
                if($update){
                    notify()->success('Profile Updated.','','topRight');
                    return redirect(url('/admin/logout'));
                }else{
                    notify()->error('Try Again.','','topRight');
                    return redirect()->back();
                }
            }else{
                notify()->error('Image Not uploaded','','topRight');
                return redirect()->back();
            }             
        }else{
            $update = AdminModel::where('id','=',session()->get('admin.admin_id'))->update(['name'=>$request->name]);
            if($update){
                notify()->success('Profile Updated.','','topRight');
                return redirect(url('/admin/logout'));
            }else{
                notify()->error('Try Again.','','topRight');
                return redirect()->back();
            }
        }   
    }

    public function shipping_companies()
    {
        $active='shipping';
        $companies=ShippingCompanies::where('status','=','Active')->paginate(10);
        $data=compact('active','companies');
        return view('admin.shippingCompanies')->with($data);
    }

    public function add_shipping_company(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'tracking_url'=>'required',
            'show'=>'required'
        ]);
        $company= new ShippingCompanies();
        $company->name=$request->name;
        $company->tracking_url=$request->tracking_url;
        $company->is_enable=$request->show;
        if($company->save()){
            notify()->success('Company Added.','','topRight');
        }else{
            notify()->error('Try Again.','','topRight');
        }
        return redirect()->back();
    }

    public function show_shipping_company(Request $request)
    {
        if ($request->ajax()) {
            $update = ShippingCompanies::where('id', '=', $request->id)->update(['is_enable' => $request->status]);
            if (!is_null($update)) {
                if($request->status == 'Yes'){
                    return response()->json([
                        'success' => true,
                        'message' => 'Company Shown'
                    ]);
                }else{
                    return response()->json([
                        'success' => true,
                        'message' => 'Company Hidden'
                    ]);
                }                
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }

    public function delete_shipping_company(Request $request)
    {
        if ($request->ajax()) {
            $update = ShippingCompanies::where('id', '=', $request->id)->update(['status' => 'Deleted']);
            if (!is_null($update)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Company Deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Try Again.'
                ]);
            }
        }
    }
}