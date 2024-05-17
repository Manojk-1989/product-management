@extends('layout.layout')

@section('content')

<section class="content">
    <!-- Default box -->
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3 class="d-inline-block d-sm-none">{{ $product->product_title }}</h3>
                    <div class="col-12">
                        <img src="{{ asset('storage/product-images/' . basename($product->product_image)) }}" class="product-image" alt="Product Image">
                    </div>
                    <div class="col-12 product-image-thumbs">
                        <div class="product-image-thumb active"><img src="{{ asset('storage/product-images/' . basename($product->product_image)) }}" alt="Product Image"></div>
                        <div class="product-image-thumb"><img src="{{ asset('storage/product-images/' . basename($product->product_image)) }}" alt="Product Image"></div>
                        <div class="product-image-thumb"><img src="{{ asset('storage/product-images/' . basename($product->product_image)) }}" alt="Product Image"></div>
                        <div class="product-image-thumb"><img src="{{ asset('storage/product-images/' . basename($product->product_image)) }}" alt="Product Image"></div>
                        <div class="product-image-thumb"><img src="{{ asset('storage/product-images/' . basename($product->product_image)) }}" alt="Product Image"></div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="my-3">{{ $product->product_title }}</h3>
                    @php
                        $descriptionLines = explode("\n", $product->product_description);
                        $shortDescription = implode("\n", array_slice($descriptionLines, 0, 3));
                    @endphp
                    <p>{!! nl2br(e($shortDescription)) !!}</p>
                    <hr>
                    <h4>Available Colors</h4>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        @foreach($colors as $color)
                            <label class="btn btn-default text-center active">
                                <input type="radio" name="color_option" id="color_option_a1" autocomplete="off" checked>
                                {{ $color }}
                                <br>
                                <i class="fas fa-circle fa-2x text-green"></i>
                            </label>
                        @endforeach
                    </div>

                    <h4 class="mt-3">Available Sizes</h4>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        @foreach($sizes as $size)
                            <label class="btn btn-default text-center">
                                <input type="radio" name="color_option" id="color_option_b1" autocomplete="off">
                                <br>
                                {{ $size }}
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-4 product-share">
                        <a href="#" class="text-gray">
                            <i class="fab fa-facebook-square fa-2x"></i>
                        </a>
                        <a href="#" class="text-gray">
                            <i class="fab fa-twitter-square fa-2x"></i>
                        </a>
                        <a href="#" class="text-gray">
                            <i class="fas fa-envelope-square fa-2x"></i>
                        </a>
                        <a href="#" class="text-gray">
                            <i class="fas fa-rss-square fa-2x"></i>
                        </a>
                    </div>

                </div>
            </div>
            <div class="row mt-4">
                <nav class="w-100">
                    <div class="nav nav-tabs" id="product-tab" role="tablist">
                        <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                    </div>
                </nav>
                <div class="tab-content p-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">{{ $product->product_description }}.</div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>

@stop
