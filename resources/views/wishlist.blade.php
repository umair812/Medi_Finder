@extends('layouts.main')
@push('head')
    <title>Wishlist | Baggage Factory</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- FontAwesome 6.1.1 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('section')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow">Home</a>
                    <span></span> Your Wishlist
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            @if (!empty($wishlists))
                                <table class="table shopping-summery text-center">
                                    <thead>
                                        <tr class="main-heading">
                                            <th scope="col" colspan="2">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Stock Status</th>
                                            <th scope="col">Action</th>
                                            <th scope="col">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wishlists as $item)
                                            <tr>
                                                @foreach ($products as $product)
                                                    @if ($product->id == $item['products_id'])
                                                        <td class="image product-thumbnail"><img
                                                                src="{{ asset('uploads/' . $product->main_media) }}"
                                                                alt="#">
                                                        </td>
                                                        <td class="product-des product-name">
                                                            <h5 class="product-name"><a
                                                                    href="{{ url('/product-detail/' . $product->id) }}">{{ $product->title }}</a>
                                                            </h5>
                                                            @if ($product->content != 0)
                                                                <p class="font-xs">{{ $product->content }}</p>
                                                            @endif
                                                        </td>
                                                        @php
                                                            $price = 0;
                                                        @endphp
                                                        <td class="price" data-title="Price"><span>@if ($product->sale_price > 0)
                                                                    {{ currency_converter($product->sale_price) }}
                                                                    @php
                                                                        $price = $product->sale_price;
                                                                    @endphp
                                                                @else
                                                                    {{ currency_converter($product->price) }}
                                                                    @php
                                                                        $price = $product->price;
                                                                    @endphp
                                                                @endif </span></td>
                                                        <td class="text-center" data-title="Stock">
                                                            <span
                                                                class="color3 font-weight-bold">{{ $product->stock_availability }}</span>
                                                        </td>
                                                        @if ($product->stock_availability == 'In Stock')
                                                            <td class="text-right" data-title="Cart">
                                                                <button class="btn btn-sm"
                                                                    onclick="addToCart({{ $product->id }},{{ $price }},1)"><i
                                                                        class="fi-rs-shopping-bag mr-5"></i>Add to
                                                                    cart</button>
                                                            </td>
                                                        @else
                                                            <td class="text-right" data-title="Cart">
                                                                <button class="btn btn-sm btn-secondary"><i
                                                                        class="fi-rs-headset mr-5"></i>Contact
                                                                    Us</button>
                                                            </td>
                                                        @endif
                                                        <td class="action" data-title="Remove"><a
                                                            onclick="deleteWishlist({{ $product->id }})"><i
                                                                class="fi-rs-trash"></i></a></td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="container d-flex justify-content-center align-items-center">
                                    <h1 class="text-black-50"><i class="fa fa-heart-circle-exclamation"></i> Empty Wishlist</h1>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('footer')
    <!-- (Optional) Use CSS or JS implementation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function addToCart(id, price, qty) {
            price = price * qty;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "post",
                url: "{{ url('/AddToCart') }}",
                data: {
                    "product_id": id,
                    "product_price": price,
                    "product_qty": qty
                },
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            position: 'topRight',
                            message: response.message
                        });
                        $('#cartheading').html(response.qty);
                    } else {
                        iziToast.warning({
                            position: 'topRight',
                            message: response.message
                        });
                    }
                }
            });
        }

        function deleteWishlist(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "post",
                url: "{{ url('/delete-wishlist') }}",
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
