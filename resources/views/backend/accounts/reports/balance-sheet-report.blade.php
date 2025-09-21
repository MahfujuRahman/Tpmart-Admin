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
        .balance-sheet-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .balance-sheet-table th,
        .balance-sheet-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .balance-sheet-table th {
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
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Report Header -->
    <div class="report-header">
        <h3 style="color: #e1e4e9;">Balance Sheet Report</h3>
        <p>Account Transaction Report for Balance Sheet</p>
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
                            <label for="report_date">Report Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" id="report_date" name="report_date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fy_start">FY Start Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" id="fy_start" name="fy_start">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fy_end">FY End Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" id="fy_end" name="fy_end">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
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
            <!-- <h3>Rural and Urban Poor's Partner for Social Advancement</h3>
            <p>52, Solayman Nagor Basupara Khulna</p> -->
            <h4>Statement of Financial Position</h4>
            <p id="reportDateDisplay">As at <span id="reportDate"></span></p>
        </div>

        <!-- Balance Sheet Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="balance-sheet-table" id="balanceSheetTable">
                         <thead>
                             <tr>
                                 <th class="text-left">Particulars</th>
                                 <th class="text-center parent-header" colspan="2">FY 2025-26</th>
                                 <th class="text-center parent-header">FY 2024-25</th>
                             </tr>
                             <tr>
                                 <th class="text-left"></th>
                                 <th class="text-center date-header">01 September'2025</th>
                                 <th class="text-center date-header">24 September'2025</th>
                                 <th class="text-center date-header">30 June'2025</th>
                             </tr>
                         </thead>
                        <tbody id="balanceSheetBody">
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
    
    $('#report_date').val(today.toISOString().split('T')[0]);
    $('#fy_start').val(firstDay.toISOString().split('T')[0]);
    $('#fy_end').val(lastDay.toISOString().split('T')[0]);
    $('#comparison_date').val(new Date(today.getFullYear() - 1, 5, 30).toISOString().split('T')[0]); // June 30 of previous year

    // Load initial data
    loadBalanceSheetData();

    // Filter form submission
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        loadBalanceSheetData();
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

function loadBalanceSheetData() {
    $('#loadingOverlay').show();
    $('#reportContent').hide();

    const formData = {
        report_date: $('#report_date').val(),
        fy_start: $('#fy_start').val(),
        fy_end: $('#fy_end').val(),
        comparison_date: $('#comparison_date').val()
    };

    console.log('Loading balance sheet data with:', formData);

    $.ajax({
        url: '{{ route("reports.balance-sheet-report-data") }}',
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Balance sheet data response:', response);
            $('#loadingOverlay').hide();
            
            if (response.success) {
                reportData = response.data;
                $('#excelBtn, #printBtn').prop('disabled', false);
                displayBalanceSheet(response.data);
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading balance sheet data:', error);
            $('#loadingOverlay').hide();
            alert('Error loading data: ' + error);
        }
    });
}

function displayBalanceSheet(data) {
    console.log('Displaying balance sheet with data:', data);

    // Update report date
    const reportDate = $('#report_date').val();
    const formattedDate = new Date(reportDate).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
    $('#reportDate').text(formattedDate);

    // Clear existing table data
    $('#balanceSheetBody').empty();

    if (!data || !data.assets) {
        $('#balanceSheetBody').html(`
            <tr>
                <td colspan="4" class="no-data">No data available</td>
            </tr>
        `);
        $('#reportContent').show();
        return;
    }

    // Add PROPERTY AND ASSETS section
    $('#balanceSheetBody').append(`
        <tr class="section-heading">
            <td colspan="4">PROPERTY AND ASSETS</td>
        </tr>
    `);

    // Current Assets
    if (data.assets.current_assets && data.assets.current_assets.length > 0) {
        $('#balanceSheetBody').append(`
            <tr class="sub-heading">
                <td colspan="4">Current Assets:</td>
            </tr>
        `);
        
        data.assets.current_assets.forEach(asset => {
            $('#balanceSheetBody').append(`
                <tr>
                    <td>${asset.name} [${asset.code}]</td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(asset.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(asset.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(asset.balance)}" readonly>
                    </td>
                </tr>
            `);
        });
    }

    // Fixed Assets
    if (data.assets.fixed_assets && data.assets.fixed_assets.length > 0) {
        $('#balanceSheetBody').append(`
            <tr class="sub-heading">
                <td colspan="4">Fixed Assets:</td>
            </tr>
        `);
        
        data.assets.fixed_assets.forEach(asset => {
            $('#balanceSheetBody').append(`
                <tr>
                    <td>${asset.name} [${asset.code}]</td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(asset.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(asset.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(asset.balance)}" readonly>
                    </td>
                </tr>
            `);
        });
    }

    // Total Assets
    $('#balanceSheetBody').append(`
        <tr class="total-row">
            <td><strong>Total Assets</strong></td>
            <td class="text-right"><strong>${formatNumber(data.assets.total_assets || 0)}</strong></td>
            <td class="text-right"><strong>${formatNumber(data.assets.total_assets || 0)}</strong></td>
            <td class="text-right"><strong>${formatNumber(data.assets.total_assets || 0)}</strong></td>
        </tr>
    `);

    // Add LIABILITY AND CAPITAL section
    $('#balanceSheetBody').append(`
        <tr class="section-heading">
            <td colspan="4">LIABILITY AND CAPITAL</td>
        </tr>
    `);

    // Current Liabilities
    if (data.liabilities.current_liabilities && data.liabilities.current_liabilities.length > 0) {
        $('#balanceSheetBody').append(`
            <tr class="sub-heading">
                <td colspan="4">Current Liabilities:</td>
            </tr>
        `);
        
        data.liabilities.current_liabilities.forEach(liability => {
            $('#balanceSheetBody').append(`
                <tr>
                    <td>${liability.name} [${liability.code}]</td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(liability.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(liability.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(liability.balance)}" readonly>
                    </td>
                </tr>
            `);
        });
    }

    // Long Term Liabilities
    if (data.liabilities.long_term_liabilities && data.liabilities.long_term_liabilities.length > 0) {
        $('#balanceSheetBody').append(`
            <tr class="sub-heading">
                <td colspan="4">Long Term Liabilities:</td>
            </tr>
        `);
        
        data.liabilities.long_term_liabilities.forEach(liability => {
            $('#balanceSheetBody').append(`
                <tr>
                    <td>${liability.name} [${liability.code}]</td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(liability.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(liability.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(liability.balance)}" readonly>
                    </td>
                </tr>
            `);
        });
    }

    // Owner Equity
    if (data.equity.owner_equity && data.equity.owner_equity.length > 0) {
        $('#balanceSheetBody').append(`
            <tr class="sub-heading">
                <td colspan="4">Owner Equity:</td>
            </tr>
        `);
        
        data.equity.owner_equity.forEach(equity => {
            $('#balanceSheetBody').append(`
                <tr>
                    <td>${equity.name} [${equity.code}]</td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(equity.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(equity.balance)}" readonly>
                    </td>
                    <td class="text-right">
                        <input type="text" class="amount-input" value="${formatNumber(equity.balance)}" readonly>
                    </td>
                </tr>
            `);
        });
    }

    // Total Liabilities and Equity
    const totalLiabilities = (data.liabilities.total_liabilities || 0) + (data.equity.total_equity || 0);
    $('#balanceSheetBody').append(`
        <tr class="total-row">
            <td><strong>Total Liabilities & Equity</strong></td>
            <td class="text-right"><strong>${formatNumber(totalLiabilities)}</strong></td>
            <td class="text-right"><strong>${formatNumber(totalLiabilities)}</strong></td>
            <td class="text-right"><strong>${formatNumber(totalLiabilities)}</strong></td>
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
    if (!reportData || !reportData.assets) {
        alert('No data to export');
        return;
    }

    const wb = XLSX.utils.book_new();
    const wsData = [
        ['Particulars', '01 September\'2025', '24 September\'2025', '30 June\'2025']
    ];

    // Add PROPERTY AND ASSETS section
    wsData.push(['PROPERTY AND ASSETS', '', '', '']);
    
    // Current Assets
    if (reportData.assets.current_assets && reportData.assets.current_assets.length > 0) {
        wsData.push(['Current Assets:', '', '', '']);
        reportData.assets.current_assets.forEach(asset => {
            wsData.push([`${asset.name} [${asset.code}]`, formatNumber(asset.balance), formatNumber(asset.balance), formatNumber(asset.balance)]);
        });
    }
    
    // Fixed Assets
    if (reportData.assets.fixed_assets && reportData.assets.fixed_assets.length > 0) {
        wsData.push(['Fixed Assets:', '', '', '']);
        reportData.assets.fixed_assets.forEach(asset => {
            wsData.push([`${asset.name} [${asset.code}]`, formatNumber(asset.balance), formatNumber(asset.balance), formatNumber(asset.balance)]);
        });
    }
    
    wsData.push(['Total Assets', formatNumber(reportData.assets.total_assets || 0), formatNumber(reportData.assets.total_assets || 0), formatNumber(reportData.assets.total_assets || 0)]);

    // Add LIABILITY AND CAPITAL section
    wsData.push(['LIABILITY AND CAPITAL', '', '', '']);
    
    // Current Liabilities
    if (reportData.liabilities.current_liabilities && reportData.liabilities.current_liabilities.length > 0) {
        wsData.push(['Current Liabilities:', '', '', '']);
        reportData.liabilities.current_liabilities.forEach(liability => {
            wsData.push([`${liability.name} [${liability.code}]`, formatNumber(liability.balance), formatNumber(liability.balance), formatNumber(liability.balance)]);
        });
    }
    
    // Long Term Liabilities
    if (reportData.liabilities.long_term_liabilities && reportData.liabilities.long_term_liabilities.length > 0) {
        wsData.push(['Long Term Liabilities:', '', '', '']);
        reportData.liabilities.long_term_liabilities.forEach(liability => {
            wsData.push([`${liability.name} [${liability.code}]`, formatNumber(liability.balance), formatNumber(liability.balance), formatNumber(liability.balance)]);
        });
    }
    
    // Owner Equity
    if (reportData.equity.owner_equity && reportData.equity.owner_equity.length > 0) {
        wsData.push(['Owner Equity:', '', '', '']);
        reportData.equity.owner_equity.forEach(equity => {
            wsData.push([`${equity.name} [${equity.code}]`, formatNumber(equity.balance), formatNumber(equity.balance), formatNumber(equity.balance)]);
        });
    }
    
    const totalLiabilities = (reportData.liabilities.total_liabilities || 0) + (reportData.equity.total_equity || 0);
    wsData.push(['Total Liabilities & Equity', formatNumber(totalLiabilities), formatNumber(totalLiabilities), formatNumber(totalLiabilities)]);

    const ws = XLSX.utils.aoa_to_sheet(wsData);
    XLSX.utils.book_append_sheet(wb, ws, 'Balance Sheet');
    XLSX.writeFile(wb, 'balance_sheet_report.xlsx');
}


</script>
@endsection
