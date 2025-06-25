@extends('backend.master')

@section('header_css')
    <link href="{{url('assets')}}/plugins/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets')}}/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets')}}/css/tagsinput.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .select2-selection{
            height: 34px !important;
            border: 1px solid #ced4da !important;
        }
        .select2 {
            width: 100% !important;
        }
        .bootstrap-tagsinput .badge {
            margin: 2px 2px !important;
        }

        .product-card-title .card-title::before{
            top: 13px
        }
    </style>
@endsection

@section('page_title')
    Package Product
@endsection
@section('page_heading')
    Edit Package Product
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">

                    <form class="needs-validation" method="POST" action="{{url('package-products/' . $product->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row border-bottom mb-4 pb-2">
                            <div class="col-lg-6 product-card-title">
                                <h4 class="card-title mb-3" style="font-size: 18px; padding-top: 12px;">Edit Package Product</h4>
                            </div>
                            <div class="col-lg-6 text-right">
                                <a href="{{ url('package-products') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                                <a href="{{ url('package-products/' . $product->id . '/manage-items') }}" class="btn btn-info">
                                    <i class="fas fa-list"></i> Manage Items
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Package Image</h5>
                                        <div class="form-group">
                                            <label for="image">Package Image</label>
                                            <input type="file" name="image" class="dropify" data-height="200" data-max-file-size="1M" accept="image/*"/>
                                            <div class="invalid-feedback" style="display: block;">
                                                @error('image')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                        @if($product->image)
                                            <div class="text-center mt-2">
                                                <img src="{{ url( $product->image) }}" class="img-fluid" style="max-height: 200px;">
                                                <p class="text-muted mt-1">Current Image</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Basic Information</h5>
                                        
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name">Package Name <span class="text-danger">*</span></label>
                                                    <input type="text" id="name" name="name" maxlength="255" class="form-control" placeholder="Enter Package Product Name Here" value="{{ old('name', $product->name) }}">
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('name')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="name">Stock <span class="text-danger">*</span></label>
                                                    <input type="number" id="stock" name="stock" min="1" class="form-control" value="{{ old('stock', $product->stock) }}">
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('stock')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="name">Low Stock <span class="text-danger">*</span></label>
                                                    <input type="number" id="low_stock" name="low_stock" min="1" class="form-control" value="{{ old('low_stock', $product->low_stock) }}">
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('low_stock')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="category_id">Category<span class="text-danger">*</span></label>
                                                    <select name="category_id" data-toggle="select2" class="form-control" id="category_id" required>
                                                        @php
                                                            echo App\Models\Category::getDropDownList('name', old('category_id', $product->category_id));
                                                        @endphp
                                                    </select>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('category_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="subcategory_id">Subcategory</label>
                                                    <select name="subcategory_id" data-toggle="select2" class="form-control" id="subcategory_id">
                                                        <option value="">Select Subcategory</option>
                                                        @foreach($subcategories as $subcategory)
                                                            <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                                                {{ $subcategory->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('subcategory_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="childcategory_id">Child Category</label>
                                                    <select name="childcategory_id" data-toggle="select2" class="form-control" id="childcategory_id">
                                                        <option value="">Select Child Category</option>
                                                        @foreach($childcategories as $childcategory)
                                                            <option value="{{ $childcategory->id }}" {{ old('childcategory_id', $product->childcategory_id) == $childcategory->id ? 'selected' : '' }}>
                                                                {{ $childcategory->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('childcategory_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="brand_id">Brand</label>
                                                    <select name="brand_id" data-toggle="select2" class="form-control" id="brand_id">
                                                        @php
                                                            echo App\Models\Brand::getDropDownList('name', old('brand_id', $product->brand_id));
                                                        @endphp
                                                    </select>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('brand_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="price">Package Price <span class="text-danger">*</span></label>
                                                    <input type="number" id="price" name="price" step="0.01" min="0" class="form-control" placeholder="0.00" value="{{ old('price', $product->price) }}" required>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('price')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="discount_price">Discount Price</label>
                                                    <input type="number" id="discount_price" name="discount_price" step="0.01" min="0" class="form-control" placeholder="0.00" value="{{ old('discount_price', $product->discount_price) }}">
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('discount_price')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="unit_id">Unit</label>
                                                    <select name="unit_id" data-toggle="select2" class="form-control" id="unit_id">
                                                        @php
                                                            echo App\Models\Unit::getDropDownList('name', old('unit_id', $product->unit_id));
                                                        @endphp
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="status">Status <span class="text-danger">*</span></label>
                                                    <select name="status" class="form-control" id="status" required>
                                                        <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Package Description</h5>
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="short_description">Short Description</label>
                                            <textarea id="short_description" name="short_description" maxlength="1000" class="form-control" rows="3" placeholder="Write Package Short Description Here">{{ old('short_description', $product->short_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea id="description" name="description" class="form-control" placeholder="Write Package Description Here">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="tags">Tags</label>
                                            <input type="text" id="tags" name="tags" class="form-control" data-role="tagsinput" placeholder="Enter Tags" value="{{ old('tags', $product->tags) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">SEO Information</h5>
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" id="meta_title" name="meta_title" maxlength="255" class="form-control" placeholder="Enter Meta Title" value="{{ old('meta_title', $product->meta_title) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <input type="text" id="meta_keywords" name="meta_keywords" class="form-control" data-role="tagsinput" placeholder="Enter Meta Keywords" value="{{ old('meta_keywords', $product->meta_keywords) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea id="meta_description" name="meta_description" maxlength="500" class="form-control" rows="3" placeholder="Enter Meta Description">{{ old('meta_description', $product->meta_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center pt-3">
                            <a href="{{url('package-products')}}" style="width: 130px;" class="btn btn-danger d-inline-block text-white m-2" type="submit"><i class="mdi mdi-cancel"></i> Cancel</a>
                            <button class="btn btn-primary m-2" style="width: 180px;" type="submit"><i class="fas fa-save"></i> Update Package</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="{{url('assets')}}/plugins/dropify/dropify.min.js"></script>
    <script src="{{url('assets')}}/pages/fileuploads-demo.js"></script>
    <script src="{{url('assets')}}/plugins/select2/select2.min.js"></script>
    <script src="{{url('assets')}}/js/tagsinput.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('[data-toggle="select2"]').select2();

        $('#description').summernote({
            placeholder: 'Write Package Description Here',
            tabsize: 2,
            height: 300
        });

        // Category wise subcategory
        $(document).ready(function () {
            $('#category_id').on('change', function () {
                var categoryId = this.value;
                $("#subcategory_id").html('');
                $("#childcategory_id").html('');
                $.ajax({
                    url: "{{url('/category/wise/subcategory')}}",
                    type: "POST",
                    data: {
                        category_id: categoryId,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#subcategory_id').html('<option value="">Select Subcategory</option>');
                        $('#childcategory_id').html('<option value="">Select Child Category</option>');
                        $.each(result, function (key, value) {
                            $("#subcategory_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });

        // Subcategory wise child category
        $(document).ready(function () {
            $('#subcategory_id').on('change', function () {
                var subCategoryId = this.value;
                $("#childcategory_id").html('');
                $.ajax({
                    url: "{{url('/subcategory/wise/childcategory')}}",
                    type: "POST",
                    data: {
                        subcategory_id: subCategoryId,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#childcategory_id').html('<option value="">Select Child Category</option>');
                        $.each(result, function (key, value) {
                            $("#childcategory_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });

        // Set current image in dropify
        // @if($product->image && file_exists(public_path('productImages/' . $product->image)))
        //     $(".dropify-preview").eq(0).css("display", "block");
        //     $(".dropify-clear").eq(0).css("display", "block");
        //     $(".dropify-filename-inner").eq(0).html("{{$product->image}}");
        //     $("span.dropify-render").eq(0).html("<img src='{{url('productImages/' . $product->image)}}'>");
        // @endif
    </script>
@endsection
