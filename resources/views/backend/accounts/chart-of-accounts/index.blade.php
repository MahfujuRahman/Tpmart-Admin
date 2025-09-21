@extends('backend.master')

@section('header_css')
    <!-- DataTables CSS -->
    <link href="{{ url('assets') }}/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    
    <!-- XLSX Library for Excel Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    
    <style>
        .table {
            margin-bottom: 0;
        }

        .table th {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            font-weight: 600;
            padding: 12px;
        }

        .table td {
            padding: 12px;
            vertical-align: middle;
            border: 1px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .subsidiary-item {
            padding: 8px 0;
            border-top: 1px solid #e9ecef;
        }

        .subsidiary-item:first-child {
            border-top: none;
        }

        .table-responsive {
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        .empty-state-icon {
            opacity: 0.6;
        }

        .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .card-header h4 {
            font-weight: 600;
            color: #495057;
            margin: 0;
        }

        .card-header h4 i {
            margin-right: 8px;
            color: #6c757d;
        }

        .export-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-export {
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 500;
            border: 1px solid #dee2e6;
            background: white;
            color: #495057;
            cursor: pointer;
        }

        .btn-export:hover {
            background: #f8f9fa;
        }

        .search-box {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 8px 12px;
        }

        .search-box:focus {
            border-color: #6c757d;
            outline: none;
        }

        /* Print Styles */
        @media print {
            /* Hide unnecessary elements */
            .export-buttons, .search-box, .card-header .card-tools, .card-header, .card-body > .row:first-child {
                display: none !important;
            }
            
            /* Page setup */
            body {
                margin: 0;
                padding: 20px;
                font-size: 12px;
                line-height: 1.4;
            }
            
            /* Chart of Accounts Header */
            .print-header {
                display: block !important;
                text-align: center;
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 20px;
                border-bottom: 2px solid #000;
                padding-bottom: 10px;
            }
            
            /* Table styling for print */
            .table-responsive {
                border: none !important;
                border-radius: 0 !important;
            }
            
            .table {
                width: 100% !important;
                border-collapse: collapse !important;
                margin: 0 !important;
            }
            
            .table th {
                background-color: #f8f9fa !important;
                border: 1px solid #000 !important;
                padding: 8px !important;
                font-weight: bold !important;
                text-align: left !important;
            }
            
            .table td {
                border: 1px solid #000 !important;
                padding: 8px !important;
                vertical-align: top !important;
            }
            
            .table tbody tr:hover {
                background-color: transparent !important;
            }
            
            /* Subsidiary items in print */
            .subsidiary-item {
                border-top: 1px solid #000 !important;
                padding: 4px 0 !important;
            }
            
            .subsidiary-item:first-child {
                border-top: none !important;
            }
            
            /* Hide card styling */
            .card {
                border: none !important;
                box-shadow: none !important;
            }
            
            .card-body {
                padding: 0 !important;
            }
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-sitemap text-primary"></i>
                            Chart of Accounts
                        </h4>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search and Export Controls -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" id="searchInput" class="form-control search-box" placeholder="Search Chart of Accounts...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="export-buttons">
                                <button type="button" class="btn btn-export btn-print" onclick="printChart()">
                                    <i class="fas fa-print"></i> Print
                                </button>
                                <button type="button" class="btn btn-export btn-excel" onclick="exportToExcel()">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </button>
                            </div>
                        </div>
                    </div>
                    @if($accountTypes->count() > 0)
                        <!-- Print Header (hidden on screen, visible in print) -->
                        <div class="print-header" style="display: none;">
                            Chart of Accounts
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered" id="chartTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="25%" class="text-left">Account Type</th>
                                        <th width="25%" class="text-left">Account Group</th>
                                        <th width="50%" class="text-left">Subsidiary Ledger</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($accountTypes as $accountType)
                                        @if($accountType->groups->count() > 0)
                                            @foreach($accountType->groups as $groupIndex => $group)
                                                <tr>
                                                    @if($groupIndex == 0)
                                                        <td rowspan="{{ $accountType->groups->count() }}" class="align-middle text-left">
                                                            <strong>{{ $accountType->code }}</strong> - {{ $accountType->name }}
                                                        </td>
                                                    @endif
                                                    <td class="align-middle text-left">
                                                        <strong>{{ $group->code }}</strong> - {{ $group->name }}
                                                    </td>
                                                    <td class="align-middle text-left">
                                                        @if($group->subsidiaryLedgers->count() > 0)
                                                            @foreach($group->subsidiaryLedgers as $index => $ledger)
                                                                <div class="subsidiary-item {{ $index > 0 ? 'border-top' : '' }}">
                                                                    <strong>{{ $ledger->ledger_code }}</strong> - {{ $ledger->name }}
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">No Subsidiary Ledgers</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="align-middle text-left">
                                                    <strong>{{ $accountType->code }}</strong> - {{ $accountType->name }}
                                                </td>
                                                <td class="text-left text-muted">No Groups</td>
                                                <td class="text-left text-muted">No Subsidiary Ledgers</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-sitemap fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-2">No Account Types Found</h5>
                            <p class="text-muted mb-3">Start by creating account types, groups, and subsidiary ledgers</p>
                            <a href="{{ route('account-types.index') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Account Type
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_js')
    <!-- DataTables JS -->
    <script src="{{ url('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/jszip.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/pdfmake.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/vfs_fonts.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/buttons.html5.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            // Search functionality
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#chartTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });

        // Print function
        function printChart() {
            window.print();
        }

        // Excel export function
        function exportToExcel() {
            var table = document.getElementById('chartTable');
            var wb = XLSX.utils.table_to_book(table, {sheet: "Chart of Accounts"});
            XLSX.writeFile(wb, 'Chart_of_Accounts_' + new Date().toISOString().slice(0,10) + '.xlsx');
        }

    </script>

    <style>
        .dt-buttons {
            display: none !important;
        }
    </style>
@endsection

