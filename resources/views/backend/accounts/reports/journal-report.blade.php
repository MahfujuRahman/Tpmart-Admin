@extends('backend.master')

@section('header_css')
    <link href="{{ url('assets') }}/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
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
        
        .btn-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            border-radius: 8px;
            color: white;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3, #004085);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 8px;
            color: white;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #218838, #1ea085);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #e0a800);
            border: none;
            border-radius: 8px;
            color: #212529;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg, #e0a800, #d39e00);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }
        
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            padding: 15px 12px;
            text-align: center;
        }
        
        .table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }
        
        .table tbody td.text-left {
            text-align: left;
        }
        
        .table tbody td.text-right {
            text-align: right;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .summary-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .summary-card h5 {
            color: #495057;
            margin-bottom: 15px;
            font-weight: 600;
            text-align: center;
        }
        
        .summary-card h5 i {
            margin-right: 8px;
            color: #007bff;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .summary-item:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 1.1em;
        }
        
        .summary-item span:first-child {
            color: #6c757d;
        }
        
        .summary-item span:last-child {
            color: #495057;
            font-weight: 600;
        }
        
        .filter-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .report-header {
            background-color: #17263a;
            border-top: 5px solid #0d1a2b;
            color: #e1e4e9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: left;
        }
        
        .report-header h3 {
            margin: 0;
            font-weight: 600;
            color: #e1e4e9;
        }
        
        .report-header p {
            margin: 5px 0 0 0;
            color: #e1e4e9;
            opacity: 0.9;
        }
        
        .si-number {
            font-weight: bold;
            color: #007bff;
        }
        
        .debit-amount {
            color: #dc3545;
            font-weight: bold;
        }
        
        .credit-amount {
            color: #28a745;
            font-weight: bold;
        }
        
        /* Loader Styles */
        .loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }
        
        .loader-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .no-data {
            text-align: center;
            padding: 50px;
            color: #6c757d;
        }
        
        .no-data i {
            font-size: 3rem;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('title', 'Journal Voucher Report')

@section('content')
<div class="container-fluid">
    <!-- Loader -->

    <!-- Report Header -->
    <div class="report-header">
        <h3>Journal Voucher Transaction Report</h3>
        <p>Account Transaction Report for Journal Vouchers</p>
    </div>

    <!-- Filter Section -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"><i class="fas fa-filter"></i> Filter Report</h5>
        </div>
        <div class="card-body">
            <form id="filterForm">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label for="from_date"><i class="fas fa-calendar-alt"></i> From Date</label>
                            <input type="date" class="form-control" id="from_date" name="from_date">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label for="to_date"><i class="fas fa-calendar-alt"></i> To Date</label>
                            <input type="date" class="form-control" id="to_date" name="to_date">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label for="ledger_id"><i class="fas fa-list"></i> Ledger</label>
                            <select class="form-control select2" id="ledger_id" name="ledger_id">
                                <option value="">-- All Ledgers --</option>
                                @foreach($ledgers as $ledger)
                                    <option value="{{ $ledger->id }}">
                                        {{ $ledger->name }} ({{ $ledger->ledger_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label for="voucher_no"><i class="fas fa-file-invoice"></i> Voucher No</label>
                            <input type="text" class="form-control" id="voucher_no" name="voucher_no" 
                                   placeholder="Enter voucher number">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary" id="filterBtn">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button type="button" class="btn btn-secondary" id="resetBtn">
                            <i class="fas fa-refresh"></i> Reset
                        </button>
                        <button type="button" class="btn btn-success" id="excelBtn" disabled>
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <!-- <button type="button" class="btn btn-warning" id="printBtn" disabled>
                            <i class="fas fa-print"></i> Print Report
                        </button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4" id="summaryCards" @if(isset($transactions) && count($transactions) > 0) style="display: flex;" @else style="display: none;" @endif>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="summary-card">
                <h5><i class="fas fa-file-alt"></i> Total Transactions</h5>
                <div class="summary-item">
                    <span>Count:</span>
                    <span id="totalTransactions">{{ $transactionCount ?? 0 }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="summary-card">
                <h5><i class="fas fa-arrow-up"></i> Total Debit</h5>
                <div class="summary-item">
                    <span>Amount:</span>
                    <span id="totalDebit">৳{{ number_format($totalDebit ?? 0, 2) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-12">
            <div class="summary-card">
                <h5><i class="fas fa-arrow-down"></i> Total Credit</h5>
                <div class="summary-item">
                    <span>Amount:</span>
                    <span id="totalCredit">৳{{ number_format($totalCredit ?? 0, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"><i class="fas fa-table"></i> Journal Voucher Transaction Details</h5>
            <div class="card-tools">
                <a href="{{ route('voucher.journal') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Journal Vouchers
                </a>
            </div>
        </div>
        <div class="card-body">
            <div id="reportTableContainer">
                @include('backend.accounts.reports.journal-report-table')
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_js')
    <script src="{{ url('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ url('assets') }}/plugins/select2/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        let reportData = [];
        let dataTable = null;

        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: 'Select an option',
                allowClear: true,
                width: '100%'
            });

            // Set default dates
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            $('#from_date').val(firstDay.toISOString().split('T')[0]);
            $('#to_date').val(today.toISOString().split('T')[0]);

            // Load initial data if available
            @if(isset($transactions) && count($transactions) > 0)
                reportData = @json($transactions);
                $('#excelBtn, #printBtn').prop('disabled', false);
                console.log('Initial data loaded:', reportData);
            @endif

            // Filter form submission
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                loadReportData();
            });

            // Reset button
            $('#resetBtn').on('click', function() {
                $('#filterForm')[0].reset();
                $('.select2').val('').trigger('change');
                $('#summaryCards').css('display', 'none').hide();
                $('#reportTableContainer').html(`
                    <div class="no-data">
                        <i class="fas fa-file-alt"></i>
                        <h5>No data loaded</h5>
                        <p>Please apply filters to generate the report</p>
                    </div>
                `);
                $('#excelBtn, #printBtn').prop('disabled', true);
            });

            // Excel export
            $('#excelBtn').on('click', function() {
                exportToExcel();
            });

            // Print report
            $('#printBtn').on('click', function() {
                printReport();
            });

        });

        function showLoader() {
            $('#loader').show();
        }

        function hideLoader() {
            $('#loader').hide();
        }

        function loadReportData() {
            showLoader();
            
            const formData = {
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                ledger_id: $('#ledger_id').val(),
                voucher_no: $('#voucher_no').val(),
                _token: '{{ csrf_token() }}'
            };

            // console.log('Sending AJAX request with data:', formData);

            $.ajax({
                url: '{{ route("reports.journal-report-data") }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // console.log('AJAX Response:', response);
                    hideLoader();
                    
                    if (response.success) {
                        reportData = response.data;
                        displayReportData(response.data, response.summary);
                        $('#excelBtn, #printBtn').prop('disabled', false);
                    } else {
                        alert('Error: ' + response.message);
                        $('#reportTableContainer').html(`
                            <div class="no-data">
                                <i class="fas fa-exclamation-triangle"></i>
                                <h5>Error Loading Data</h5>
                                <p>${response.message}</p>
                            </div>
                        `);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    hideLoader();
                    
                    let errorMessage = 'Error loading data. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    alert(errorMessage);
                    $('#reportTableContainer').html(`
                        <div class="no-data">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h5>Error Loading Data</h5>
                            <p>${errorMessage}</p>
                        </div>
                    `);
                }
            });
        }

        function displayReportData(data, summary) {
            console.log('Displaying report data:', data);
            console.log('Summary:', summary);
            console.log('Total Debit:', summary.totalDebit);
            console.log('Total Credit:', summary.totalCredit);
            
            // Update summary cards
            $('#totalTransactions').text(summary.transactionCount);
            $('#totalDebit').text('৳' + parseFloat(summary.totalDebit).toLocaleString('en-US', {minimumFractionDigits: 2}));
            $('#totalCredit').text('৳' + parseFloat(summary.totalCredit).toLocaleString('en-US', {minimumFractionDigits: 2}));
            $('#summaryCards').css('display', 'flex').show();

            // Build table HTML
            let tableHtml = `
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="reportTable">
                        <thead>
                            <tr>
                                <th>SI</th>
                                <th>Transaction Date</th>
                                <th>Code</th>
                                <th>Debit Account</th>
                                <th>Debit Amount</th>
                                <th>Credit Account</th>
                                <th>Credit Amount</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            let si = 1;
            // console.log('Processing transactions:', data.length);
            
            if (data.length === 0) {
                tableHtml += `
                    <tr>
                        <td colspan="8" class="text-center">
                            <div class="no-data">
                                <i class="fas fa-info-circle"></i>
                                <h5>No Data Found</h5>
                                <p>No transactions found for the selected criteria</p>
                            </div>
                        </td>
                    </tr>
                `;
            } else {
                data.forEach(function(detail) {
                    console.log('Processing detail:', detail);
                    console.log('Detail dr_sub_ledger:', detail.dr_sub_ledger);
                    console.log('Detail cr_sub_ledger:', detail.cr_sub_ledger);
                    console.log('Account Transaction:', detail.account_transaction);
                    
                    if (detail.account_transaction) {
                        const transaction = detail.account_transaction;
                        const transDate = transaction.trans_date ? new Date(transaction.trans_date).toLocaleDateString('en-GB') : 'N/A';
                        const debitAccount = detail.dr_sub_ledger ? 
                            `${detail.dr_sub_ledger.name} (${detail.dr_sub_ledger.ledger_code})` : 'N/A';
                        const creditAccount = detail.cr_sub_ledger ? 
                            `${detail.cr_sub_ledger.name} (${detail.cr_sub_ledger.ledger_code})` : 'N/A';
                        const amount = parseFloat(detail.amount).toLocaleString('en-US', {minimumFractionDigits: 2});

                        tableHtml += `
                            <tr>
                                <td class="si-number text-center">${si++}</td>
                                <td class="text-left">${transDate}</td>
                                <td class="text-left">
                                    <a href="/journal-voucher/show/${transaction.id}" class="text-primary" target="_blank">
                                        ${transaction.voucher_no}
                                    </a>
                                </td>
                                <td class="text-left">${debitAccount}</td>
                                <td class="debit-amount text-right">৳${amount}</td>
                                <td class="text-left">${creditAccount}</td>
                                <td class="credit-amount text-right">৳${amount}</td>
                                <td class="text-left">${transaction.comments || 'N/A'}</td>
                            </tr>
                        `;
                    }
                });
            }

            // Calculate totals manually
            let manualDebitTotal = 0;
            let manualCreditTotal = 0;
            
            data.forEach(function(detail) {
                if (detail.account_transaction) {
                    manualDebitTotal += parseFloat(detail.amount);
                    manualCreditTotal += parseFloat(detail.amount);
                }
            });

            tableHtml += `
                        </tbody>
                        <tfoot>
                            <tr style="background-color: #f8f9fa; font-weight: bold;">
                                <td colspan="4" class="text-right">Total:</td>
                                <td class="debit-amount text-right">৳${manualDebitTotal.toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                                <td></td>
                                <td class="credit-amount text-right">৳${manualCreditTotal.toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            `;

            $('#reportTableContainer').html(tableHtml);

            // Initialize DataTable
            if (dataTable) {
                dataTable.destroy();
            }
            
            dataTable = $('#reportTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": false,
                "searching": false,
                "info": false,
                "order": [[1, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [0, 7] }
                ]
            });
        }

        function exportToExcel() {
            if (reportData.length === 0) {
                alert('No data to export');
                return;
            }

            // Prepare data for Excel
            let excelData = [];
            let si = 1;

            reportData.forEach(function(transaction) {
                transaction.acc_transaction_details.forEach(function(detail) {
                    const transDate = transaction.trans_date ? new Date(transaction.trans_date).toLocaleDateString('en-GB') : 'N/A';
                    const debitAccount = detail.dr_sub_ledger ? 
                        `${detail.dr_sub_ledger.name} (${detail.dr_sub_ledger.ledger_code})` : 'N/A';
                    const creditAccount = detail.cr_sub_ledger ? 
                        `${detail.cr_sub_ledger.name} (${detail.cr_sub_ledger.ledger_code})` : 'N/A';
                    const amount = parseFloat(detail.amount).toFixed(2);

                    excelData.push([
                        si++,
                        transDate,
                        transaction.voucher_no,
                        debitAccount,
                        amount,
                        creditAccount,
                        amount,
                        transaction.comments || 'N/A'
                    ]);
                });
            });

            // Create workbook
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet([
                ['SI', 'Transaction Date', 'Code', 'Debit Account', 'Debit Amount', 'Credit Account', 'Credit Amount', 'Note'],
                ...excelData
            ]);

            // Set column widths
            ws['!cols'] = [
                { wch: 5 },   // SI
                { wch: 15 },  // Transaction Date
                { wch: 15 },  // Code
                { wch: 30 },  // Debit Account
                { wch: 15 },  // Debit Amount
                { wch: 30 },  // Credit Account
                { wch: 15 },  // Credit Amount
                { wch: 30 }   // Note
            ];

            XLSX.utils.book_append_sheet(wb, ws, 'Journal Report');
            XLSX.writeFile(wb, 'Journal_Report_' + new Date().toISOString().split('T')[0] + '.xlsx');
        }

      
    </script>
@endsection