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



class ProductController extends Controller
{
    use FileUploadTrait, ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('*');
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
        $page = 'product';
        return view('product',compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // dd($request->validated());
        try {
            $data = $request->validated();
            // $logoPath = $request->file('company_logo')->store('logos', 'public');
            $productImage = $this->imageUpload($request->file('product_image'), 'product-images');

            if ($productImage) {
                $product = new Product([
                    'product_title' => $data['product_title'],
                    'product_description' => $data['product_description'],
                    'product_image' => $productImage,
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
        return view('product', ['product' => $product->findOrFail(Crypt::decrypt($id)), 'page' => 'product']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, $id)
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
