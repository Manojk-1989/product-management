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


class ProductController extends Controller
{
    use FileUploadTrait, ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $data = Product::with('colors')->get(); 
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
        return view('product-list', compact('page')); 
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colors = Color::get();
        $sizes = Size::get();
        $page = 'product';
        return view('product',compact('page', 'colors', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->validated();
            // $logoPath = $request->file('company_logo')->store('logos', 'public');
            $productImage = $this->imageUpload($request->file('product_image'), 'product-images');

            if ($productImage) {
                $product = new Product([
                    'product_title' => $data['product_title'],
                    'product_description' => $data['product_description'],
                    'product_image' => $productImage,
                    'color_ids' => $data['color_ids'], // Assuming color_ids is sent as an array from the form
                'size_ids' => $data['size_ids'],
                ]);
                $product->save();

                return $this->sendCreatedResponse('Product created successfully');
            }

            

            return $this->sendErrorResponse('Product image upload failed');
        } catch (\Throwable $th) {dd($th);
            return $this->sendErrorResponse('Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, $id)
    {
        return view('product', ['product' => $product->findOrFail(Crypt::decrypt($id)),
         'page' => 'product',
        'colors' => Color::get(),
        'sizes' => Size::get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product, $id)
    {
        try {
            $product = $product->findOrFail(decrypt($id));

            if ($request->hasFile('product_image')) {
                Storage::disk('public')->delete($product->company_logo);
                $productImage = $this->imageUpload($request->file('product_image'), 'product-images');
                $product->product_image = $productImage;
            }

            $product->product_title = $request->product_title;
            $product->product_description = $request->product_description;
            $product->color_ids = $request->color_ids;
            $product->size_ids = $request->size_ids;
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
    public function destroy(Product $product)
    {
        //
    }
}
