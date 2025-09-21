@extends('backend.master')
@section('header_css')
    <style>
        .add-button {
            background-color: #0d1a2b;
            color: #e1e4e9;
            border-color: #2c4762;
        }
        .add-button:hover {
            background-color: #0d1a2b;
            color: #e1e4e9;
            border-color: #2c4762;
        }
        .add-button:active {
            background-color: #0d1a2b;
            color: #e1e4e9;
            border-color: #2c4762;
        }
        .card-header{
            background-color:#17263a; 
            border-top:5px solid #0d1a2b;
            color:#e1e4e9;
            border-radius-top-left: 8px;
            border-radius-top-right: 8px;
        }
        .card-header > .card-title{
            color:#e1e4e9;
        }
        .account-header-title {
            background-color:#17263a; 
            border-top:5px solid #0d1a2b;
            color:#e1e4e9;
        }
        #addLineItem{
            width: 47%;
        }
    </style>
@endsection
@section('title', 'Payment Voucher Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Payment Voucher Details</h4>
                    <div class="card-tools">
                        <a href="{{ route('payment-voucher.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('payment-voucher.edit', $paymentVoucher->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('payment-voucher.print', $paymentVoucher->id) }}" class="btn btn-info" target="_blank">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Voucher No:</th>
                                    <td>{{ $paymentVoucher->voucher_no ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td>{{ $paymentVoucher->trans_date ? (is_string($paymentVoucher->trans_date) ? \Carbon\Carbon::parse($paymentVoucher->trans_date)->format('d/m/Y') : $paymentVoucher->trans_date->format('d/m/Y')) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount:</th>
                                    <td>{{ number_format($paymentVoucher->amount ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge badge-{{ ($paymentVoucher->status ?? 0) ? 'success' : 'danger' }}">
                                            {{ ($paymentVoucher->status ?? 0) == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Remarks:</th>
                                    <td>{{ $paymentVoucher->comments ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <h5>Payment Entries</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Code</th>
                                    <th style="text-align: center;">Particulars</th>
                                    <th style="text-align: center;">Debit</th>
                                    <th style="text-align: center;">Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($debitEntries) && count($debitEntries) > 0)
                                    {{-- Debit Entries First --}}
                                    @foreach($debitEntries as $entry)
                                        <tr>
                                            <td>{{ $entry['code'] ?? 'N/A' }}</td>
                                            <td>{{ $entry['particulars'] ?? 'N/A' }}</td>
                                            <td>{{ number_format($entry['amount'], 2) }}</td>
                                            <td>0.00</td>
                                        </tr>
                                    @endforeach
                                    
                                    {{-- Credit Entries Second --}}
                                    @if(isset($creditEntries) && count($creditEntries) > 0)
                                        @foreach($creditEntries as $entry)
                                            <tr>
                                                <td>{{ $entry['code'] ?? 'N/A' }}</td>
                                                <td>{{ $entry['particulars'] ?? 'N/A' }}</td>
                                                <td>0.00</td>
                                                <td>{{ number_format($entry['amount'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    
                                    {{-- Total Row --}}
                                    <tr style="background-color: #f8f9fa; font-weight: bold;">
                                        <td colspan="2" class="text-right"><strong>Total:</strong></td>
                                        <td><strong>{{ number_format($totalDebit ?? 0, 2) }}</strong></td>
                                        <td><strong>{{ number_format($totalCredit ?? 0, 2) }}</strong></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No entries found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- In Word Section --}}
                    @if(isset($amountInWords))
                        <div class="mt-3">
                            <strong>In Word: {{ $amountInWords }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
