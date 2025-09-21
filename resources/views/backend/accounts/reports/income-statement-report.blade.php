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
        .income-statement-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .income-statement-table th,
        .income-statement-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .income-statement-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        .section-heading {
            font-weight: bold;
            text-decoration: underline;
            background-color: #f0f0f0;
        }
        .sub-heading {
            font-weight: bold;
            padding-left: 20px;
        }
        .total-row {
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 2px solid #000;
        }
        .amount-input {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: right;
            width: 100%;
            background-color: #f9f9f9;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #6c757d;
            padding: 20px;
        }
        .date-header {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .parent-header {
            background-color: #dee2e6;
            font-weight: bold;
        }
        .parent-header {
            background-color: #dee2e6;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Report Header -->
    <div class="report-header">
        <h3 style="color: #e1e4e9;">Income Statement Report</h3>
        <p>Account Transaction Report for Income Statement</p>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title"><i class="fas fa-filter"></i> Filter Report</h5>
        </div>
        <div class="card-body">
            <form id="filterForm">
                <div class="row">
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="comparison_date">Comparison Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" id="comparison_date" name="comparison_date">
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
            <h4>Income Statement</h4>
            <p id="reportDateDisplay">For the period ended <span id="reportDate"></span></p>
        </div>

        <!-- Income Statement Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="income-statement-table" id="incomeStatementTable">
                        <thead>
                            <tr>
                                <th class="text-left">Particulars</th>
                                <th class="text-center parent-header" colspan="2">FY 2025-26</th>
                                <th class="text-center parent-header">FY 2024-25</th>
                            </tr>
                            <tr>
                                <th class="text-left"></th>
                                <th class="text-center date-header">11/09/2025-26/09/2025</th>
                                <th class="text-center date-header">Upto 10/09/2025</th>
                                <th class="text-center date-header">For the Period</th>
                            </tr>
                        </thead>
                        <tbody id="incomeStatementBody">
                            <!-- Data will be loaded here -->
                        </tbody>
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

$(document).ready(function() {
    // Set default dates
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    
    $('#to_date').val(today.toISOString().split('T')[0]);
    $('#from_date').val(firstDay.toISOString().split('T')[0]);
    $('#comparison_date').val(new Date(today.getFullYear() - 1, 5, 30).toISOString().split('T')[0]); // June 30 of previous year

    // Load initial data
    loadIncomeStatementData();

    // Filter form submission
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        loadIncomeStatementData();
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

function loadIncomeStatementData() {
    $('#loadingOverlay').show();
    $('#reportContent').hide();

    const formData = {
        to_date: $('#to_date').val(),
        from_date: $('#from_date').val(),
        comparison_date: $('#comparison_date').val()
    };

    console.log('Loading income statement data with:', formData);

    $.ajax({
        url: '{{ route("reports.income-statement-report-data") }}',
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Income statement data response:', response);
            $('#loadingOverlay').hide();
            
            if (response.success) {
                reportData = response.data;
                $('#excelBtn, #printBtn').prop('disabled', false);
                displayIncomeStatement(response.data);
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading income statement data:', error);
            $('#loadingOverlay').hide();
            alert('Error loading data: ' + error);
        }
    });
}

function displayIncomeStatement(data) {
    console.log('Displaying income statement with data:', data);

    // Update report date
    const reportDate = $('#to_date').val();
    const formattedDate = new Date(reportDate).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
    $('#reportDate').text(formattedDate);

    // Clear existing table data
    $('#incomeStatementBody').empty();

    if (!data || !data.revenue) {
        $('#incomeStatementBody').html(`
            <tr>
                <td colspan="4" class="no-data">No data available</td>
            </tr>
        `);
        $('#reportContent').show();
        return;
    }

    // Add REVENUE section
    $('#incomeStatementBody').append(`
        <tr class="section-heading">
            <td colspan="4">REVENUE</td>
        </tr>
    `);

    // Operating Revenue
    if (data.revenue.operating_revenue && data.revenue.operating_revenue.length > 0) {
        $('#incomeStatementBody').append(`
            <tr class="sub-heading">
                <td colspan="4">Operating Revenue:</td>
            </tr>
        `);
        
        data.revenue.operating_revenue.forEach(revenue => {
            $('#incomeStatementBody').append(`
                <tr>
                    <td>${revenue.name} [${revenue.code}]</td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(revenue.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(revenue.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(revenue.balance)}" readonly>
                    </td>
                </tr>
            `);
        });
    }

    // Other Revenue
    if (data.revenue.other_revenue && data.revenue.other_revenue.length > 0) {
        $('#incomeStatementBody').append(`
            <tr class="sub-heading">
                <td colspan="4">Other Revenue:</td>
            </tr>
        `);
        
        data.revenue.other_revenue.forEach(revenue => {
            $('#incomeStatementBody').append(`
                <tr>
                    <td>${revenue.name} [${revenue.code}]</td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(revenue.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(revenue.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(revenue.balance)}" readonly>
                    </td>
                </tr>
            `);
        });
    }

    // Total Revenue
    $('#incomeStatementBody').append(`
        <tr class="total-row">
            <td><strong>Total Revenue</strong></td>
            <td class="text-right"><strong>${formatNumber(data.revenue.total_revenue || 0)}</strong></td>
            <td class="text-right"><strong>${formatNumber(data.revenue.total_revenue || 0)}</strong></td>
            <td class="text-right"><strong>${formatNumber(data.revenue.total_revenue || 0)}</strong></td>
        </tr>
    `);

    // Add EXPENSES section
    $('#incomeStatementBody').append(`
        <tr class="section-heading">
            <td colspan="4">EXPENSES</td>
        </tr>
    `);

    // Operating Expenses
    if (data.expenses.operating_expenses && data.expenses.operating_expenses.length > 0) {
        $('#incomeStatementBody').append(`
            <tr class="sub-heading">
                <td colspan="4">Operating Expenses:</td>
            </tr>
        `);
        
        data.expenses.operating_expenses.forEach(expense => {
            $('#incomeStatementBody').append(`
                <tr>
                    <td>${expense.name} [${expense.code}]</td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(expense.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(expense.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(expense.balance)}" readonly>
                    </td>
                </tr>
            `);
        });
    }

    // Administrative Expenses
    if (data.expenses.administrative_expenses && data.expenses.administrative_expenses.length > 0) {
        $('#incomeStatementBody').append(`
            <tr class="sub-heading">
                <td colspan="4">Administrative Expenses:</td>
            </tr>
        `);
        
        data.expenses.administrative_expenses.forEach(expense => {
            $('#incomeStatementBody').append(`
                <tr>
                    <td>${expense.name} [${expense.code}]</td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(expense.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(expense.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(expense.balance)}" readonly>
                    </td>
                </tr>
            `);
        });
    }

    // Other Expenses
    if (data.expenses.other_expenses && data.expenses.other_expenses.length > 0) {
        $('#incomeStatementBody').append(`
            <tr class="sub-heading">
                <td colspan="4">Other Expenses:</td>
            </tr>
        `);
        
        data.expenses.other_expenses.forEach(expense => {
            $('#incomeStatementBody').append(`
                <tr>
                    <td>${expense.name} [${expense.code}]</td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(expense.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(expense.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(expense.balance)}" readonly>
                    </td>
                </tr>
            `);
        });
    }

    // Total Expenses
    $('#incomeStatementBody').append(`
        <tr class="total-row">
            <td><strong>Total Expenses</strong></td>
            <td class="text-right"><strong>${formatNumber(data.expenses.total_expenses || 0)}</strong></td>
            <td class="text-right"><strong>${formatNumber(data.expenses.total_expenses || 0)}</strong></td>
            <td class="text-right"><strong>${formatNumber(data.expenses.total_expenses || 0)}</strong></td>
        </tr>
    `);

    // Net Income
    $('#incomeStatementBody').append(`
        <tr class="total-row">
            <td><strong>Net Income</strong></td>
            <td class="text-right"><strong>${formatNumber(data.net_income || 0)}</strong></td>
            <td class="text-right"><strong>${formatNumber(data.net_income || 0)}</strong></td>
            <td class="text-right"><strong>${formatNumber(data.net_income || 0)}</strong></td>
        </tr>
    `);

    $('#reportContent').show();
}

function formatNumber(num) {
    return parseFloat(num || 0).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function exportToExcel() {
    if (!reportData || !reportData.revenue) {
        alert('No data to export');
        return;
    }

    const wb = XLSX.utils.book_new();
    const wsData = [
        ['Particulars', '11/09/2025-26/09/2025', 'Upto 10/09/2025', 'For the Period']
    ];

    // Add REVENUE section
    wsData.push(['REVENUE', '', '', '']);
    
    // Operating Revenue
    if (reportData.revenue.operating_revenue && reportData.revenue.operating_revenue.length > 0) {
        wsData.push(['Operating Revenue:', '', '', '']);
        reportData.revenue.operating_revenue.forEach(revenue => {
            wsData.push([`${revenue.name} [${revenue.code}]`, formatNumber(revenue.balance), formatNumber(revenue.balance), formatNumber(revenue.balance)]);
        });
    }
    
    // Other Revenue
    if (reportData.revenue.other_revenue && reportData.revenue.other_revenue.length > 0) {
        wsData.push(['Other Revenue:', '', '', '']);
        reportData.revenue.other_revenue.forEach(revenue => {
            wsData.push([`${revenue.name} [${revenue.code}]`, formatNumber(revenue.balance), formatNumber(revenue.balance), formatNumber(revenue.balance)]);
        });
    }
    
    wsData.push(['Total Revenue', formatNumber(reportData.revenue.total_revenue || 0), formatNumber(reportData.revenue.total_revenue || 0), formatNumber(reportData.revenue.total_revenue || 0)]);

    // Add EXPENSES section
    wsData.push(['EXPENSES', '', '', '']);
    
    // Operating Expenses
    if (reportData.expenses.operating_expenses && reportData.expenses.operating_expenses.length > 0) {
        wsData.push(['Operating Expenses:', '', '', '']);
        reportData.expenses.operating_expenses.forEach(expense => {
            wsData.push([`${expense.name} [${expense.code}]`, formatNumber(expense.balance), formatNumber(expense.balance), formatNumber(expense.balance)]);
        });
    }
    
    // Administrative Expenses
    if (reportData.expenses.administrative_expenses && reportData.expenses.administrative_expenses.length > 0) {
        wsData.push(['Administrative Expenses:', '', '', '']);
        reportData.expenses.administrative_expenses.forEach(expense => {
            wsData.push([`${expense.name} [${expense.code}]`, formatNumber(expense.balance), formatNumber(expense.balance), formatNumber(expense.balance)]);
        });
    }
    
    // Other Expenses
    if (reportData.expenses.other_expenses && reportData.expenses.other_expenses.length > 0) {
        wsData.push(['Other Expenses:', '', '', '']);
        reportData.expenses.other_expenses.forEach(expense => {
            wsData.push([`${expense.name} [${expense.code}]`, formatNumber(expense.balance), formatNumber(expense.balance), formatNumber(expense.balance)]);
        });
    }
    
    wsData.push(['Total Expenses', formatNumber(reportData.expenses.total_expenses || 0), formatNumber(reportData.expenses.total_expenses || 0), formatNumber(reportData.expenses.total_expenses || 0)]);
    wsData.push(['Net Income', formatNumber(reportData.net_income || 0), formatNumber(reportData.net_income || 0), formatNumber(reportData.net_income || 0)]);

    const ws = XLSX.utils.aoa_to_sheet(wsData);
    XLSX.utils.book_append_sheet(wb, ws, 'Income Statement');
    XLSX.writeFile(wb, 'income_statement_report.xlsx');
}



</script>
@endsection
