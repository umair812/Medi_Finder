@php
$order = \App\Models\Orders::where('id', '=', $id)
    ->with('customers', 'order_details', 'order_details.products', 'order_billing_addresses')
    ->first();
$template = \App\Models\MailsTemplates::where('id', '=', 3)->first();
$sent_mail=new \App\Models\SentMails();
$sent_mail->mail=$order->customers->email_addr;
if($order->is_same_as_billing == 1){
    $sent_mail->name=$order->customers->first_name.' '.$order->customers->last_name;
}else{
    $sent_mail->name=$order->order_billing_addresses->first_name.' '.$order->order_billing_addresses->last_name;
}
$sent_mail->subject="Order Dispatched";
$sent_mail->order_number="SDRO".$order->id;
$sent_mail->bill=$order->bill;
$sent_mail->save();
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Order Dispatched</title>
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
                    <table cellpadding="15" cellspacing="0"
                        class="border-0" style="background-color: #ffffff;">
                        <tbody class="border-0">
                            <!-- Start header Section -->
                            <tr class="border-0">
                                <td style="padding-top: 30px;" class="border-0">
                                    <table width="560" cellpadding="0" cellspacing="0"
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
                                                    <strong>Order Number:</strong> order number | <strong>Order
                                                        Date:</strong>
                                                    order date
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0 text-center"> Dear @if ($order->is_same_as_billing == 1)
                                    {{ $order->customers->first_name }} {{ $order->customers->last_name }}
                                @else
                                    {{ $order->order_billing_addresses->first_name }} {{ $order->order_billing_addresses->last_name }}
                                @endif,</td>
                            </tr>
                            <!-- End header Section -->
                            <tr class="border-0">
                                <td class="border-0 text-center">{{ $template->content }}</td>
                            </tr>

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
