@extends('layout.layout')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ isset($product) ? 'Update Color' : 'Add Color' }}</h3>
                    </div>
                    @if(isset($color))
                    <form id="color_form" data-url="{{ route('color.update', $product->id) }}" enctype="multipart/form-data">
                    @else
                    <form id="color_form" data-url="{{ route('color.store') }}" enctype="multipart/form-data">
                    @endif
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Color Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Color Name" value="{{ isset($color) ? $color->name : '' }}">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Color List</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="color-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('share.modal')

@stop
