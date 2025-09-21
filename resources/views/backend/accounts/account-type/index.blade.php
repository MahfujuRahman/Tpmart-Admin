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
        
        .btn-create {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 8px;
            color: white;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .btn-create:hover {
            background: linear-gradient(135deg, #218838, #1ea085);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
            color: white;
        }
        
        .btn-create:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
        }
        
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 10px 0;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 5px 10px;
        }
        
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 5px;
        }
        
        .card-header {
            background-color: #ffffff;
            border-bottom: 2px solid #e9ecef;
            font-weight: 600;
            color: #495057;
        }
        
        .card {
            border: 1px solid #e9ecef;
        }
        
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 6px;
        }
        
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .search-section .input-group {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .search-section .form-control {
            border-right: none;
        }
        
        .search-section .btn-outline-secondary {
            border-left: none;
        }
        
        .search-section .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            border-color: #ced4da;
        }
        
        .search-section .btn-outline-secondary {
            font-size: 18px;
            font-weight: bold;
            color: #6c757d;
        }
        
        .search-section .btn-outline-secondary:hover {
            color: #dc3545;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .action-buttons .btn {
            margin: 2px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .action-buttons .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        
        .btn-edit {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            color: white;
        }
        
        .btn-edit:hover {
            background: linear-gradient(45deg, #0056b3, #004085);
            color: white;
        }
        
        .btn-toggle {
            background: linear-gradient(45deg, #ffc107, #e0a800);
            border: none;
            color: white;
        }
        
        .btn-toggle:hover {
            background: linear-gradient(45deg, #e0a800, #d39e00);
            color: white;
        }
        
        .btn-delete {
            background: linear-gradient(45deg, #dc3545, #c82333);
            border: none;
            color: white;
        }
        
        .btn-delete:hover {
            background: linear-gradient(45deg, #c82333, #bd2130);
            color: white;
        }
        
        .edit-form {
            display: none;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }
        
        .edit-form.show {
            display: block;
        }
        
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            margin-bottom: 20px;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            margin-left: 0.5em;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 5px 10px;
        }
        
        .dataTables_wrapper .dataTables_length {
            float: left;
            margin-bottom: 20px;
        }
        
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 5px;
            margin: 0 5px;
        }
        
        .dataTables_wrapper .dataTables_info {
            clear: both;
            float: left;
            padding-top: 0.755em;
        }
        
        .dataTables_wrapper .dataTables_paginate {
            float: right;
            text-align: right;
            padding-top: 0.25em;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            box-sizing: border-box;
            display: inline-block;
            min-width: 1.5em;
            padding: 0.5em 1em;
            margin-left: 2px;
            text-align: center;
            text-decoration: none !important;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 2px;
            background: transparent;
            color: #333 !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: white !important;
            border: 1px solid #111;
            background-color: #585858;
            background: linear-gradient(to bottom, #585858 0%, #111 100%);
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: white !important;
            border: 1px solid #979797;
            background-color: #585858;
            background: linear-gradient(to bottom, #585858 0%, #111 100%);
        }

        /* Empty State Styles */
        .empty-state-icon {
            opacity: 0.6;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .dataTables_empty {
            padding: 0 !important;
        }

        .dataTables_empty td {
            border: none !important;
            padding: 0 !important;
        }
    </style>
@endsection

@section('page_title')
    Account Types Management
@endsection

@section('page_heading')
    Account Types Management
@endsection

@section('content')
    <div class="row">
        <!-- Left Side - Create Form -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-plus text-success"></i> Create Account Type
                    </h5>
                </div>
                <div class="card-body">
                    <form class="needs-validation" method="POST" action="{{ route('account-types.store') }}" id="accountTypeForm" novalidate>
                        @csrf
                        <input type="hidden" name="edit_id" id="edit_id" value="">

                                        <div class="form-group">
                            <label for="account_type_name">
                                Account Type Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="account_type_name" 
                                   name="account_type_name"
                                   class="form-control @error('account_type_name') is-invalid @enderror" 
                                   placeholder="e.g., Assets, Liabilities, Equity"
                                   value="{{ old('account_type_name') }}"
                                   required>
                            @error('account_type_name')
                                <div class="invalid-feedback d-block">
                                                    <strong>{{ $message }}</strong>
                                </div>
                                                @enderror
                                        </div>

                        <div class="form-group">
                            <label for="account_type_code">
                                Account Type Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="account_type_code" 
                                   name="account_type_code" 
                                   maxlength="10"
                                   class="form-control @error('account_type_code') is-invalid @enderror" 
                                   placeholder="e.g., AST, LIA, EQU"
                                   value="{{ old('account_type_code') }}"
                                   required>
                            @error('account_type_code')
                                <div class="invalid-feedback d-block">
                                                    <strong>{{ $message }}</strong>
                                            </div>
                                                @enderror
                                            </div>

                                        <div class="form-group">
                            <label for="note">Description</label>
                            <textarea id="note" 
                                      name="note" 
                                      class="form-control @error('note') is-invalid @enderror" 
                                      placeholder="Enter additional details..."
                                      rows="3">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                                @enderror
                                            </div>

                        <div class="form-group text-rigth pt-3">
                            <button type="button" style="width: 130px;" class="btn btn-secondary m-2" onclick="clearForm()">
                                <i class="mdi mdi-cancel"></i> Cancel
                            </button>
                            <button class="btn btn-primary m-2" style="width: 130px;" type="submit" id="submitBtn">
                                <i class="fa fa-floppy-o"></i> <span id="submitText">Save</span>
                            </button>
                                        </div>

                    </form>
                </div>
                                            </div>
                                        </div>

        <!-- Right Side - DataTable List -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list text-primary"></i> Account Types List
                        </h5>
                       
                    </div>
                                            </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="accountTypesTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accountTypes as $index => $accountType)
                                    <tr id="row-{{ $accountType->id }}">
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $accountType->name }}</td>
                                        <td>
                                            <span class="code-display badge badge-secondary">{{ $accountType->code }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $accountType->status ? 'success' : 'secondary' }}">
                                                {{ $accountType->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button type="button" 
                                                        class="btn btn-sm btn-edit" 
                                                        onclick="editAccountType({{ $accountType->id }})"
                                                        title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                
                                                <button type="button" 
                                                        class="btn btn-sm btn-toggle" 
                                                        onclick="toggleStatus({{ $accountType->id }})"
                                                        title="{{ $accountType->status ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fa fa-{{ $accountType->status ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                                
                                                <!-- <button type="button" 
                                                        class="btn btn-sm btn-delete" 
                                                        onclick="deleteAccountType({{ $accountType->id }})"
                                                        title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button> -->
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this account type?</p>
                            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="{{ url('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('assets') }}/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ url('assets') }}/plugins/select2/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#accountTypesTable').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pageLength": 10,
                "order": [[ 0, "asc" ]],
                "dom": 'lfrtip', // Show length, filter, info, processing, table, pagination
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries found",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "emptyTable": `
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-2">
                                <i class="fas fa-box-open fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-2">No Account Types Found</h5>
                            
                        </div>
                    `,
                    "zeroRecords": `
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-2">
                                <i class="fas fa-search fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-2">No Matching Records</h5>
                            <p class="text-muted mb-3">Try adjusting your search criteria</p>
                        </div>
                    `,
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                },
                "columnDefs": [
                    { "orderable": false, "targets": 4 } // Disable sorting on Actions column
                ]
            });

            // Form validation
            $('.needs-validation').on('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                $(this).addClass('was-validated');
            });
        });

        function editAccountType(id) {
            // Get account type data via AJAX
            $.ajax({
                url: '{{ route("account-types.edit", ":id") }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    // Fill the form with data
                    $('#edit_id').val(response.id);
                    $('#account_type_name').val(response.name);
                    $('#account_type_code').val(response.code);
                    $('#note').val(response.note);
                    
                    // Change form action and button text
                    $('#accountTypeForm').attr('action', '{{ route("account-types.update", ":id") }}'.replace(':id', id));
                    $('#submitText').text('Update');
                    $('#submitBtn').html('<i class="fa fa-edit"></i> Update');
                    
                    // Scroll to form
                    $('html, body').animate({
                        scrollTop: $('#accountTypeForm').offset().top - 100
                    }, 500);
                },
                error: function(xhr) {
                    toastr.error('Error loading account type data');
                }
            });
        }

        function clearForm() {
            // Reset form
            $('#accountTypeForm')[0].reset();
            $('#edit_id').val('');
            
            // Reset form action and button
            $('#accountTypeForm').attr('action', '{{ route("account-types.store") }}');
            $('#submitText').text('Save');
            $('#submitBtn').html('<i class="fa fa-floppy-o"></i> Save');
        }

        // Handle form submission for both create and update
        $('#accountTypeForm').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var formData = form.serialize();
            var editId = $('#edit_id').val();
            
            if (editId) {
                // Update existing account type
                formData += '&_method=PUT';
                var url = '{{ route("account-types.update", ":id") }}'.replace(':id', editId);
            } else {
                // Create new account type
                var url = '{{ route("account-types.store") }}';
            }
            
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success(editId ? 'Account type updated successfully' : 'Account type created successfully');
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Display validation errors
                        var errors = xhr.responseJSON.errors;
                        for (var field in errors) {
                            toastr.error(errors[field][0]);
                        }
                    } else {
                        toastr.error('Error saving account type');
                    }
                }
            });
        });

        function deleteAccountType(id) {
            $('#deleteForm').attr('action', '{{ route("account-types.delete", ":id") }}'.replace(':id', id));
            $('#deleteModal').modal('show');
        }

        // Handle delete form submission
        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            
            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    toastr.success('Account type deleted successfully');
                    location.reload();
                },
                error: function(xhr) {
                    $('#deleteModal').modal('hide');
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('Error deleting account type');
                    }
                }
            });
        });

        function toggleStatus(id) {
            if (confirm('Are you sure you want to change the status of this account type?')) {
                window.location.href = '{{ route("account-types.toggle-status", ":id") }}'.replace(':id', id);
            }
        }

        // Show success/error messages
        @if(session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        @if(session('error'))
            toastr.error('{{ session('error') }}');
        @endif
    </script>
@endsection