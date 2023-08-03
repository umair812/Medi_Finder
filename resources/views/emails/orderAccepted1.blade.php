@php
$order = \App\Models\Orders::where('id', '=', $id)
    ->with('customers', 'order_details', 'order_details.products', 'order_billing_addresses')
    ->first();
$template = \App\Models\MailsTemplates::where('id', '=', 2)->first();
$sent_mail=new \App\Models\SentMails();
$sent_mail->mail=$order->customers->email_addr;
if($order->is_same_as_billing == 1){
    $sent_mail->name=$order->customers->first_name.' '.$order->customers->last_name;
}else{
    $sent_mail->name=$order->order_billing_addresses->first_name.' '.$order->order_billing_addresses->last_name;
}
$sent_mail->subject="Order Accepted";
$sent_mail->order_number="SDRO".$order->id;
$sent_mail->bill=$order->bill;
$sent_mail->save();
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Order Confirmation</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/website/Logo.png') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- Start Common CSS -->
    <!-- End Common CSS -->
    <style>
        body {
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
        }
        tr{
            border: 0
        }
        table{
            border: 0
        }
        td{
            border: 0
        }
        tbody{
            border: 0
        }
    </style>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0" class="border-0">
        <tbody class="border-0">
            <tr class="border-0">
                <td class="border-0">
                    <table width="600" align="center" cellpadding="15" cellspacing="0" border="0"
                        class="border-0" style="background-color: #ffffff;">
                        <tbody class="border-0">
                            <!-- Start header Section -->
                            <tr class="border-0">
                                <td style="padding-top: 30px;" class="border-0">
                                    <table width="560" align="center" cellpadding="0" cellspacing="0" border="0"
                                    class="border-0"
                                        style="border-bottom: 1px solid #eeeeee; text-align: center;">
                                        <tbody class="border-0">
                                            <tr class="border-0">
                                                <td class="logo logo-width-1 border-0">
                                                    <a href="{{ url('/') }}"><img src="{{ asset('uploads/website/Logo.png') }}"
                                                        alt="logo" height="30px" width="30px"></a>
                                                </td>
                                            </tr>
                                            <tr class="border-0">
                                                <td class="border-0">
                                                    Email: <a
                                                        href="mailto:m.arslan77733@gmail.com">sales@baggagefactory.co.uk</a>
                                                </td>
                                            </tr>
                                            <tr class="border-0">
                                                <td class="border-0">
                                                    <strong>Order Number:</strong> SDRO{{ $order->id }} | <strong>Order
                                                        Date:</strong>
                                                    {{ date_format($order->created_at, 'd M Y') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!-- End header Section -->
                            <tr class="border-0">
                                <td class="border-0 text-center">{{ $template->content }}</td>
                            </tr>
                            <!-- Start product Section -->
                                <tr class="border-0">
                                    <td class="border-0">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" class="border-0">
                                            <tbody class="border-0">
                                                <tr class="border-0">
                                                    <td class="border-0">S.No#</td>
                                                    <td class="border-0">Image</td>
                                                    <td class="border-0" colspan="2">Name</td>
                                                    <td class="border-0">Quantity</td>
                                                    <td class="border-0">Per Unit Price</td>
                                                    <td class="border-0">Product Bill</td>
                                                </tr>
                                                @php
                                                    $i=1;
                                                @endphp
                                                @foreach ($order->order_details as $item)
                                                    <tr class="border-0">
                                                        <td class="border-0">{{ $i }}</td>
                                                        <td class="border-0 image product-thumbnail">
                                                            <img class="img-xs" src="{{ asset('/uploads/' . $item->products->main_media) }}" alt="Product Image" />
                                                        </td>
                                                        <td class="border-0" colspan="2" title="{{ $item->products->title }}">
                                                            <strong>{{ count_text($item->products->title) }}</strong>
                                                        </td>
                                                        <td class="border-0">{{ $item->qty }}</td>
                                                        <td class="border-0">
                                                            {{ currency_converter($item->sub_bill / $item->qty) }}
                                                        </td>
                                                        <td class="border-0">
                                                            <b>{{ currency_converter($item->sub_bill) }}</b>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            <!-- End product Section -->

                            <!-- Start calculation Section -->
                            <tr class="border-0">
                                <td class="border-0">
                                    <table width="560" align="center" cellpadding="0" cellspacing="0" class="border-0">
                                        <tbody class="border-0">
                                            <tr class="border-0">
                                                <td rowspan="5" style="width: 55%;" class="border-0"></td>
                                                <td class="border-0">
                                                    Sub-Total
                                                </td>
                                                <td class="border-0">
                                                    {{ currency_converter($order->bill) }}
                                                </td>
                                            </tr>
                                            <tr class="border-0">
                                                <td class="border-0">
                                                    Shipping Fee
                                                </td>
                                                <td class="border-0">
                                                    Free
                                                </td>
                                            </tr>
                                            <tr class="border-0">
                                                <td class="border-0">
                                                    <strong>Order Total</strong>
                                                </td>
                                                <td class="border-0">
                                                    {{ currency_converter($order->bill) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!-- End calculation Section -->

                            <!-- Start payment method Section -->
                            <tr class="border-0">
                                <td class="border-0">
                                    <table width="560" align="center" cellpadding="0" cellspacing="0" class="border-0">
                                        <tbody class="border-0">
                                            <tr class="border-0">
                                                <td colspan="2" class="border-0">
                                                    <span class="h4">Payment Status :</span> <i
                                                        class="badge-info">{{ $order->payment_method }}</i>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!-- End payment method Section -->

                            <!-- Start address Section -->
                            <tr class="border-0">
                                <td class="border-0">
                                    <table width="560" align="center" cellpadding="0" cellspacing="0" class="border-0">
                                        <tbody class="border-0">
                                            @if ($order->is_same_as_billing == 1)
                                                <tr class="border-0">
                                                    <td class="border-0">
                                                        <strong>Delivery Adderss</strong>
                                                    </td>
                                                    <td class="border-0">
                                                        <strong>Billing Address</strong>
                                                    </td>
                                                </tr>
                                                <tr class="border-0">
                                                    <td class="border-0">
                                                        {{ $order->customers->first_name }}
                                                        {{ $order->customers->last_name }}
                                                    </td>
                                                    <td class="border-0">
                                                        {{ $order->customers->first_name }}
                                                        {{ $order->customers->last_name }}
                                                    </td>
                                                </tr>
                                                <tr class="border-0">
                                                    <td class="border-0">
                                                        {{ $order->customers->address1 }}
                                                    </td>
                                                    <td class="border-0">
                                                        {{ $order->customers->address1 }}
                                                    </td>
                                                </tr>
                                                <tr class="border-0">
                                                    <td class="border-0">
                                                        {{ $order->customers->city }},
                                                        {{ $order->customers->postal_code }}
                                                    </td>
                                                    <td class="border-0">
                                                        {{ $order->customers->city }},
                                                        {{ $order->customers->postal_code }}
                                                    </td>
                                                </tr>
                                            @else
                                                <tr class="border-0">
                                                    <td class="border-0">
                                                        <strong>Delivery Adderss</strong>
                                                    </td>
                                                    <td class="border-0">
                                                        <strong>Billing Address</strong>
                                                    </td>
                                                </tr>
                                                <tr class="border-0">
                                                    <td class="border-0">
                                                        {{ $order->order_billing_addresses->first_name }}
                                                        {{ $order->order_billing_addresses->last_name }}
                                                    </td>
                                                    <td class="border-0">
                                                        {{ $order->order_billing_addresses->first_name }}
                                                        {{ $order->order_billing_addresses->last_name }}
                                                    </td>
                                                </tr>
                                                <tr class="border-0">
                                                    <td class="border-0">
                                                        {{ $order->order_billing_addresses->address1 }}
                                                    </td>
                                                    <td class="border-0">
                                                        {{ $order->order_billing_addresses->address1 }}
                                                    </td>
                                                </tr>
                                                <tr class="border-0">
                                                    <td class="border-0">
                                                        {{ $order->order_billing_addresses->city }},
                                                        {{ $order->order_billing_addresses->postal_code }}
                                                    </td>
                                                    <td class="border-0">
                                                        {{ $order->order_billing_addresses->city }},
                                                        {{ $order->order_billing_addresses->postal_code }}
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!-- End address Section -->

                            <!-- Start payment method Section -->
                            <tr class="border-0">
                                <td class="border-0">
                                    {!! $template->extra_content !!}
                                </td>
                            </tr>
                            <!-- End payment method Section -->
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
