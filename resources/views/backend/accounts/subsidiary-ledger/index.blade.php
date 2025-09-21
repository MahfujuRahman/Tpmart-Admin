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
            padding: 15px 12px;
        }
        
        .table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .badge {
            font-size: 0.75em;
            padding: 0.5em 0.75em;
            border-radius: 0.375rem;
        }
        
        .btn-action {
            padding: 6px 12px;
            margin: 2px;
            border-radius: 4px;
            font-size: 0.875rem;
            border: none;
            transition: all 0.2s ease;
        }
        
        .btn-edit {
            background-color: #ffc107;
            color: #212529;
        }
        
        .btn-edit:hover {
            background-color: #e0a800;
            color: #212529;
        }
        
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        
        .btn-toggle {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-toggle:hover {
            background-color: #5a6268;
            color: white;
        }
        
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            margin-bottom: 20px;
        }
        
        .dataTables_wrapper .dataTables_filter input {
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
    Subsidiary Ledger Management
@endsection

@section('page_heading')
    Subsidiary Ledger Management
@endsection

@section('content')
    <div class="row">
        <!-- Left Side - Create Form -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-plus text-success"></i> Create Subsidiary Ledger
                    </h5>
                </div>
                <div class="card-body">
                    <form class="needs-validation" method="POST" action="{{ route('subsidiary-ledger.store') }}" id="subsidiaryLedgerForm" novalidate>
                        @csrf
                        <input type="hidden" name="edit_id" id="edit_id" value="">

                        <div class="form-group">
                            <label for="ledger_name">
                                Ledger Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="ledger_name" 
                                   name="ledger_name"
                                   class="form-control @error('ledger_name') is-invalid @enderror" 
                                   placeholder="e.g., Cash in Hand, Bank Account"
                                   value="{{ old('ledger_name') }}"
                                   required>
                            @error('ledger_name')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="ledger_code">
                                Ledger Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="ledger_code" 
                                   name="ledger_code" 
                                   maxlength="10"
                                   class="form-control @error('ledger_code') is-invalid @enderror" 
                                   placeholder="e.g., CASH, BANK"
                                   value="{{ old('ledger_code') }}"
                                   required>
                            @error('ledger_code')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="group_id">
                                Group <span class="text-danger">*</span>
                            </label>
                            <select id="group_id" 
                                    name="group_id" 
                                    class="form-control select2 @error('group_id') is-invalid @enderror" 
                                    required>
                                <option value="">Select Group</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('group_id')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Hidden Account Type Field -->
                        <div class="form-group" style="display: none;">
                            <label for="account_type_id">
                                Account Type <span class="text-danger">*</span>
                            </label>
                            <select id="account_type_id" 
                                    name="account_type_id" 
                                    class="form-control @error('account_type_id') is-invalid @enderror" 
                                    required>
                                <option value="">Select Account Type</option>
                                @foreach($accountTypes as $accountType)
                                    <option value="{{ $accountType->id }}" {{ old('account_type_id') == $accountType->id ? 'selected' : '' }}>
                                        {{ $accountType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('account_type_id')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group text-right pt-3">
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
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list text-primary"></i> Subsidiary Ledger List
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="subsidiaryLedgerTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">SL.No</th>
                                    <th>Ledger Name</th>
                                    <th>Ledger Code</th>
                                    <th>Group</th>
                                    <th>Account Type</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subsidiaryLedgers as $index => $ledger)
                                    <tr id="row-{{ $ledger->id }}">
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $ledger->name }}</td>
                                        <td>
                                            <span class="code-display badge badge-secondary">{{ $ledger->ledger_code }}</span>
                                        </td>
                                        <td>{{ $ledger->group->name ?? 'N/A' }}</td>
                                        <td>{{ $ledger->accountType->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $ledger->status ? 'success' : 'secondary' }}">
                                                {{ $ledger->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button type="button" 
                                                        class="btn btn-sm btn-edit" 
                                                        onclick="editLedger({{ $ledger->id }})"
                                                        title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-toggle" 
                                                        onclick="toggleStatus({{ $ledger->id }})"
                                                        title="{{ $ledger->status ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fa fa-{{ $ledger->status ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-delete" 
                                                        onclick="deleteLedger({{ $ledger->id }})"
                                                        title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
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
                    <p>Are you sure you want to delete this subsidiary ledger?</p>
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
            // Initialize Select2 for visible fields only
            $('.select2').select2({
                placeholder: 'Select an option',
                allowClear: true,
                width: '100%'
            });

            // Handle group selection change
            $('#group_id').on('change', function() {
                var groupId = $(this).val();
                if (groupId) {
                    // Get account type from selected group
                    $.ajax({
                        url: '{{ route("groups.edit", ":id") }}'.replace(':id', groupId),
                        type: 'GET',
                        success: function(response) {
                            // Set the account type based on group's account type
                            $('#account_type_id').val(response.account_type_id);
                        },
                        error: function(xhr) {
                            console.log('Error loading group data:', xhr);
                        }
                    });
                } else {
                    // Clear account type if no group selected
                    $('#account_type_id').val('');
                }
            });

            // Initialize DataTable
            var table = $('#subsidiaryLedgerTable').DataTable({
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
                            <h5 class="text-muted mb-2">No Subsidiary Ledgers Found</h5>
                            
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
                    { "orderable": false, "targets": 6 } // Disable sorting on Actions column
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

        function editLedger(id) {
            // Get ledger data via AJAX
            $.ajax({
                url: '{{ route("subsidiary-ledger.edit", ":id") }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    // Fill the form with data
                    $('#edit_id').val(response.id);
                    $('#ledger_name').val(response.name);
                    $('#ledger_code').val(response.ledger_code);
                    $('#group_id').val(response.group_id).trigger('change');
                    $('#account_type_id').val(response.account_type_id).trigger('change');
                    
                    // Change form action and button text
                    $('#subsidiaryLedgerForm').attr('action', '{{ route("subsidiary-ledger.update", ":id") }}'.replace(':id', id));
                    $('#submitText').text('Update');
                    $('#submitBtn').html('<i class="fa fa-edit"></i> Update');
                    
                    // Scroll to form
                    $('html, body').animate({
                        scrollTop: $('#subsidiaryLedgerForm').offset().top - 100
                    }, 500);
                },
                error: function(xhr) {
                    toastr.error('Error loading ledger data');
                }
            });
        }

        function clearForm() {
            // Reset form
            $('#subsidiaryLedgerForm')[0].reset();
            $('#edit_id').val('');
            
            // Reset Select2 dropdowns
            $('.select2').val('').trigger('change');
            
            // Reset hidden account type field
            $('#account_type_id').val('');
            
            // Reset form action and button
            $('#subsidiaryLedgerForm').attr('action', '{{ route("subsidiary-ledger.store") }}');
            $('#submitText').text('Save');
            $('#submitBtn').html('<i class="fa fa-floppy-o"></i> Save');
        }

        // Handle form submission for both create and update
        $('#subsidiaryLedgerForm').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var formData = form.serialize();
            var editId = $('#edit_id').val();
            
            // Debug: Log form data
            console.log('Form Data:', formData);
            console.log('Edit ID:', editId);
            
            if (editId) {
                // Update existing ledger
                formData += '&_method=PUT';
                var url = '{{ route("subsidiary-ledger.update", ":id") }}'.replace(':id', editId);
            } else {
                // Create new ledger
                var url = '{{ route("subsidiary-ledger.store") }}';
            }
            
            console.log('URL:', url);
            
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Success Response:', response);
                    toastr.success(editId ? 'Subsidiary Ledger updated successfully' : 'Subsidiary Ledger created successfully');
                    location.reload();
                },
                error: function(xhr) {
                    console.log('Error Response:', xhr);
                    console.log('Error Status:', xhr.status);
                    console.log('Error Response Text:', xhr.responseText);
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Display validation errors
                        var errors = xhr.responseJSON.errors;
                        for (var field in errors) {
                            toastr.error(errors[field][0]);
                        }
                    } else if (xhr.responseJSON && xhr.responseJSON.error) {
                        toastr.error(xhr.responseJSON.error);
                    } else {
                        toastr.error('Error saving subsidiary ledger: ' + xhr.responseText);
                    }
                }
            });
        });

        function deleteLedger(id) {
            $('#deleteForm').attr('action', '{{ route("subsidiary-ledger.delete", ":id") }}'.replace(':id', id));
            $('#deleteModal').modal('show');
        }

        function toggleStatus(id) {
            if (confirm('Are you sure you want to change the status of this subsidiary ledger?')) {
                $.ajax({
                    url: '{{ route("subsidiary-ledger.toggle-status", ":id") }}'.replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        toastr.success('Subsidiary Ledger status updated successfully');
                        location.reload();
                    },
                    error: function(xhr) {
                        toastr.error('Error updating subsidiary ledger status');
                    }
                });
            }
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
                    toastr.success('Subsidiary Ledger deleted successfully');
                    location.reload();
                },
                error: function(xhr) {
                    $('#deleteModal').modal('hide');
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('Error deleting subsidiary ledger');
                    }
                }
            });
        });

        // Show success/error messages
        @if(session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        @if(session('error'))
            toastr.error('{{ session('error') }}');
        @endif
    </script>
@endsection