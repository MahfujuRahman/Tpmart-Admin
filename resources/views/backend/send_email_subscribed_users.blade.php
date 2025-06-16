@extends('backend.master')

@section('header_css')
    <link href="{{ url('dataTable') }}/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('dataTable') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0px;
            border-radius: 4px;
        }

        table.dataTable tbody td {
            text-align: center !important;
        }

        table.dataTable tbody td:nth-child(1) {
            text-align: center !important;
            font-weight: 600;
        }
    </style>
@endsection

@section('page_title')
    Send Email to Subscribed Users
@endsection
@section('page_heading')
    Send Email to Subscribed Users
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-3">Subscribed Users Email List</h4>
                        <a href="{{ url('view/all/subscribed/users') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                    <form id="bulkEmailForm">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 data-table-emails">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>Email</th>
                                        <th>Subscribed On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscribedUsers as $user)
                                        <tr>
                                            <td><input type="checkbox" name="emails[]" value="{{ $user->email }}"></td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group mt-4">
                            <label for="email-subject">Subject</label>
                            <input type="text" class="form-control" id="email-subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="email-message">Message</label>
                            <textarea class="form-control" id="email-message" name="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="{{ url('dataTable') }}/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('dataTable') }}/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.data-table-emails').DataTable();
            // $('.data-table-emails').DataTable({
            //     "pageLength": 20,
            //     "lengthMenu": [
            //         [10, 20, 50, 100, -1],
            //         [10, 20, 50, 100, "All"]
            //     ]
            // });

            $('#selectAll').on('click', function() {
                $('input[name="emails[]"]').prop('checked', this.checked);
            });
            $('#bulkEmailForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var submitBtn = form.find('button[type="submit"]');
                submitBtn.prop('disabled', true).text('Sending...');
                $.ajax({
                    type: 'POST',
                    url: '{{ url('subscribed/users/send-email') }}',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        toastr.success('Emails are being sent via queue.', 'Success');
                        submitBtn.prop('disabled', false).text('Send Email');
                        // Clear form fields
                        $('#email-subject').val('');
                        $('#email-message').val('');
                        // Uncheck all checkboxes
                        $('input[type="checkbox"]').prop('checked', false);
                    },
                    error: function(data) {
                        toastr.error('Failed to send emails.', 'Error');
                        submitBtn.prop('disabled', false).text('Send Email');
                    }
                });
            });
        });
    </script>
@endsection
