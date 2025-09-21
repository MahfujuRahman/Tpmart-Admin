@extends('backend.master')

@section('title', 'Journal Voucher List')

@section('content')
<style>
     .card-header{
            background-color:#17263a; 
            border-top:5px solid #0d1a2b;
            color:#e1e4e9;
            border-radius-top-left: 15px;
            border-radius-top-right: 15px;
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
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center" 
                    style="background-color:#17263a; border-top:5px solid #0d1a2b; color:#e1e4e9;">
                    
                    <h4 class="card-title mb-0" style="color:#e1e4e9;">Journal Voucher List</h4>
                    
                    <div class="card-tools">
                        <a href="{{ route('voucher.journal.create') }}" class="btn btn-primary add-button">
                            <i class="fas fa-plus"></i> Add New Journal Voucher
                        </a>
                    </div>
                </div>


                
                <div class="card-body">
                    <!-- Search Form -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('voucher.journal') }}" class="form-inline">
                                <div class="form-group mr-3">
                                    <label for="voucher_no" class="mr-2">Voucher No:</label>
                                    <input type="text" class="form-control" id="voucher_no" name="voucher_no" 
                                           value="{{ request('voucher_no') }}" placeholder="Enter voucher number">
                                </div>
                                <div class="form-group mr-3">
                                    <label for="date_from" class="mr-2">From Date:</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from" 
                                           value="{{ request('date_from') }}">
                                </div>
                                <div class="form-group mr-3">
                                    <label for="date_to" class="mr-2">To Date:</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to" 
                                           value="{{ request('date_to') }}">
                                </div>
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="{{ route('voucher.journal') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </form>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Voucher No</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($journalVouchers as $voucher)
                                    <tr>
                                        <td>{{ $voucher->voucher_no }}</td>
                                        <td>{{ $voucher->trans_date ? $voucher->trans_date->format('d/m/Y') : 'N/A' }}</td>
                                        <td class="text-right">{{ number_format($voucher->amount, 2) }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $voucher->status ? 'success' : 'danger' }}">
                                                {{ $voucher->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $voucher->comments ?? 'N/A' }}</td>
                                        <td class="text-center" style="width:18%">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('voucher.journal.show', $voucher->id) }}" 
                                                   class="btn btn-info btn-sm" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('voucher.journal.edit', $voucher->id) }}" 
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('voucher.journal.print', $voucher->id) }}" 
                                                   class="btn btn-success btn-sm" title="Print" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                                <form action="{{ route('voucher.journal.destroy', $voucher->id) }}" 
                                                      method="POST" style="display: inline-block;" 
                                                      onsubmit="return confirm('Are you sure you want to delete this journal voucher?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No Journal Vouchers Found</h5>
                                                <p class="text-muted">Start by creating your first journal voucher.</p>
                                                <a href="{{ route('voucher.journal.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Create Journal Voucher
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($journalVouchers->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $journalVouchers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
