@extends('backend.master')

@section('header_css')
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        .btn-print {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('page_title')
    Invoice - {{ $order->invoice_no }}
@endsection

@section('page_heading')
    Invoice Details
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-right mb-3">
                        {{-- <a href="{{ route('PrintInvoice', $order->id) }}" target="_blank" class="btn btn-success btn-print">
                            <i class="fas fa-print"></i> Print Invoice
                        </a> --}}
                        <a href="{{ route('ViewAllInvoices') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>

                    <div class="invoice-box">
                        <table cellpadding="0" cellspacing="0">
                            <tr class="top">
                                <td colspan="2">
                                    <table>
                                        <tr>
                                            <td class="title">
                                                @if($generalInfo && $generalInfo->logo)
                                                    <img src="{{ url( $generalInfo->logo) }}" style="width:100%; max-width:200px;">
                                                @else
                                                    <h2>{{ $generalInfo->company_name ?? 'Company Name' }}</h2>
                                                @endif
                                            </td>
                                            <td>
                                                Invoice #: {{ $order->invoice_no }}<br>
                                                Order #: {{ $order->order_no }}<br>
                                                Invoice Date: {{ date('d M Y', strtotime($order->invoice_date)) }}<br>
                                                Order Date: {{ date('d M Y', strtotime($order->order_date)) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr class="information">
                                <td colspan="2">
                                    <table>
                                        <tr>
                                            <td>
                                                <strong>{{ $generalInfo->company_name ?? 'Company Name' }}</strong><br>
                                                {{ $generalInfo->address ?? 'Company Address' }}<br>
                                                Phone: {{ $generalInfo->phone ?? 'Phone Number' }}<br>
                                                Email: {{ $generalInfo->email ?? 'Email Address' }}
                                            </td>
                                            <td>
                                                <strong>Bill To:</strong><br>
                                                {{ $order->shippingInfo->full_name ?? 'Customer Name' }}<br>
                                                {{ $order->shippingInfo->address ?? '' }}<br>
                                                {{ $order->shippingInfo->city ?? '' }}, {{ $order->shippingInfo->thana ?? '' }}<br>
                                                Phone: {{ $order->shippingInfo->phone ?? '' }}<br>
                                                Email: {{ $order->shippingInfo->email ?? '' }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr class="heading">
                                <td>Item</td>
                                <td>Price</td>
                            </tr>

                            @foreach($orderDetails as $index => $detail)
                            <tr class="item {{ $loop->last ? 'last' : '' }}">
                                <td>
                                    <strong>{{ $detail->product_name }}</strong>
                                    @if($detail->product_code)
                                        <br><small>Code: {{ $detail->product_code }}</small>
                                    @endif
                                    @if($detail->color_name || $detail->size_name)
                                        <br><small>
                                            @if($detail->color_name) Color: {{ $detail->color_name }} @endif
                                            @if($detail->size_name) Size: {{ $detail->size_name }} @endif
                                        </small>
                                    @endif
                                    <br><small>Qty: {{ $detail->qty }} {{ $detail->unit_name ?? 'pcs' }} × ৳{{ number_format($detail->unit_price, 2) }}</small>
                                </td>
                                <td>৳{{ number_format($detail->total_price, 2) }}</td>
                            </tr>
                            @endforeach

                            @if($order->discount > 0)
                            <tr class="item">
                                <td>Discount</td>
                                <td>-৳{{ number_format($order->discount, 2) }}</td>
                            </tr>
                            @endif

                            @if($order->delivery_fee > 0)
                            <tr class="item">
                                <td>Delivery Fee</td>
                                <td>৳{{ number_format($order->delivery_fee, 2) }}</td>
                            </tr>
                            @endif

                            @if($order->vat > 0)
                            <tr class="item">
                                <td>VAT</td>
                                <td>৳{{ number_format($order->vat, 2) }}</td>
                            </tr>
                            @endif

                            @if($order->tax > 0)
                            <tr class="item">
                                <td>Tax</td>
                                <td>৳{{ number_format($order->tax, 2) }}</td>
                            </tr>
                            @endif

                            <tr class="total">
                                <td></td>
                                <td>Total: ৳{{ number_format($order->total, 2) }}</td>
                            </tr>
                        </table>

                        @if($order->order_note)
                        <div class="mt-4">
                            <strong>Order Note:</strong><br>
                            {{ $order->order_note }}
                        </div>
                        @endif

                        <div class="mt-4 text-center">
                            <small>Thank you for your business!</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
