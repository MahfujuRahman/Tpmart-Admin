@extends('backend.master')

@section('header_css')
    <link href="{{ url('assets') }}/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
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
        
        .btn-view {
            background-color: #17a2b8;
            color: white;
        }
        
        .btn-view:hover {
            background-color: #138496;
            border-color: #117a8b;
        }
        
        .btn-print {
            background-color: #28a745;
            color: white;
        }
        
        .btn-print:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: #333;
        }
        
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #aaa;
            border-radius: 3px;
            padding: 5px;
            margin: 0 6px;
            width: auto;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #aaa;
            border-radius: 3px;
            padding: 5px;
            margin: 0 6px;
            width: 200px;
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

@section('page_title')
    Journal Voucher Entry
@endsection

@section('page_heading')
    Journal Voucher Entry
@endsection

@section('content')
     
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Journal Voucher Entry</h4>
                </div>
                <div class="card-body">
                    <form id="journalVoucherForm" method="POST" action="{{ route('voucher.journal.store') }}">
                        @csrf
                        
                        <!-- Voucher Details Section -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="voucher_no">Voucher No *</label>
                                    <input type="text" class="form-control" id="voucher_no" name="voucher_no" value="Auto" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="trans_date">Journal Date *</label>
                                    <input type="date" class="form-control" id="trans_date" name="trans_date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="total_amount">Total Amount</label>
                                    <input type="number" class="form-control" id="total_amount" name="total_amount" step="0.01" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Add New Journal Entry Section -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5>Add New Journal Entry</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="debit_ledger">Debit Ledger *</label>
                                    <select class="form-control select2 @error('group_id') is-invalid @enderror"  id="debit_ledger" name="debit_ledger">
                                        <option value="">-- Choose Debit Ledger --</option>
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
                                    <label for="credit_ledger">Credit Ledger *</label>
                                    <select class="form-control select2 @error('group_id') is-invalid @enderror"  id="credit_ledger" name="credit_ledger">
                                        <option value="">-- Choose Credit Ledger --</option>
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
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="journal_amount">Amount *</label>
                                    <input type="number" class="form-control" id="journal_amount" name="journal_amount" step="0.01" placeholder="e.g. 50000" >
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-success btn-block" id="addLineItem">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div> 
                            </div>
                        </div>

                        <!-- Journal Entries Table -->
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Journal Entries</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="lineItemsTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Debit Ledger</th>
                                                <th>Credit Ledger</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lineItemsBody">
                                            <tr id="emptyRow">
                                                <td colspan="4" class="text-center text-muted">Nothing here</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                    <i class="fas fa-arrow-left"></i> Back
                                </button>
                                <button type="submit" class="btn btn-create">
                                    <i class="fas fa-save"></i> Create Journal Voucher
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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

            // Add line item functionality
            $('#addLineItem').on('click', function() {
                addLineItem();
            });

            // Remove line item functionality
            $(document).on('click', '.removeLineItem', function() {
                $(this).closest('tr').remove();
                updateTotalAmount();
                checkEmptyState();
            });

            // Update total amount when amount changes
            $(document).on('input', '.amount', function() {
                updateTotalAmount();
            });

            // Form submission
            $('#journalVoucherForm').on('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                }
            });

            // Calculate initial total
            updateTotalAmount();
        });

        function addLineItem() {
            const debitLedger = $('#debit_ledger').val();
            const creditLedger = $('#credit_ledger').val();
            const amount = $('#journal_amount').val();

            if (!debitLedger || !creditLedger || !amount || parseFloat(amount) <= 0) {
                alert('Please fill in all fields with valid values.');
                return;
            }

            // Check if debit and credit ledger are the same
            if (debitLedger === creditLedger) {
                alert('Debit ledger and Credit ledger cannot be the same. Please select different ledgers.');
                return;
            }

            const debitLedgerText = $('#debit_ledger option:selected').text();
            const creditLedgerText = $('#credit_ledger option:selected').text();

            const newRow = `
                <tr>
                    <td>${debitLedgerText}</td>
                    <td>${creditLedgerText}</td>
                    <td>${parseFloat(amount).toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm removeLineItem">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                    <input type="hidden" name="line_items[${$('#lineItemsBody tr').length - 1}][debit_ledger_id]" value="${debitLedger}">
                    <input type="hidden" name="line_items[${$('#lineItemsBody tr').length - 1}][credit_ledger_id]" value="${creditLedger}">
                    <input type="hidden" name="line_items[${$('#lineItemsBody tr').length - 1}][amount]" value="${amount}">
                </tr>
            `;

            if ($('#emptyRow').length) {
                $('#emptyRow').remove();
            }

            $('#lineItemsBody').append(newRow);
            
            // Clear form fields
            $('#debit_ledger').val('').trigger('change');
            $('#credit_ledger').val('').trigger('change');
            $('#journal_amount').val('');

            updateTotalAmount();
        }

        function updateTotalAmount() {
            let total = 0;
            $('input[name*="[amount]"]').each(function() {
                const amount = parseFloat($(this).val()) || 0;
                total += amount;
            });
            $('#total_amount').val(total.toFixed(2));
        }

        function checkEmptyState() {
            if ($('#lineItemsBody tr').length === 0) {
                $('#lineItemsBody').append('<tr id="emptyRow"><td colspan="4" class="text-center text-muted">Nothing here</td></tr>');
            }
        }

        function validateForm() {
            if ($('#lineItemsBody tr').length === 0 || $('#emptyRow').length > 0) {
                alert('Please add at least one journal entry.');
                return false;
            }
            return true;
        }
    </script>
@endsection
