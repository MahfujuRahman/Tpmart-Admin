@extends('backend.master')

@section('header_css')
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
        .card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: none;
            border-radius: 8px;
        }
        
        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
        }
        
        .badge {
            font-size: 0.75em;
        }
        
        .btn-group .btn {
            margin-right: 2px;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye"></i> Account Configuration Details
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('accounts-configuration.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('accounts-configuration.edit', $accountsConfiguration) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Account Name:</th>
                                    <td><strong>{{ $accountsConfiguration->account_name }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Account Type:</th>
                                    <td>
                                        <span class="badge badge-{{ $accountsConfiguration->account_type == 'Control Group' ? 'primary' : ($accountsConfiguration->account_type == 'Subsidiary Ledger' ? 'success' : 'info') }}">
                                            {{ $accountsConfiguration->account_type }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Account Code:</th>
                                    <td><code>{{ $accountsConfiguration->account_code }}</code></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Status:</th>
                                    <td>
                                        @if($accountsConfiguration->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sort Order:</th>
                                    <td>{{ $accountsConfiguration->sort_order }}</td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $accountsConfiguration->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated:</th>
                                    <td>{{ $accountsConfiguration->updated_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($accountsConfiguration->description)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Description:</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $accountsConfiguration->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="btn-group" role="group">
                                <a href="{{ route('accounts-configuration.edit', $accountsConfiguration) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Configuration
                                </a>
                                <form action="{{ route('accounts-configuration.destroy', $accountsConfiguration) }}" 
                                      method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this configuration?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Delete Configuration
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
