@extends('layouts.main')
@push('head')
    <title>Cart | Baggage Factory</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- FontAwesome 6.1.1 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@php
$total_cart_price = 0;
$per_item_price = 0;
$set_price = 0;
@endphp

<script>
    let updateCart = [];
</script>
@section('section')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow">Home</a>
                    <span></span> Your Cart
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @if (!empty($cart))
                            <div class="table-responsive">
                                <table class="table shopping-summery text-center clean">
                                    <thead>
                                        <tr class="main-heading">
                                            <th scope="col">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Subtotal</th>
                                            <th scope="col">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $price = 0;
                                        @endphp
                                        @foreach ($carts as $item)
                                            @foreach ($products as $product)
                                                @if ($product->id == $item['products_id'])
                                                    @if ($product->sale_price > 0)
                                                        @php
                                                            $set_price = $product->sale_price;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $set_price = $product->price;
                                                        @endphp
                                                    @endif
                                                    <script>
                                                        updateCart.push({
                                                            id: {{ $item['products_id'] }},
                                                            price: {{ $set_price }}
                                                        });
                                                    </script>

                                                    <tr>
                                                        <td class="image product-thumbnail"><img
                                                                src="{{ asset('uploads/' . $product->main_media) }}"
                                                                alt="#">
                                                        </td>
                                                        <td class="product-des product-name">
                                                            <h5 class="product-name"><a
                                                                    href="javascript:void(0)">{{ $product->title }}</a>
                                                            </h5>
                                                            @if (!empty($product->content))
                                                                <p class="font-xs">{{ $product->content }}</p>
                                                            @endif
                                                        </td>
                                                        <td class="price" data-title="Price">

                                                            <span id="per_unit_price_{{ $product->id }}">
                                                                @if ($product->sale_price > 0)
                                                                    {{ currency_converter($product->sale_price) }}
                                                                @else
                                                                    {{ currency_converter($product->price) }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td class="text-center" data-title="Stock">
                                                            <input type="number" class="detail-qty border radius  m-auto"
                                                                id="qty_val_{{ $product->id }}" min="1"
                                                                max="{{ $product->quantity }}"
                                                                value="{{ $item['qty'] }}" />
                                                        </td>
                                                        <td class="text-right" data-title="Cart">
                                                            <span>{{ currency_converter($item['price']) }} </span>
                                                        </td>
                                                        <td class="action" data-title="Remove"><a
                                                                onclick="deleteCart({{ $product->id }})"
                                                                class="text-muted"><i class="fi-rs-trash"></i></a></td>
                                                    </tr>
                                                    @php
                                                        $per_item_price = $item['price'];
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @php
                                                $total_cart_price = $total_cart_price + $per_item_price;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart-action text-end">
                                <button class="btn  mr-10 mb-sm-15" onclick="addToCart()"><i
                                        class="fi-rs-shuffle mr-10"></i>Update Cart</button>
                                <a class="btn " href="{{ url('/shop') }}"><i
                                        class="fi-rs-shopping-bag mr-10"></i>Continue
                                    Shopping</a>
                            </div>
                            <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>
                            <div class="row mb-50">
                                <div class="col-lg-6 col-md-12">
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="border p-md-4 p-30 border-radius cart-totals">
                                        <div class="heading_s1 mb-3">
                                            <h4>Cart Totals</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td class="cart_total_label">Cart Subtotal</td>
                                                        <td class="cart_total_amount"><span
                                                                class="font-lg fw-900 text-brand">{{ currency_converter($total_cart_price) }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="cart_total_label">Shipping</td>
                                                        <td class="cart_total_amount"> <i class="ti-gift mr-5"></i> Free
                                                            Shipping</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="cart_total_label">Total</td>
                                                        <td class="cart_total_amount"><strong><span
                                                                    class="font-xl fw-900 text-brand">{{ currency_converter($total_cart_price) }}</span></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <a href="{{ url('/checkout') }}" class="btn"> <i
                                                class="fi-rs-box-alt mr-10"></i> Proceed To
                                            CheckOut</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="container d-flex justify-content-center align-items-center">
                                <h1 class="text-black-50"><i class="fa fa-cart-arrow-down"></i> Empty Cart</h1>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('footer')
    <!-- (Optional) Use CSS or JS implementation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"
        integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function addToCart() {
            let products_data = [];
            let product = {};
            console.log(updateCart);
            $.each(updateCart, function(index, value) {
                products_data.push({
                    id: value.id,
                    price: value.price,
                    qty: parseInt($('#qty_val_' + value.id).val())
                });
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "post",
                url: "{{ url('/AddToCartPage') }}",
                data: {
                    'products': JSON.stringify(products_data)
                },
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            position: 'topRight',
                            message: response.message
                        });
                        window.location.reload();
                    } else {
                        iziToast.warning({
                            position: 'topRight',
                            message: response.message
                        });
                    }
                }
            });
        }

        function deleteCart(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "post",
                url: "{{ url('/delete-cart') }}",
                data: {
                    "product_id": id
                },
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            position: 'topRight',
                            message: response.message
                        });
                        window.location.reload();
                    } else {
                        iziToast.warning({
                            position: 'topRight',
                            message: response.message
                        });
                    }
                }
            });
        }
    </script>
@endpush
