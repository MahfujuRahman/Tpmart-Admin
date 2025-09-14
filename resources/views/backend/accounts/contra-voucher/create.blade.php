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
    Contra Voucher Entry
@endsection

@section('page_heading')
    Contra Voucher Entry
@endsection

@section('content')
     
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Contra Voucher Entry</h4>
                </div>
                <div class="card-body">
                    <form id="contraVoucherForm" method="POST" action="{{ route('contra-voucher.store') }}">
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
                                    <label for="trans_date">Transfer Date *</label>
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

                        <!-- Add New Transfer Entry Section -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5>Add New Transfer Entry</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="from_ledger">From Ledger *</label>
                                    <select class="form-control select2 @error('group_id') is-invalid @enderror"  id="from_ledger" name="from_ledger">
                                        <option value="">-- Choose From Ledger --</option>
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
                                    <label for="to_ledger">To Ledger *</label>
                                    <select class="form-control select2 @error('group_id') is-invalid @enderror"  id="to_ledger" name="to_ledger">
                                        <option value="">-- Choose To Ledger --</option>
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
                                    <label for="transfer_amount">Transfer Amount *</label>
                                    <input type="number" class="form-control" id="transfer_amount" name="transfer_amount" step="0.01" placeholder="e.g. 50000" >
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

                        <!-- Transfer Entries Table -->
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Transfer Entries</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="lineItemsTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>From Ledger</th>
                                                <th>To Ledger</th>
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
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Contra Voucher
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contra Voucher Preview</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Preview content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" id="printFromPreview">
                    <i class="fas fa-print"></i> Print
                </button>
                <button type="button" class="btn btn-success" id="saveFromPreview">Save Voucher</button>
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
        });

        let lineItemCounter = 0;
    let lineItems = [];

    // Add Line Item function
    function addLineItem() {
        console.log('Add line item function called');
            
            const fromLedger = $('#from_ledger').val();
            const toLedger = $('#to_ledger').val();
        const transferAmount = parseFloat($('#transfer_amount').val());

        console.log('Form values:', { fromLedger, toLedger, transferAmount });

        // Validation
        if(!fromLedger) { 
            alert('Please select From Ledger'); 
            $('#from_ledger').select2('open');
            return; 
        }
        if(!toLedger) { 
            alert('Please select To Ledger'); 
            $('#to_ledger').select2('open');
                return;
            }
        if(!transferAmount || transferAmount <= 0) { 
            alert('Please enter a valid Transfer Amount'); 
            $('#transfer_amount').focus();
                return;
            }

        const fromLedgerText = $('#from_ledger option:selected').text();
        const toLedgerText = $('#to_ledger option:selected').text();

            lineItemCounter++;
        const item = {
                id: lineItemCounter,
            fromLedger,
            fromLedgerText,
            toLedger,
            toLedgerText,
            transferAmount
        };

        lineItems.push(item);
        console.log('Line item added:', item);
        console.log('Total line items:', lineItems.length);
        
        refreshLineItemsTable();
            updateTotalAmount();
            clearForm();
        
        console.log('Add line item completed successfully');
    }

    // Refresh table
    function refreshLineItemsTable() {
            const tbody = $('#lineItemsBody');
            tbody.empty();

        if(lineItems.length === 0){
                tbody.append('<tr id="emptyRow"><td colspan="4" class="text-center text-muted">Nothing here</td></tr>');
                return;
            }

            lineItems.forEach((item, index) => {
            tbody.append(`
                <tr id="row_${item.id}">
                    <td>${item.fromLedgerText}</td>
                    <td>${item.toLedgerText}</td>
                    <td>${item.transferAmount.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeLineItem(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
            });
        }

        // Remove line item
    function removeLineItem(id){
        if(confirm('Are you sure you want to remove this item?')) {
            lineItems = lineItems.filter(item => item.id !== id);
            refreshLineItemsTable();
            updateTotalAmount();
        }
    }

        // Update total amount
    function updateTotalAmount(){
        let total = lineItems.reduce((sum, item) => sum + item.transferAmount, 0);
            $('#total_amount').val(total.toFixed(2));
        }

        // Clear form
    function clearForm(){
        $('#from_ledger').val('').trigger('change');
        $('#to_ledger').val('').trigger('change');
        $('#transfer_amount').val('');
        }

        // Preview functionality
    function showPreview() {
        if(lineItems.length === 0) {
            alert('Please add at least one transfer entry');
                return;
            }

        let previewHtml = '<div class="preview-voucher" style="font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto;">';
        previewHtml += '<div style="text-align: center; margin-bottom: 30px;">';
        previewHtml += '<h2 style="margin: 0; color: #333;">CONTRA VOUCHER</h2>';
        previewHtml += '</div>';
        
        previewHtml += '<div style="display: flex; justify-content: space-between; margin-bottom: 30px;">';
        previewHtml += '<div><strong>Voucher No:</strong> ' + $('#voucher_no').val() + '</div>';
        previewHtml += '<div><strong>Date:</strong> ' + $('#trans_date').val() + '</div>';
        previewHtml += '</div>';
        
        previewHtml += '<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">';
        previewHtml += '<thead><tr style="background-color: #f5f5f5;">';
        previewHtml += '<th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Code</th>';
        previewHtml += '<th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Particulars</th>';
        previewHtml += '<th style="border: 1px solid #ddd; padding: 10px; text-align: right;">Debit</th>';
        previewHtml += '<th style="border: 1px solid #ddd; padding: 10px; text-align: right;">Credit</th>';
        previewHtml += '</tr></thead><tbody>';

        // Add debit entries (From Ledger)
            lineItems.forEach((item, index) => {
            const fromLedgerCode = item.fromLedgerText.split(' - ')[1] || 'N/A';
            const fromLedgerName = item.fromLedgerText.split(' - ')[0] || item.fromLedgerText;
            
            previewHtml += '<tr>';
            previewHtml += '<td style="border: 1px solid #ddd; padding: 8px;">' + fromLedgerCode + '</td>';
            previewHtml += '<td style="border: 1px solid #ddd; padding: 8px;">' + fromLedgerName + '</td>';
            previewHtml += '<td style="border: 1px solid #ddd; padding: 8px; text-align: right;">' + item.transferAmount.toFixed(2) + '</td>';
            previewHtml += '<td style="border: 1px solid #ddd; padding: 8px; text-align: right;">-</td>';
            previewHtml += '</tr>';
        });

        // Add credit entry (To Ledger)
        const totalAmount = lineItems.reduce((sum, item) => sum + item.transferAmount, 0);
        const toLedgerItem = lineItems[0]; // Use first item's to ledger
        const toLedgerCode = toLedgerItem.toLedgerText.split(' - ')[1] || 'N/A';
        const toLedgerName = toLedgerItem.toLedgerText.split(' - ')[0] || toLedgerItem.toLedgerText;
        
        previewHtml += '<tr>';
        previewHtml += '<td style="border: 1px solid #ddd; padding: 8px;">' + toLedgerCode + '</td>';
        previewHtml += '<td style="border: 1px solid #ddd; padding: 8px;">' + toLedgerName + '</td>';
        previewHtml += '<td style="border: 1px solid #ddd; padding: 8px; text-align: right;">-</td>';
        previewHtml += '<td style="border: 1px solid #ddd; padding: 8px; text-align: right;">' + totalAmount.toFixed(2) + '</td>';
        previewHtml += '</tr>';

        // Total row
        previewHtml += '</tbody><tfoot>';
        previewHtml += '<tr style="background-color: #f5f5f5; font-weight: bold;">';
        previewHtml += '<td style="border: 1px solid #ddd; padding: 10px;" colspan="2">Total:</td>';
        previewHtml += '<td style="border: 1px solid #ddd; padding: 10px; text-align: right;">' + totalAmount.toFixed(2) + '</td>';
        previewHtml += '<td style="border: 1px solid #ddd; padding: 10px; text-align: right;">' + totalAmount.toFixed(2) + '</td>';
        previewHtml += '</tr></tfoot></table>';
        
        previewHtml += '<div style="margin-top: 20px;">';
        previewHtml += '<strong>Remarks:</strong> ' + ($('#remarks').val() || 'N/A');
        previewHtml += '</div></div>';

        // Show preview in modal
        $('#previewContent').html(previewHtml);
        $('#previewModal').modal('show');
    }

    $(document).ready(function(){
    console.log('Document ready, regular dropdowns initialized');
    
    // Bind click event for add button
    $('#addLineItem').click(function(e){
        e.preventDefault();
        addLineItem(); 
    });
    
    // Preview button
    $('#previewBtn').click(function(e){
        e.preventDefault();
        showPreview();
    });
    
    // Print button
    $('#printBtn').click(function(e){
        e.preventDefault();
        if(lineItems.length === 0) {
            alert('Please add at least one transfer entry');
            return;
        }
        printVoucher();
    });

    // Form submission handler
    $('#contraVoucherForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate line items
        if(lineItems.length === 0) {
            alert('Please add at least one transfer entry');
            return;
        }

        // Clear any existing hidden inputs
        $('input[name^="line_items"]').remove();

        // Create hidden inputs for line items
        lineItems.forEach((item, index) => {
            $(this).append(`<input type="hidden" name="line_items[${index}][from_ledger_id]" value="${item.fromLedger}">`);
            $(this).append(`<input type="hidden" name="line_items[${index}][to_ledger_id]" value="${item.toLedger}">`);
            $(this).append(`<input type="hidden" name="line_items[${index}][amount]" value="${item.transferAmount}">`);
        });
        
        console.log('Form submitting with line items:', lineItems);
        console.log('Form data:', $(this).serialize());
        
        // Submit the form
        this.submit();
    });

    // Save from preview
    $('#saveFromPreview').click(function(){
        $('#previewModal').modal('hide');
        $('#contraVoucherForm').submit();
    });

    // Print from preview
    $('#printFromPreview').click(function(){
        window.print();
    });
});

       
    </script>
@endsection
