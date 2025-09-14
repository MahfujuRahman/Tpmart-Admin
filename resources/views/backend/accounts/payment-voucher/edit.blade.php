@extends('backend.master')

@section('header_css')
    <link href="{{ url('assets') }}/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 36px !important;
            user-select: none !important;
            -webkit-user-select: none !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #444;
                line-height: 40px;
            }
        .card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: none;
            border-radius: 8px;
        }
        
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .btn-create {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 8px;
            color: white;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .btn-create:hover {
            background: linear-gradient(135deg, #218838, #1ea085);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
            color: white;
        }
        
        .btn-create:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
        }
        
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            padding: 15px 12px;
        }
        
        .table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .badge {
            font-size: 0.75em;
            padding: 0.5em 0.75em;
            border-radius: 0.375rem;
        }
        
        .btn-action {
            padding: 6px 12px;
            margin: 2px;
            border-radius: 4px;
            font-size: 0.875rem;
            border: none;
            transition: all 0.2s ease;
        }
        
        .btn-edit {
            background-color: #ffc107;
            color: #212529;
        }
        
        .btn-edit:hover {
            background-color: #e0a800;
            color: #212529;
        }
        
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        
        .btn-warning:hover {
            background-color: #e0a800;
            color: #212529;
        }
        
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background-color: #218838;
            color: white;
        }
        
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            margin-bottom: 20px;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 5px 10px;
        }
        
        .dataTables_wrapper .dataTables_length {
            float: left;
            margin-bottom: 20px;
        }
        
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 5px;
            margin: 0 5px;
        }
        
        .dataTables_wrapper .dataTables_info {
            clear: both;
            float: left;
            padding-top: 0.755em;
        }
        
        .dataTables_wrapper .dataTables_paginate {
            float: right;
            text-align: right;
            padding-top: 0.25em;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            box-sizing: border-box;
            display: inline-block;
            min-width: 1.5em;
            padding: 0.5em 1em;
            margin-left: 2px;
            text-align: center;
            text-decoration: none !important;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 2px;
            background: transparent;
            color: #333 !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: white !important;
            border: 1px solid #111;
            background-color: #585858;
            background: linear-gradient(to bottom, #585858 0%, #111 100%);
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: white !important;
            border: 1px solid #979797;
            background-color: #585858;
            background: linear-gradient(to bottom, #585858 0%, #111 100%);
        }

        /* Empty State Styles */
        .empty-state-icon {
            opacity: 0.6;
            animation: float 3s ease-in-out infinite;
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

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .dataTables_empty {
            padding: 0 !important;
        }

        .dataTables_empty td {
            border: none !important;
            padding: 0 !important;
        }
    </style>
@endsection
@section('title', 'Edit Payment Voucher')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Payment Voucher</h4>
                    <div class="card-tools">
                        <a href="{{ route('payment-voucher.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="paymentVoucherForm" method="POST" action="{{ route('payment-voucher.update', $paymentVoucher->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="trans_date">Payment Date *</label>
                                    <input type="date" class="form-control" id="trans_date" name="trans_date" 
                                           value="{{ old('trans_date', $paymentVoucher->trans_date ? $paymentVoucher->trans_date->format('Y-m-d') : date('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="voucher_no">Voucher No</label>
                                    <input type="text" class="form-control" id="voucher_no" name="voucher_no" 
                                           value="{{ old('voucher_no', $paymentVoucher->voucher_no) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="total_amount">Total Amount *</label>
                                    <input type="number" class="form-control" id="total_amount" name="total_amount" 
                                           step="0.01" value="{{ old('total_amount', $paymentVoucher->amount) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" class="form-control" id="remarks" name="remarks" 
                                           value="{{ old('remarks', $paymentVoucher->comments) }}" placeholder="Enter remarks">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Add New Entry Section -->
                        <div class="row">
                            <div class="col-12">
                                <h5>Add New Payment Entry</h5>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="general_ledger">General Ledger *</label>
                                    <select class="form-control select2 @error('group_id') is-invalid @enderror" id="general_ledger" name="general_ledger">
                                        <option value="">-- Choose General Ledger --</option>
                                        @foreach($groups as $group)
                                            <optgroup label="{{ $group->name }} ({{ $group->code }})">
                                                @foreach($group->subsidiaryLedgers as $subsidiary)
                                                    <option value="{{ $subsidiary->id }}" data-group="{{ $group->name }}">
                                                        {{ $subsidiary->name }} ({{ $subsidiary->ledger_code }})
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('group_id')
                                        <div class="invalid-feedback d-block">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_by">Payment By *</label>
                                    <select class="form-control select2 @error('group_id') is-invalid @enderror" id="payment_by" name="payment_by">
                                        <option value="">-- Choose Payment By --</option>
                                        @foreach($groups as $group)
                                            <optgroup label="{{ $group->name }} ({{ $group->code }})">
                                                @foreach($group->subsidiaryLedgers as $subsidiary)
                                                    <option value="{{ $subsidiary->id }}" data-group="{{ $group->name }}">
                                                        {{ $subsidiary->name }} ({{ $subsidiary->ledger_code }})
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('group_id')
                                        <div class="invalid-feedback d-block">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="paid_amount">Paid Amount *</label>
                                    <input type="number" class="form-control" id="paid_amount" name="paid_amount" step="0.01" placeholder="e.g. 50000">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="button" class="btn btn-success" id="addLineItem">
                                            <i class="fas fa-plus"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Line Items Section -->
                        <div class="row">
                            <div class="col-12">
                                <h5>Payment Entries</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="lineItemsTable">
                                        <thead>
                                            <tr>
                                                <th>General Ledger</th>
                                                <th>Payment By</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lineItemsBody">
                                            @if($paymentVoucher->accTransactionDetails->count() > 0)
                                                @foreach($paymentVoucher->accTransactionDetails as $detail)
                                                    <tr>
                                                        <td>
                                                            <select class="form-control general_ledger" name="line_items[{{ $loop->index }}][general_ledger_id]" required>
                                                                <option value="">-- Choose General Ledger --</option>
                                                                @foreach($groups as $group)
                                                                    <optgroup label="{{ $group->name }} ({{ $group->code }})">
                                                                        @foreach($group->subsidiaryLedgers as $subsidiary)
                                                                            <option value="{{ $subsidiary->id }}" 
                                                                                {{ $detail->dr_sub_ledger == $subsidiary->id ? 'selected' : '' }}
                                                                                data-group="{{ $group->name }}">
                                                                                {{ $subsidiary->name }} ({{ $subsidiary->ledger_code }})
                                                                            </option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control payment_by" name="line_items[{{ $loop->index }}][payment_by_id]" required>
                                                                <option value="">-- Choose Payment By --</option>
                                                                @foreach($groups as $group)
                                                                    <optgroup label="{{ $group->name }} ({{ $group->code }})">
                                                                        @foreach($group->subsidiaryLedgers as $subsidiary)
                                                                            <option value="{{ $subsidiary->id }}" 
                                                                                {{ $detail->cr_sub_ledger == $subsidiary->id ? 'selected' : '' }}
                                                                                data-group="{{ $group->name }}">
                                                                                {{ $subsidiary->name }} ({{ $subsidiary->ledger_code }})
                                                                            </option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control amount" name="line_items[{{ $loop->index }}][amount]" 
                                                                   value="{{ $detail->amount }}" step="0.01" required>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm removeLineItem">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Payment Voucher
                                </button>
                                <a href="{{ route('payment-voucher.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
</style>
@endsection

@section('footer_js')
    <script src="{{ url('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ url('assets') }}/plugins/select2/select2.min.js"></script>
<script>
    $(document).ready(function() {
    // Initialize Select2 for visible fields only
    $('.select2').select2({
        placeholder: 'Select an option',
        allowClear: true,
        width: '100%'
    });
});

let lineItemCounter = {{ $paymentVoucher->accTransactionDetails->count() }};
let lineItems = [];

// Initialize existing line items
@if($paymentVoucher->accTransactionDetails->count() > 0)
    @foreach($paymentVoucher->accTransactionDetails as $detail)
        lineItems.push({
            generalLedger: {{ $detail->dr_sub_ledger }},
            paymentBy: {{ $detail->cr_sub_ledger }},
            paidAmount: {{ $detail->amount }},
            generalLedgerText: '{{ $detail->dr_sub_ledger }}',
            paymentByText: '{{ $detail->cr_sub_ledger }}'
        });
    @endforeach
@endif

function addLineItem() {
    const generalLedger = $('#general_ledger').val();
    const paymentBy = $('#payment_by').val();
    const paidAmount = $('#paid_amount').val();

    if (!generalLedger || !paymentBy || !paidAmount) {
        alert('Please fill all fields');
        return;
    }

    if (parseFloat(paidAmount) <= 0) {
        alert('Amount must be greater than 0');
        return;
    }

    const generalLedgerText = $('#general_ledger option:selected').text();
    const paymentByText = $('#payment_by option:selected').text();

    const lineItem = {
        generalLedger: generalLedger,
        paymentBy: paymentBy,
        paidAmount: paidAmount,
        generalLedgerText: generalLedgerText,
        paymentByText: paymentByText
    };

    lineItems.push(lineItem);
    refreshLineItemsTable();
    updateTotalAmount();
    clearForm();
}

function refreshLineItemsTable() {
    const tbody = $('#lineItemsBody');
    tbody.empty();

    lineItems.forEach((item, index) => {
        const row = `
            <tr>
                <td>
                    <select class="form-control select2 @error('group_id') is-invalid @enderror general_ledger" name="line_items[${index}][general_ledger_id]" required>
                        <option value="">-- Choose General Ledger --</option>
                        @foreach($groups as $group)
                            <optgroup label="{{ $group->name }} ({{ $group->code }})">
                                @foreach($group->subsidiaryLedgers as $subsidiary)
                                    <option value="{{ $subsidiary->id }}" ${item.generalLedger == {{ $subsidiary->id }} ? 'selected' : ''} data-group="{{ $group->name }}">
                                        {{ $subsidiary->name }} ({{ $subsidiary->ledger_code }})
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-control select2 @error('payment_by') is-invalid @enderror payment_by" name="line_items[${index}][payment_by_id]" required>
                        <option value="">-- Choose Payment By --</option>
                        @foreach($groups as $group)
                            <optgroup label="{{ $group->name }} ({{ $group->code }})">
                                @foreach($group->subsidiaryLedgers as $subsidiary)
                                    <option value="{{ $subsidiary->id }}" ${item.paymentBy == {{ $subsidiary->id }} ? 'selected' : ''} data-group="{{ $group->name }}">
                                        {{ $subsidiary->name }} ({{ $subsidiary->ledger_code }})
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control amount" name="line_items[${index}][amount]" value="${item.paidAmount}" step="0.01" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm removeLineItem">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        tbody.append(row);
    });

    // Regular dropdowns - no Select2 needed
}

function removeLineItem(index) {
    lineItems.splice(index, 1);
    refreshLineItemsTable();
    updateTotalAmount();
}

function updateTotalAmount() {
    let total = 0;
    lineItems.forEach(item => {
        total += parseFloat(item.paidAmount);
    });
    $('#total_amount').val(total.toFixed(2));
}

function clearForm() {
    $('#general_ledger').val('').trigger('change');
    $('#payment_by').val('').trigger('change');
    $('#paid_amount').val('');
}

$(document).ready(function() {
    console.log('Document ready, regular dropdowns initialized');
    
    // Load existing line items on page load
    refreshLineItemsTable();
    updateTotalAmount();
    
    // Bind click event for add button
    $('#addLineItem').click(function(e){
        e.preventDefault();
        addLineItem(); 
    });

    // Bind click event for remove buttons
    $(document).on('click', '.removeLineItem', function(){
        const index = $(this).closest('tr').index();
        removeLineItem(index);
    });

    // Form submission handler
    $('#paymentVoucherForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate line items
        if(lineItems.length === 0) {
            alert('Please add at least one payment entry');
            return;
        }

        // Clear any existing hidden inputs
        $('input[name^="line_items"]').remove();

        // Create hidden inputs for line items
        lineItems.forEach((item, index) => {
            $(this).append(`<input type="hidden" name="line_items[${index}][general_ledger_id]" value="${item.generalLedger}">`);
            $(this).append(`<input type="hidden" name="line_items[${index}][payment_by_id]" value="${item.paymentBy}">`);
            $(this).append(`<input type="hidden" name="line_items[${index}][amount]" value="${item.paidAmount}">`);
        });
        
        console.log('Form submitting with line items:', lineItems);
        
        // Submit the form
        this.submit();
    });
});
</script>
@endsection
