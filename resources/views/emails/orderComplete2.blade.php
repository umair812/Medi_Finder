@php
$order = \App\Models\VistorOrders::where('id', '=', $id)
    ->with('vistor_order_details','vistor_order_details.products')
    ->first();
$template = \App\Models\MailsTemplates::where('id', '=', 6)->first();
$sent_mail=new \App\Models\SentMails();
$sent_mail->mail=$order->email;
$sent_mail->name=$order->first_name.' '.$order->last_name;
$sent_mail->subject="Order Completed";
$sent_mail->order_number="SDVO".$order->id;
$sent_mail->bill=$order->bill;
$sent_mail->save();
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Order Completed</title>
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
                                <td class="border-0 text-center"> Dear {{ $order->first_name }} {{ $order->last_name }},</td>
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
