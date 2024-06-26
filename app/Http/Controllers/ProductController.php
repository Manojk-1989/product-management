<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Traits\FileUploadTrait;
use App\Traits\ResponseTrait;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\Crypt;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use FileUploadTrait, ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::get();
            return DataTables::of($data)
            ->addColumn('image', function ($product) {
                $imageUrl = asset('storage/' . $product->product_image);
                return $imageUrl;
            })
            ->addColumn('encriptedId', function ($product) {
                return Crypt::encrypt($product->id);
            })
            ->addColumn('created_at', function ($product) {
                return $formattedCreatedAt = $product->created_at->format('Y-m-d h:i A');
            })
            ->addColumn('updated_at', function ($product) {
                return $formattedCreatedAt = $product->updated_at->format('Y-m-d h:i A');
            })
            ->addColumn('colors', function ($product) {
                $colors = Color::whereIn('id', $product->color_ids)->pluck('name')->toArray();
                return implode(', ', $colors);
            })
            ->addColumn('sizes', function ($product) {
                $sizes = Size::whereIn('id', $product->size_ids)->pluck('name')->toArray();
                return implode(', ', $sizes);
            })
            ->make(true);
        }
        $page = 'product-list';
        $pageTitle = 'Product List';
        return view('pages.product-list', compact('page', 'pageTitle')); 
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colors = Color::get();
        $sizes = Size::get();
        $page = 'product';
        $pageTitle = 'Add New Product';
        return view('pages.product',compact('page', 'colors', 'sizes', 'pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->validated();

            // Upload the product image file obtained from the request
            // The image is uploaded to this path storage/app/public/product-images 
            // imageUpload method, passing the file and the destination directory as arguments
            $productImage = $this->imageUpload($request->file('product_image'), 'product-images');

            if ($productImage) {
                $product = new Product([
                    'product_title' => $data['product_title'],
                    'product_description' => $data['product_description'],
                    'product_image' => $productImage,
                    'color_ids' => $data['color_ids'], 
                    'size_ids' => $data['size_ids'],
                ]);
                $product->save();

                return $this->sendCreatedResponse('Product created successfully');
            }

            return $this->sendErrorResponse('Product image upload failed');
        } catch (\Throwable $th) {
            return $this->sendErrorResponse('Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, $id)
    {
        $product = $product->findOrFail(Crypt::decrypt($id));
        $colors = Color::whereIn('id', $product->color_ids)->pluck('name')->toArray();
        $sizes = Size::whereIn('id', $product->size_ids)->pluck('name')->toArray();

        return view('pages.product-details',['product' => $product,'colors' => $colors, 'sizes' => $sizes, 'page'=>'product-details', 'pageTitle' => 'Product Details',]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, $id)
    {
        return view('pages.product', ['product' => $product->findOrFail(Crypt::decrypt($id)),
         'page' => 'product', 'pageTitle' => 'Edit Product',
        'colors' => Color::get(),
        'sizes' => Size::get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product, $id)
    {
        try {

            $data = $request->validated();
            
            $product = $product->findOrFail(decrypt($id));
            
            // Checks if a product image file exist in the request
            // If exist delete the existing product image from the directory and replace it with the new one
            // Uploads the new product image file using imageUpload method
            // Assign the new product image path to the product model

            if ($request->hasFile('product_image')) {
                Storage::disk('public')->delete($product->product_image);
                $productImage = $this->imageUpload($request->file('product_image'), 'product-images');
                if (!$productImage) {
                    return $this->sendErrorResponse('Product image upload failed');
                }
                $product->product_image = $productImage;
            }

            $product->product_title = $data['product_title'];
            $product->product_description = $data['product_description'];
            $product->color_ids = $data['color_ids'];
            $product->size_ids = $data['size_ids'];
            $product->updated_at = now();
            $product->save();
            
            return $this->sendSuccessResponse('Product updated successfully');
        } catch (\Throwable $th) {
            return $this->sendErrorResponse('Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, $id)
    {
        try {
            $product = $product->findOrFail(decrypt($id));
            if ($product->product_image) {
                Storage::disk('public')->delete($product->product_image);
            }
            
            $product->delete();
            return $this->sendSuccessResponse('Product deleted successfully');
        } catch (\Throwable $th) {
            return $this->sendErrorResponse('Something went wrong');
        }
    }
}
