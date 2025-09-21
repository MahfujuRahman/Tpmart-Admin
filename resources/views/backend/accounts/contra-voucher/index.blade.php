@extends('backend.master')


@section('title', 'Contra Voucher')

@section('content')
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
                <div class="card-header d-flex justify-content-between align-items-center" 
                    style="background-color:#17263a; border-top:5px solid #0d1a2b; color:#e1e4e9;">
                    
                    <h4 class="card-title mb-0" style="color:#e1e4e9;">Contra Voucher List</h4>
                    
                    <div class="card-tools">
                        <a href="{{ route('contra-voucher.create') }}" class="btn btn-primary add-button">
                            <i class="fas fa-plus"></i> Add New Contra Voucher
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('contra-voucher.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="voucher_no">Voucher No</label>
                                    <input type="text" class="form-control" id="voucher_no" name="voucher_no" 
                                           value="{{ request('voucher_no') }}" placeholder="Enter voucher number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_from">Date From</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from" 
                                           value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_to">Date To</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to" 
                                           value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary add-button">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('contra-voucher.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Voucher No</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Note</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($contraVouchers->count() > 0)
                                    @foreach ($contraVouchers as $contraVoucher)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $contraVoucher->voucher_no ?? 'N/A' }}</td>
                                            <td>{{ $contraVoucher->trans_date ? (is_string($contraVoucher->trans_date) ? \Carbon\Carbon::parse($contraVoucher->trans_date)->format('Y-m-d') : $contraVoucher->trans_date->format('Y-m-d')) : 'N/A' }}</td>
                                            <td>{{ number_format($contraVoucher->amount ?? 0, 2) }}</td>
                                            <td>
                                                <span class="badge badge-{{ ($contraVoucher->status ?? 0) ? 'success' : 'danger' }}">
                                                    {{ ($contraVoucher->status ?? 0) == 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="text-center" style="width:15%">{{ $contraVoucher->comments ?? 'N/A' }}</td>
                                            
                                            <td class="text-center" style="width:18%">
                                                <a href="{{ route('contra-voucher.show', $contraVoucher->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('contra-voucher.edit', $contraVoucher->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="{{ route('contra-voucher.print', $contraVoucher->id) }}" class="btn btn-sm btn-success" target="_blank">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <form action="{{ route('contra-voucher.destroy', $contraVoucher->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <p class="text-muted">No contra vouchers found.</p>
                                            <a href="{{ route('contra-voucher.create') }}" class="btn btn-primary">
                                                Create First Contra Voucher
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($contraVouchers->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $contraVouchers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
