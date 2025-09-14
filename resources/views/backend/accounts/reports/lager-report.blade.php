@extends('backend.master')

@section('header_css')
    <link href="{{ url('assets') }}/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
        .report-header {
            background-color: #17263a;
            border-top: 5px solid #0d1a2b;
            color: #e1e4e9;
            padding: 20px;
            margin-bottom: 20px;
        }
        .company-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .control-group {
            margin-bottom: 20px;
            font-weight: bold;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .opening-balance {
            font-style: italic;
            color: #6c757d;
        }
        .no-transaction {
            text-align: center;
            font-style: italic;
            color: #6c757d;
            padding: 20px;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Report Header -->
    <div class="report-header">
        <h3 style="color: #e1e4e9;">Ledger Transaction Report</h3>
        <p>Account Transaction Report for Ledger Vouchers</p>
    </div>


    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title"><i class="fas fa-filter"></i> Filter Report</h5>
        </div>
        <div class="card-body">
            <form id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="from_date">From Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" id="from_date" name="from_date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="to_date">To Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" id="to_date" name="to_date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ledger_id">Account Head</label>
                            <select class="form-control select2" id="ledger_id" name="ledger_id">
                                <option value="">All Account Heads</option>
                                @foreach($ledgers as $ledger)
                                    <option value="{{ $ledger->id }}">{{ $ledger->name }} [{{ $ledger->ledger_code }}]</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="voucher_no">Voucher No</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" id="voucher_no" name="voucher_no" placeholder="Enter voucher number">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="feather-search"></i> Generate Report
                        </button>
                        <button type="button" class="btn btn-success" id="excelBtn" disabled>
                            <i class="feather-download"></i> EXCEL
                        </button>
                        <!-- <button type="button" class="btn btn-info" id="printBtn" disabled>
                            <i class="feather-printer"></i> Print
                        </button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Content -->
    <div id="reportContent" style="display: none;">
        <!-- Company Header -->
        <div class="company-header">
            <!-- <h3>Rural and Urban Poor's Partner for Social Advancement</h3>
            <p>52, Solayman Nagor Basupara Khulna</p> -->
            <h4 id="reportTitle">Ledger Report</h4>
            <p id="reportPeriod">From <span id="fromDateDisplay"></span> to <span id="toDateDisplay"></span></p>
        </div>

        <!-- Control Group -->
        <div class="control-group">
            Control Group: <span id="controlGroup">All Account Heads</span>
        </div>

        <!-- Report Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="ledgerTable">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Account Head</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Voucher</th>
                                <th class="text-center">Opening Balance Entry</th>
                                <th class="text-center">Debit</th>
                                <th class="text-center">Credit</th>
                                <th class="text-center">Balance</th>
                            </tr>
                        </thead>
                        <tbody id="ledgerTableBody">
                            <!-- Data will be loaded here -->
                        </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <th colspan="4" class="text-right">Grand Total</th>
                                <th class="text-right" id="grandTotalDebit">0.00</th>
                                <th class="text-right" id="grandTotalCredit">0.00</th>
                                <th class="text-right" id="grandTotalBalance">0.00</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="text-center" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-2">Loading report data...</p>
    </div>
</div>
@endsection

@section('footer_js')
    <script src="{{ url('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/jszip.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/pdfmake.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/vfs_fonts.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/buttons.html5.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/buttons.print.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
let reportData = [];
let currentBalance = 0;

$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        placeholder: 'Select an option',
        allowClear: true
    });

    // Set default date range (current month)
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    
    $('#from_date').val(firstDay.toISOString().split('T')[0]);
    $('#to_date').val(lastDay.toISOString().split('T')[0]);

    // Load initial data if available
    @if(isset($transactions) && count($transactions) > 0)
        reportData = @json($transactions);
        $('#excelBtn, #printBtn').prop('disabled', false);
        console.log('Initial data loaded:', reportData);
        console.log('Transaction count:', reportData.length);
        
        // Display initial data
        displayLedgerReport(reportData, {
            totalDebit: {{ $totalDebit ?? 0 }},
            totalCredit: {{ $totalCredit ?? 0 }},
            transactionCount: {{ $transactionCount ?? 0 }}
        });
    @endif

    // Filter form submission
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        loadLedgerData();
    });

    // Excel export
    $('#excelBtn').on('click', function() {
        exportToExcel();
    });

    // Print function
    $('#printBtn').on('click', function() {
        printReport();
    });
});


function loadLedgerData() {
    $('#loadingOverlay').show();
    $('#reportContent').hide();

    const formData = {
        from_date: $('#from_date').val(),
        to_date: $('#to_date').val(),
        ledger_id: $('#ledger_id').val(),
        voucher_no: $('#voucher_no').val()
    };

    console.log('Loading ledger data with:', formData);

    $.ajax({
        url: '{{ route("reports.lager-report-data") }}',
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Ledger data response:', response);
            $('#loadingOverlay').hide();
            
            if (response.success) {
                reportData = response.data;
                $('#excelBtn, #printBtn').prop('disabled', false);
                displayLedgerReport(response.data, response.summary);
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading ledger data:', error);
            $('#loadingOverlay').hide();
            alert('Error loading data: ' + error);
        }
    });
}

function displayLedgerReport(data, summary) {
    console.log('Displaying ledger report with data:', data);
    console.log('Summary:', summary);

    // Update report header
    $('#fromDateDisplay').text($('#from_date').val() || 'N/A');
    $('#toDateDisplay').text($('#to_date').val() || 'N/A');
    
    const selectedLedger = $('#ledger_id option:selected').text();
    $('#controlGroup').text(selectedLedger || 'All Account Heads');

    // Clear existing table data
    $('#ledgerTableBody').empty();

    if (data.length === 0) {
        $('#ledgerTableBody').html(`
            <tr>
                <td colspan="7" class="no-transaction">No Transaction</td>
            </tr>
        `);
        $('#reportContent').show();
        return;
    }

    // Add opening balance row
    $('#ledgerTableBody').append(`
        <tr class="opening-balance">
            <td class="text-center">-</td>
            <td class="text-center">${$('#from_date').val() || 'N/A'}</td>
            <td class="text-center">---</td>
            <td class="text-center">---</td>
            <td class="text-center">---</td>
            <td class="text-center">---</td>
            <td class="text-right">0.00</td>
        </tr>
    `);

    // Process transactions
    let runningBalance = 0;
    let totalDebit = 0;
    let totalCredit = 0;

    data.forEach(function(detail, index) {
        if (detail.account_transaction) {
            const transaction = detail.account_transaction;
            const transDate = transaction.trans_date ? new Date(transaction.trans_date).toLocaleDateString('en-GB') : 'N/A';
            const debitAccount = detail.dr_sub_ledger ? 
                `${detail.dr_sub_ledger.name} (${detail.dr_sub_ledger.ledger_code})` : 'N/A';
            const creditAccount = detail.cr_sub_ledger ? 
                `${detail.cr_sub_ledger.name} (${detail.cr_sub_ledger.ledger_code})` : 'N/A';
            const amount = parseFloat(detail.amount);
            
            // Calculate running balance
            runningBalance += amount; // For simplicity, treating all as debit for balance calculation
            
            totalDebit += amount;
            totalCredit += amount;

            $('#ledgerTableBody').append(`
                <tr>
                    <td class="text-center">${debitAccount}</td>
                    <td class="text-center">${transDate}</td>
                    <td class="text-center">
                        <a href="{{ url('account/contra-voucher/show') }}/${transaction.id}" target="_blank">
                            ${transaction.voucher_no}
                        </a>
                    </td>
                    <td class="text-center">---</td>
                    <td class="text-right">${amount.toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                    <td class="text-right">${amount.toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                    <td class="text-right">${runningBalance.toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                </tr>
            `);
        }
    });

    // Update totals
    $('#grandTotalDebit').text(totalDebit.toLocaleString('en-US', {minimumFractionDigits: 2}));
    $('#grandTotalCredit').text(totalCredit.toLocaleString('en-US', {minimumFractionDigits: 2}));
    $('#grandTotalBalance').text(runningBalance.toLocaleString('en-US', {minimumFractionDigits: 2}));

    $('#reportContent').show();
}

function exportToExcel() {
    if (reportData.length === 0) {
        alert('No data to export');
        return;
    }

    const wb = XLSX.utils.book_new();
    const wsData = [
        ['Account Head', 'Date', 'Voucher', 'Opening Balance Entry', 'Debit', 'Credit', 'Balance']
    ];

    // Add opening balance
    wsData.push(['-', $('#from_date').val() || 'N/A', '---', '---', '---', '---', '0.00']);

    // Add transactions
    let runningBalance = 0;
    reportData.forEach(function(detail) {
        if (detail.account_transaction) {
            const transaction = detail.account_transaction;
            const transDate = transaction.trans_date ? new Date(transaction.trans_date).toLocaleDateString('en-GB') : 'N/A';
            const debitAccount = detail.dr_sub_ledger ? 
                `${detail.dr_sub_ledger.name} (${detail.dr_sub_ledger.ledger_code})` : 'N/A';
            const amount = parseFloat(detail.amount);
            
            runningBalance += amount;
            
            wsData.push([
                debitAccount,
                transDate,
                transaction.voucher_no,
                '---',
                amount.toFixed(2),
                amount.toFixed(2),
                runningBalance.toFixed(2)
            ]);
        }
    });

    const ws = XLSX.utils.aoa_to_sheet(wsData);
    XLSX.utils.book_append_sheet(wb, ws, 'Ledger Report');
    XLSX.writeFile(wb, 'ledger_report.xlsx');
}


</script>
@endsection