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
        
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .form-group label {
            font-weight: 600;
            color: #495057;
        }
        
        .text-danger {
            color: #dc3545 !important;
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
                        <i class="fas fa-plus"></i> Create New Account Configuration
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('accounts-configuration.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('accounts-configuration.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_name">Account Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('account_name') is-invalid @enderror" 
                                           id="account_name" 
                                           name="account_name" 
                                           value="{{ old('account_name') }}" 
                                           required>
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_type">Account Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('account_type') is-invalid @enderror" 
                                            id="account_type" 
                                            name="account_type" 
                                            required>
                                        <option value="">Select Account Type</option>
                                        @foreach($accountTypes as $key => $value)
                                            <option value="{{ $key }}" {{ old('account_type') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('account_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_code">Account Code <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('account_code') is-invalid @enderror" 
                                           id="account_code" 
                                           name="account_code" 
                                           value="{{ old('account_code') }}" 
                                           maxlength="20"
                                           required>
                                    <small class="form-text text-muted">Maximum 20 characters</small>
                                    @error('account_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort_order">Sort Order</label>
                                    <input type="number" 
                                           class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" 
                                           name="sort_order" 
                                           value="{{ old('sort_order', 0) }}" 
                                           min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               class="form-check-input" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Configuration
                                </button>
                                <a href="{{ route('accounts-configuration.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_js')
<script>
$(document).ready(function() {
    // Auto-generate account code based on account name (optional)
    $('#account_name').on('blur', function() {
        if (!$('#account_code').val()) {
            var name = $(this).val();
            var code = name.toLowerCase().replace(/[^a-z0-9]/g, '').substring(0, 10);
            $('#account_code').val(code);
        }
    });
});
</script>
@endsection
