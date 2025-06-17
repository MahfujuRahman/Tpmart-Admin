@extends('backend.master')

@section('header_css')
    <link href="{{url('assets')}}/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('page_title')
    User Role
@endsection
@section('page_heading')
    Create New User Role
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">New User Role Form</h4>

                    <form class="needs-validation" method="POST" action="{{url('save/user/role')}}" enctype="multipart/form-data">
                        @csrf

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Role Name <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Role Name" required>
                                    <div class="invalid-feedback" style="display: block;">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Role Description</label>
                                <div class="col-sm-10">
                                    <textarea id="description" name="description" class="form-control" placeholder="Role Description Here"></textarea>
                                    <div class="invalid-feedback" style="display: block;">
                                        @error('description')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>

                            @php
                                use Illuminate\Support\Str;
                                
                                // Get routes organized by Module > Groups > Routes structure
                                $permissionController = new App\Http\Controllers\PermissionRoutesController();
                                $moduleGroupRoutes = $permissionController->getRoutesByModuleAndGroup();
                                
                                // Check if 'home' route exists and mark it as checked
                                $homeRoute = App\Models\PermissionRoutes::where('route', 'home')->first();
                            @endphp

                            <h4 class="card-title mb-4 mt-4">Assign Permission to this Role</h4>
                            
                            <!-- Auto-check home route if exists -->
                            @if($homeRoute)
                                <input type="checkbox" checked hidden id="per{{$homeRoute->id}}" value="{{$homeRoute->id}}" name="permission_id[]"/>
                            @endif
                            
                            <div class="accordion" id="moduleAccordion">
                                @foreach($moduleGroupRoutes as $moduleName => $moduleData)
                                    <div class="card">
                                        <div class="card-header" id="heading{{Str::slug($moduleName)}}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{Str::slug($moduleName)}}" aria-expanded="true" aria-controls="collapse{{Str::slug($moduleName)}}">
                                                    <i class="fas fa-cube text-primary"></i>
                                                    <strong>{{ ucwords(str_replace(['-', '_'], ' ', $moduleName)) }} Module</strong>
                                                    <span class="badge badge-primary ml-2">{{ $moduleData['total_count'] }} routes</span>
                                                    <i class="fas fa-chevron-up float-right mt-1"></i>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse{{Str::slug($moduleName)}}" class="collapse show" aria-labelledby="heading{{Str::slug($moduleName)}}">
                                            <div class="card-body">
                                                @foreach($moduleData['groups'] as $groupName => $groupData)
                                                    <div class="mb-4">
                                                        <h6 class="text-info">
                                                            <i class="fas fa-layer-group"></i>
                                                            {{ $groupName }} Group
                                                            <span class="badge badge-info ml-2">{{ $groupData['count'] }} routes</span>
                                                        </h6>
                                                        <div class="row">
                                                            @foreach($groupData['routes'] as $index => $permissionRoute)
                                                                @if($permissionRoute->route == 'home')
                                                                    @continue
                                                                @endif
                                                                
                                                                <div class="col-md-6 mb-2">
                                                                    <div class="form-group border-bottom pb-2">
                                                                        <div class="d-flex align-items-center">
                                                                            <input type="checkbox" 
                                                                                   data-size="small" 
                                                                                   id="per{{$permissionRoute->id}}" 
                                                                                   value="{{$permissionRoute->id}}" 
                                                                                   name="permission_id[]" 
                                                                                   data-toggle="switchery" 
                                                                                   data-color="#08da82" 
                                                                                   data-secondary-color="#df3554"/>
                                                                            <div class="ml-3">
                                                                                <label for="per{{$permissionRoute->id}}" style="cursor: pointer; margin-bottom: 0;">
                                                                                    <small class="text-muted">Route:</small> <strong>{{$permissionRoute->route}}</strong><br>
                                                                                    <small class="text-muted">Name:</small> <code>{{$permissionRoute->name}}</code>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        <div class="form-group text-center pt-3">
                            <button class="btn btn-primary m-2" type="submit"><i class="fas fa-save"></i>&nbsp; Create New Role</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_js')
    <script src="{{url('assets')}}/plugins/switchery/switchery.min.js"></script>
    <script type="text/javascript">
        function initializeSwitchery() {
            $('[data-toggle="switchery"]').each(function (idx, obj) {
                if (!$(this).data('switchery-initialized')) {
                    new Switchery($(this)[0], $(this).data());
                    $(this).data('switchery-initialized', true);
                }
            });
        }

        // Initialize switchery on page load
        $(document).ready(function() {
            initializeSwitchery();
            
            // Handle chevron icon changes on collapse/expand
            $('.collapse').on('show.bs.collapse', function() {
                $(this).prev('.card-header').find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            });
            
            $('.collapse').on('hide.bs.collapse', function() {
                $(this).prev('.card-header').find('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            });
            
            // Re-initialize switchery when accordion items are shown (for any dynamically loaded content)
            $('.collapse').on('shown.bs.collapse', function () {
                setTimeout(function() {
                    initializeSwitchery();
                }, 100);
            });
        });
    </script>
@endsection