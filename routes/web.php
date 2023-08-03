<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//prevent back
Route::group(['middleware' => 'preventBack'], function () {
    Route::get('/my-account', [MainController::class, 'account']);
    Route::get('/checkout', [MainController::class, 'check_out']);
    Route::post('/customer-order', [CustomerController::class, 'customer_order'])->name('customer.order');
    Route::get('/payment-success', [MainController::class, 'order_success'])->name('payment.success');
    Route::get('/payment-unsuccess', [MainController::class, 'order_unsuccess'])->name('payment.unsuccess');
    Route::get('/stripe-payment-form', [MainController::class, 'stripe_payment_form'])->name('stripe.form');
    Route::post('/stripe-payment', [CustomerController::class, 'stripe_payment'])->name('stripe.payment');

    //Admin Routes
    Route::get('/admin', [AdminController::class, 'index']);
    //Categories Routes
    Route::get('/admin/categories', [AdminController::class, 'category']);
    Route::post('/admin/show-category', [AdminController::class, 'show_category']);
    Route::post('/admin/delete-category', [AdminController::class, 'delete_category']);
    Route::post('/admin/add-category', [AdminController::class, 'add_category']);
    Route::post('/admin/get-sub-categories', [AdminController::class, 'sub_categories']);
    Route::post('/admin/get-sub-categories-by-slug', [AdminController::class, 'sub_categories_slug']);
    //Shipping Companies
    Route::get('/admin/shipping-companies', [AdminController::class, 'shipping_companies'])->name('Admin.shipping-companies');
    Route::post('/admin/add-shipping-company', [AdminController::class, 'add_shipping_company'])->name('Admin.add-shipping-company');
    Route::post('/admin/show-shipping-company', [AdminController::class, 'show_shipping_company'])->name('Admin.show-shipping-company');
    Route::post('/admin/delete-shipping-company', [AdminController::class, 'delete_shipping_company'])->name('Admin.delete-shipping-company');
    //Blog Categories
    Route::get('/admin/blog-categories', [AdminController::class, 'blog_categories']);
    Route::post('/admin/delete-blog-category', [AdminController::class, 'delete_blog_category']);
    Route::post('/admin/add-blog-category', [AdminController::class, 'add_blog_category']);
    //Sub Categories Routes
    Route::get('/admin/sub-categories', [AdminController::class, 'sub_category']);
    Route::post('/admin/show-sub-category', [AdminController::class, 'show_sub_category']);
    Route::post('/admin/delete-sub-category', [AdminController::class, 'delete_sub_category']);
    Route::post('/admin/add-sub-category', [AdminController::class, 'add_sub_category']);
    //Product Routes
    Route::get('/admin/products', [AdminController::class, 'product']);
    Route::get('/admin/add-product', [AdminController::class, 'add_product_page']);
    Route::post('/admin/add-product', [AdminController::class, 'add_product']);
    Route::get('/admin/delete-product/{id}', [AdminController::class, 'delete_product']);
    Route::get('/admin/edit-product/{id}', [AdminController::class, 'edit_product']);
    Route::post('/admin/update-basic', [AdminController::class, 'update_basic']);
    Route::post('/admin/update-extra', [AdminController::class, 'update_extra']);
    Route::post('/admin/update-shipping', [AdminController::class, 'update_shipping']);
    Route::post('/admin/update-tags', [AdminController::class, 'update_tags']);
    Route::post('/admin/update-badges', [AdminController::class, 'update_badges']);
    Route::post('/admin/update-account', [AdminController::class, 'update_account']);
    Route::post('/admin/update-main-image', [AdminController::class, 'update_main_image']);
    Route::post('/admin/update-supporting-image', [AdminController::class, 'update_supporting_image']);
    Route::post('/admin/update-attribute-value-price', [AdminController::class, 'update_attribute_value_price']);
    Route::post('/admin/update-attribute', [AdminController::class, 'update_attribute']);
    Route::post('/admin/remove-attribute-value', [AdminController::class, 'remove_attribute_value']);
    Route::post('/admin/remove-attribute', [AdminController::class, 'remove_attribute']);
    Route::post('/admin/product-publish', [AdminController::class, 'product_publish']);
    Route::post('/admin/product-filter', [AdminController::class, 'product_filter'])->name('Admin.product-filter');
    Route::post('/admin/product-by-id', [AdminController::class, 'product_by_id'])->name('Admin.product-by-id');

    //Attribute Routes
    Route::get('/admin/attribute', [AdminController::class, 'attribute']);
    Route::post('/admin/add-attribute', [AdminController::class, 'add_attribute']);
    Route::post('/admin/delete-attribute', [AdminController::class, 'delete_attribute']);
    //Attribute Value delete_attribute_value
    Route::get('/admin/attribute-value', [AdminController::class, 'attribute_value']);
    Route::post('/admin/add-attribute-value', [AdminController::class, 'add_attribute_value']);
    Route::post('/admin/delete-attribute-value', [AdminController::class, 'delete_attribute_value']);
    //Admins
    Route::get('/admin/admins', [AdminController::class, 'admins']);
    Route::post('/admin/delete-admin', [AdminController::class, 'delete_admin']);
    Route::post('/admin/add-admin', [AdminController::class, 'add_admin']);
    //Brands Routes
    Route::get('/admin/brands', [AdminController::class, 'brands']);
    Route::post('/admin/delete-brand', [AdminController::class, 'delete_brand']);
    Route::post('/admin/add-brand', [AdminController::class, 'add_brand']);
    //Register User Orders
    Route::get('/admin/register-users-new-orders', [AdminController::class, 'reg_users_new_orders'])->name('Admin.Reg-users-new-orders');
    Route::post('/admin/register-users-new-orders', [AdminController::class, 'get_reg_users_new_orders_by_status'])->name('Admin.get-ru-new-orders');
    Route::post('/admin/register-user-new-order', [AdminController::class, 'get_reg_users_new_orders_by_id'])->name('Admin.get-ru-new-order');
    Route::get('/admin/register-users-orders', [AdminController::class, 'reg_users_orders'])->name('Admin.Reg-users-orders');
    Route::post('/admin/register-users-orders', [AdminController::class, 'get_reg_users_orders_by_status'])->name('Admin.get-ru-orders');
    Route::post('/admin/register-user-order', [AdminController::class, 'get_reg_users_orders_by_id'])->name('Admin.get-ru-order');
    Route::get('/admin/register-user-order-detail/{id}', [AdminController::class, 'ru_order_detail']);
    Route::post('/admin/register-user-change-order-status', [AdminController::class, 'ru_order_change_status'])->name('Admin.ru-change-order-status');
    Route::post('/admin/register-user-change-order-status-dispatched', [AdminController::class, 'ru_order_change_status_dispatched'])->name('Admin.ru-change-order-status-dispatched');
    Route::post('/admin/register-user-change-order-status-return', [AdminController::class, 'ru_order_change_status_return'])->name('Admin.ru-change-order-status-return');
    Route::post('/admin/register-user-change-order-status-cancel', [AdminController::class, 'ru_order_change_status_cancel'])->name('Admin.ru-change-order-status-cancel');
    //Visitors Orders
    Route::get('/admin/visitors-new-orders', [AdminController::class, 'visitors_new_orders'])->name('Admin.Visitors-new-orders');
    Route::post('/admin/visitors-new-orders', [AdminController::class, 'get_risitors_new_orders_by_status'])->name('Admin.get-v-new-orders');
    Route::post('/admin/visitor-new-order', [AdminController::class, 'get_visitors_new_orders_by_id'])->name('Admin.get-v-new-order');
    Route::get('/admin/visitors-orders', [AdminController::class, 'visitors_orders'])->name('Admin.Visitors-orders');
    Route::post('/admin/visitors-orders', [AdminController::class, 'get_visitors_orders_by_status'])->name('Admin.get-v-orders');
    Route::post('/admin/visitor-order', [AdminController::class, 'get_visitors_orders_by_id'])->name('Admin.get-v-order');
    Route::get('/admin/visitor-order-detail/{id}', [AdminController::class, 'v_order_detail']);
    Route::post('/admin/visitor-change-order-status', [AdminController::class, 'v_order_change_status'])->name('Admin.v-change-order-status');
    Route::post('/admin/visitor-change-order-status-dispatched', [AdminController::class, 'v_order_change_status_dispatched'])->name('Admin.v-change-order-status-dispatched');
    Route::post('/admin/visitor-change-order-status-return', [AdminController::class, 'v_order_change_status_return'])->name('Admin.v-change-order-status-return');
    Route::post('/admin/visitor-change-order-status-cancel', [AdminController::class, 'v_order_change_status_cancel'])->name('Admin.v-change-order-status-cancel');
    //Currencies
    Route::get('/admin/currencies', [AdminController::class, 'currency']);
    Route::post('/admin/add-currency', [AdminController::class, 'add_currency']);
    Route::post('/admin/show-currency', [AdminController::class, 'show_currency']);
    Route::post('/admin/delete-currency', [AdminController::class, 'delete_currency']);
    Route::post('/admin/edit-currency', [AdminController::class, 'edit_currency']);
    Route::get('/oc/{id}', [AdminController::class, 'order_confirmation']);
    //Mails
    Route::get('/admin/sent-mails', [AdminController::class, 'sent_mails'])->name('Admin.sent-mails');
    Route::post('/admin/sent-mail', [AdminController::class, 'sent_mails_search'])->name('Admin.sent-mails-search');
    Route::post('/admin/sent-mails', [AdminController::class, 'sent_mails_pagination'])->name('Admin.sent-mails-pagination');
    Route::get('/admin/contact-us', [AdminController::class, 'contact_us'])->name('Admin.contact-us');
    Route::post('/admin/contact-us', [AdminController::class, 'contact_us_pagination'])->name('Admin.contact-us-page');
    Route::get('/admin/order-confirmation-template', [AdminController::class, 'order_confirmation_template'])->name('Admin.order-confirmation');
    Route::post('/admin/order-confirmation-template-set', [AdminController::class, 'order_confirmation_template_set'])->name('Admin.order-confirmation-set');
    Route::get('/admin/order-acceptence-template', [AdminController::class, 'order_acceptence_template'])->name('Admin.order-acceptence');
    Route::post('/admin/order-acceptence-template-set', [AdminController::class, 'order_acceptence_template_set'])->name('Admin.order-acceptence-set');
    Route::get('/admin/order-dispatching-template', [AdminController::class, 'order_dispatching_template'])->name('Admin.order-dispatching');
    Route::post('/admin/order-dispatching-template-set', [AdminController::class, 'order_dispatching_template_set'])->name('Admin.order-dispatching-set');
    Route::get('/admin/order-cancelation-template', [AdminController::class, 'order_cancelation_template'])->name('Admin.order-cancelation');
    Route::post('/admin/order-cancelation-template-set', [AdminController::class, 'order_cancelation_template_set'])->name('Admin.order-cancelation-set');
    Route::get('/admin/order-returning-template', [AdminController::class, 'order_returning_template'])->name('Admin.order-returning');
    Route::post('/admin/order-returning-template-set', [AdminController::class, 'order_returning_template_set'])->name('Admin.order-returning-set');
    Route::get('/admin/order-completion-template', [AdminController::class, 'order_completion_template'])->name('Admin.order-completion');
    Route::post('/admin/order-completion-template-set', [AdminController::class, 'order_completion_template_set'])->name('Admin.order-completion-set');
    Route::get('/admin/marketing-template', [AdminController::class, 'marketing_template'])->name('Admin.marketing');
    Route::post('/admin/marketing-template-set', [AdminController::class, 'marketing_template_set'])->name('Admin.marketing-set');
    //Product Reviews
    Route::get('/admin/products-reviews', [AdminController::class, 'reviews'])->name('Admin.reviews');
    Route::post('/admin/change-review-status', [AdminController::class, 'change_review_status'])->name('Admin.change-review-status');
    Route::post('/admin/reviews-by-status', [AdminController::class, 'get_reviews_by_status'])->name('Admin.reviews-by-status');
    Route::post('/admin/reviews-by-id', [AdminController::class, 'get_reviews_by_id'])->name('Admin.reviews-by-id');
    //Blogs
    Route::get('/admin/blogs', [AdminController::class, 'blogs'])->name('Admin.blogs');
    Route::get('/admin/edit-blog/{id}', [AdminController::class, 'blogs_edit'])->name('Admin.edit-blog');
    Route::post('/admin/change-trending', [AdminController::class, 'change_trending'])->name('Admin.change-trending');
    Route::post('/admin/blogs-by-category', [AdminController::class, 'get_blogs_by_category'])->name('Admin.blogs-by-category');
    Route::post('/admin/blogs-by-term', [AdminController::class, 'get_blogs_by_term'])->name('Admin.blogs-by-term');
    Route::get('/admin/add-blog', [AdminController::class, 'add_blog_page'])->name('Admin.add-blog');
    Route::post('/admin/add-blog', [AdminController::class, 'add_blog'])->name('Admin.add-blog-form');
    Route::get('/admin/edit-blog/{id}', [AdminController::class, 'edit_blog'])->name('Admin.edit-blog-form');
    Route::post('/admin/update-blog', [AdminController::class, 'update_blog'])->name('Admin.update-blog');
    Route::post('/admin/delete-blog', [AdminController::class, 'delete_blog'])->name('Admin.delete-blog');
    //Coupons
    Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('Admin.coupons');
    Route::post('/admin/add-coupon', [AdminController::class, 'add_coupon'])->name('Admin.add-coupon');
    Route::post('/admin/change-coupon-status', [AdminController::class, 'change_coupon_status'])->name('Admin.change-coupon-status');
    Route::get('/admin/used-coupons', [AdminController::class, 'used_coupons'])->name('Admin.used-coupons');
    Route::post('/admin/used-coupons', [AdminController::class, 'get_used_coupon_by_record'])->name('Admin.used-coupons-post');
    Route::post('/admin/used-coupon', [AdminController::class, 'get_used_coupon_by_term'])->name('Admin.used-coupons-term');
    //CMS
    Route::get('/admin/cms-about', [AdminController::class, 'cms_about'])->name('Admin.cms-about');
    Route::get('/admin/cms-privacy-policy', [AdminController::class, 'cms_policy'])->name('Admin.cms-privacy-policy');
    Route::get('/admin/cms-terms-conditions', [AdminController::class, 'cms_terms'])->name('Admin.cms-terms-conditions');
    Route::get('/admin/cms-blog', [AdminController::class, 'cms_blog'])->name('Admin.cms-blog');
    Route::get('/admin/cms-shop', [AdminController::class, 'cms_shop'])->name('Admin.cms-shop');
    Route::get('/admin/cms-blog-detail', [AdminController::class, 'cms_blog_detail'])->name('Admin.cms-blog-detail');
    Route::get('/admin/cms-product-detail', [AdminController::class, 'cms_product_detail'])->name('Admin.cms-product-detail');
    Route::post('/admin/update-cms-content', [AdminController::class, 'cms_update_content'])->name('Admin.update-cms-content');
    Route::post('/admin/update-cms-ad', [AdminController::class, 'cms_update_ad'])->name('Admin.update-cms-ad');
    Route::post('/admin/show-ad', [AdminController::class, 'show_ad'])->name('Admin.show-ad');
    //customers
    Route::get('/admin/subscribers', [AdminController::class, 'subscribers'])->name('Admin.subscribers');
    Route::get('/admin/customers', [AdminController::class, 'customers'])->name('Admin.customers');
    Route::post('/admin/delete-customer', [AdminController::class, 'delete_customer'])->name('Admin.delete-customer');
    Route::get('/admin/visitors', [AdminController::class, 'visitors'])->name('Admin.visitors');
    Route::post('/admin/delete-visitor', [AdminController::class, 'delete_visitor'])->name('Admin.delete-visitor');
    //Admin edit profile
    Route::get('/admin/edit-profile', [AdminController::class, 'edit_profile'])->name('Admin.edit-profile');
    Route::post('/admin/edit-profile', [AdminController::class, 'update_profile'])->name('Admin.update-profile');
    Route::post('/admin/change-password', [AdminController::class, 'change_password'])->name('Admin.change-password');
});
// Frontend Routes
Route::get('/', [MainController::class, 'home']);
Route::get('/about', [MainController::class, 'about']);
Route::get('/shop', [MainController::class, 'shop']);
Route::get('/shop/{cat}', [MainController::class, 'shop_cat']);
Route::get('/shop/{cat}/{sub_cat}', [MainController::class, 'shop_cat_sub']);
Route::get('/contact', [MainController::class, 'contact']);
Route::get('/blog', [MainController::class, 'blog']);
Route::get('/wishlist', [MainController::class, 'wishlist']);
Route::get('/cart', [MainController::class, 'cart']);
Route::get('/product-detail/{id}', [MainController::class, 'product_detail']);
Route::get('/blog-detail/{id}', [MainController::class, 'blog_detail']);
Route::get('/loginPage', [MainController::class, 'login']);
Route::get('/privacy-policy', [MainController::class, 'privacy_policy']);
Route::get('/terms&conditions', [MainController::class, 'terms']);
Route::get('/order-tracking', [MainController::class, 'order_tracking']);

//Customer Routes
Route::post('/subscribe', [CustomerController::class, 'subscribe']);
Route::post('/login', [CustomerController::class, 'login']);
Route::post('/signup', [CustomerController::class, 'signUp']);
Route::get('/logout', [CustomerController::class, 'logout']);
Route::post('/AddToCart', [CustomerController::class, 'addToCart']);
Route::post('/delete-cart', [CustomerController::class, 'delete_cart']);
Route::post('/AddToCartPage', [CustomerController::class, 'addToCartPage']);
Route::post('/AddToWishlist', [CustomerController::class, 'addToWishlist']);
Route::post('/delete-wishlist', [CustomerController::class, 'delete_wishlist']);
Route::post('/contactUs', [CustomerController::class, 'contact_Us']);
Route::post('/update', [CustomerController::class, 'update']);
Route::post('/update-billing-address', [CustomerController::class, 'update_billing_address'])->name('billing.form');
Route::post('/currency-load', [CustomerController::class, 'currency_load'])->name('currency-load');
Route::post('/track-order', [CustomerController::class, 'track_order'])->name('track.order');
Route::post('/rating', [CustomerController::class, 'rating'])->name('rating');
Route::post('/apply-coupon', [CustomerController::class, 'apply_coupon'])->name('apply-coupon');
//Admin 
Route::get('/admin/login', [AdminController::class, 'loginPage']);
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/logout', [AdminController::class, 'logout']);
