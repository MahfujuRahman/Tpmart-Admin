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
    Edit Receive Voucher
@endsection

@section('page_heading')
    Edit Receive Voucher
@endsection

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

    @if(isset($error))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ $error }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Receive Voucher - {{ $receiveVoucher->voucher_no }}</h4>
                </div>
                <div class="card-body">
                    <form id="receiveVoucherForm" method="POST" action="{{ route('voucher.receive.update', $receiveVoucher->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Voucher Details Section -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="voucher_no">Voucher No *</label>
                                    <input type="text" class="form-control" id="voucher_no" name="voucher_no" value="{{ $receiveVoucher->voucher_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="trans_date">Receive Date *</label>
                                    <input type="date" class="form-control" id="trans_date" name="trans_date" 
                                           value="{{ $receiveVoucher->trans_date ? $receiveVoucher->trans_date->format('Y-m-d') : date('Y-m-d') }}" required>
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
                                    <textarea class="form-control" id="remarks" name="remarks" rows="2">{{ $receiveVoucher->comments }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Add New Receive Entry Section -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5>Add New Receive Entry</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="received_from">Received From *</label>
                                    <select class="form-control select2 @error('received_from') is-invalid @enderror" id="received_from" name="received_from">
                                        <option value="">-- Choose Received From --</option>
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
                                   
                                    @error('received_from')
                                        <div class="invalid-feedback d-block">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="credit_to">Credit To *</label>
                                    <select class="form-control select2 @error('credit_to') is-invalid @enderror" id="credit_to" name="credit_to">
                                        <option value="">-- Choose Credit To --</option>
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
                                    <label for="received_amount">Received Amount *</label>
                                    <input type="number" class="form-control" id="received_amount" name="received_amount" step="0.01" placeholder="e.g. 50000">
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

                        @if($groups->count() == 0)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>No subsidiary ledgers found!</strong> Please create some subsidiary ledgers first.
                                <a href="{{ route('subsidiary-ledger.create') }}" class="btn btn-primary btn-sm ml-2">
                                    Create Subsidiary Ledger
                                </a>
                            </div>
                        @endif

                        <!-- Receive Entries Table -->
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Receive Entries</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="lineItemsTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Received From</th>
                                                <th>Credit To</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lineItemsBody">
                                            @if($receiveVoucher->accTransactionDetails->count() > 0)
                                                @foreach($receiveVoucher->accTransactionDetails as $detail)
                                                    <tr>
                                                        <td>
                                                            <select class="form-control received_from" name="line_items[{{ $loop->index }}][received_from_id]" required>
                                                                <option value="">-- Choose Received From --</option>
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
                                                            <select class="form-control credit_to" name="line_items[{{ $loop->index }}][credit_to_id]" required>
                                                                <option value="">-- Choose Credit To --</option>
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
                                                                   step="0.01" min="0.01" value="{{ $detail->amount }}" required>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm removeLineItem">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr id="emptyRow">
                                                    <td colspan="4" class="text-center text-muted">Nothing here</td>
                                                </tr>
                                            @endif
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
                                    <i class="fas fa-save"></i> Update Receive Voucher
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
                <h5 class="modal-title">Receive Voucher Preview</h5>
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
            // Initialize Select2 for all select elements
            $('.select2, .received_from, .credit_to').select2({
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
            $('#receiveVoucherForm').on('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                }
            });

            // Calculate initial total
            updateTotalAmount();
        });

        function addLineItem() {
            const receivedFrom = $('#received_from').val();
            const creditTo = $('#credit_to').val();
            const amount = $('#received_amount').val();

            if (!receivedFrom || !creditTo || !amount || parseFloat(amount) <= 0) {
                alert('Please fill in all fields with valid values.');
                return;
            }

            const receivedFromText = $('#received_from option:selected').text();
            const creditToText = $('#credit_to option:selected').text();

            const newRow = `
                <tr>
                    <td>
                        <select class="form-control received_from" name="line_items[${$('#lineItemsBody tr').length}][received_from_id]" required>
                            <option value="">-- Choose Received From --</option>
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
                    </td>
                    <td>
                        <select class="form-control credit_to" name="line_items[${$('#lineItemsBody tr').length}][credit_to_id]" required>
                            <option value="">-- Choose Credit To --</option>
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
                    </td>
                    <td>
                        <input type="number" class="form-control amount" name="line_items[${$('#lineItemsBody tr').length}][amount]" 
                               step="0.01" min="0.01" value="${amount}" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm removeLineItem">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;

            if ($('#emptyRow').length) {
                $('#emptyRow').remove();
            }

            $('#lineItemsBody').append(newRow);
            
            // Initialize Select2 for the new row
            $('#lineItemsBody tr:last .received_from, #lineItemsBody tr:last .credit_to').select2({
                placeholder: 'Select an option',
                allowClear: true,
                width: '100%'
            });
            
            // Set selected values
            $('#lineItemsBody tr:last .received_from').val(receivedFrom).trigger('change');
            $('#lineItemsBody tr:last .credit_to').val(creditTo).trigger('change');
            
            // Clear form fields
            $('#received_from').val('').trigger('change');
            $('#credit_to').val('').trigger('change');
            $('#received_amount').val('');

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
                alert('Please add at least one receive entry.');
                return false;
            }

            if (!$('#trans_date').val()) {
                alert('Please select a receive date.');
                return false;
            }

            return true;
        }
    </script>
@endsection