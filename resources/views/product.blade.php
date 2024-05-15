@extends('layout.layout')

@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{ isset($product) ? 'Update product' : 'Add product' }}</h3>
              </div>
              @if(isset($product))
              <form id="product_form" data-url="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
              @else
              <form id="product_form" data-url="{{ route('product.store') }}" enctype="multipart/form-data">
              @endif
                <div class="card-body">
                  <div class="form-group">
                    <label for="product_title">product Name</label>
                    <input type="text" class="form-control" id="product_title" name="product_title" placeholder="Enter product Name" value="{{ isset($product) ? $product->product_title : '' }}">
                  </div>
                  <div class="form-group">
                    <label for="product_description">Description</label>
                    <textarea class="form-control" id="product_description" name="product_description" placeholder="Enter product Description" rows="4">{{ isset($product) ? $product->product_description : '' }}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="product_image">Product Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="product_image" name="product_image">
                        <label class="custom-file-label" for="product_image">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="mt-2" id="imagePreview" style="display: none;">
                    <img src="" alt="product Logo" id="previewImage" style="max-width: 100px; max-height: 100px;">
                  </div>
                  @if(isset($product) && $product->product_image)
                  <div class="mt-2" id="imagePreviewAlreadyExist">
                    <img src="{{ asset('storage/product-mages/' . basename($product->product_image)) }}" alt="product Logo" style="max-width: 100px; max-height: 100px;">
                  </div>
                  @endif
                  <input type="" id="product_id" name="product_id" value="{{ isset($product) ? encrypt($product->id)  : '' }}">
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

@stop
