@extends('backend.master')

@section('header_css')
    <link href="{{ url('assets') }}/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets') }}/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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
        
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .btn-group .btn {
            margin-right: 2px;
        }
        
        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }
        
        .badge {
            font-size: 0.75em;
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
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center" 
                    style="background-color:#17263a; border-top:5px solid #0d1a2b; color:#e1e4e9;">
                    
                    <h4 class="card-title mb-0" style="color:#e1e4e9;">Accounts Configuration List</h4>
                    
                    <div class="card-tools">
                        <a href="{{ route('accounts-configuration.create') }}" class="btn btn-primary add-button">
                            <i class="fas fa-plus"></i> Add New Configuration
                        </a>
                    </div>
                </div>

                

                <!-- <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs"></i> Accounts Configuration
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('accounts-configuration.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Configuration
                        </a>
                        <form action="{{ route('accounts-configuration.reset') }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to reset all configurations to default? This will delete all existing configurations.')">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-undo"></i> Reset to Default
                            </button>
                        </form>
                    </div>
                </div> -->
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('accounts-configuration.bulk-update') }}" method="POST" id="bulkUpdateForm">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="25%">Account Name</th>
                                        <th width="15%">Account Type</th>
                                        <th width="20%">Account Code</th>
                                        <th width="25%">Description</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($configurations as $index => $config)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $config->account_name }}</strong>
                                            <input type="hidden" name="configurations[{{ $index }}][id]" value="{{ $config->id }}">
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $config->account_type == 'Control Group' ? 'primary' : ($config->account_type == 'Subsidiary Ledger' ? 'success' : 'info') }}">
                                                {{ $config->account_type }}
                                            </span>
                                        </td>
                                        <td>
                                            <input type="text" 
                                                   name="configurations[{{ $index }}][account_code]" 
                                                   value="{{ $config->account_code }}" 
                                                   class="form-control form-control-sm" 
                                                   maxlength="20"
                                                   required>
                                        </td>
                                        <td>{{ $config->description ?? 'N/A' }}</td>
                                        <td>
                                            @if($config->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('accounts-configuration.show', $config) }}" 
                                                   class="btn btn-info btn-sm" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('accounts-configuration.edit', $config) }}" 
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        title="Delete"
                                                        onclick="deleteConfiguration({{ $config->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No configurations found. 
                                            <a href="{{ route('accounts-configuration.create') }}">Create the first one</a> or 
                                            <form action="{{ route('accounts-configuration.reset') }}" method="POST" class="d-inline" onsubmit="return confirm('Reset to default configurations?')">
                                                @csrf
                                                <button type="submit" class="btn btn-link p-0">reset to default</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- @if($configurations->count() > 0)
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update All Configurations
                                </button>
                            </div>
                        </div>
                        @endif -->
                    </form>

                    <!-- Hidden delete forms -->
                    @foreach($configurations as $config)
                    <form id="delete-form-{{ $config->id }}" action="{{ route('accounts-configuration.destroy', $config) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_js')
<script>
$(document).ready(function() {
    // Auto-save functionality (optional)
    $('input[name*="[account_code]"]').on('blur', function() {
        // You can add auto-save functionality here if needed
    });
});

function deleteConfiguration(id) {
    if (confirm('Are you sure you want to delete this configuration?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection
