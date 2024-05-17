<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ColorRequest;
use App\Traits\ResponseTrait;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\Crypt;
use App\Models\Product;



class ColorController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Color::select('*');
            return DataTables::of($data)
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'color';
        return view('color', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColorRequest $request)
    {
        try {
            $color = new Color($request->validated());
            $color->save();
            return $this->sendCreatedResponse('Color added successfully');

        } catch (\Throwable $th) {dd($th);
            return $this->sendErrorResponse('Something went wrong');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color, $id)
    {
        // dd($color);
        return $this->sendJsonResponse($color->findOrFail(Crypt::decrypt($id))->toArray(), 200, 'Retrieved successfully');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorRequest $request, Color $color, $id)
    {
        try {

            $data = $request->validated();
            $color = $color->findOrFail($id);
            $color->name = $data['edit_name'];
            $color->updated_at = now();
            $color->save();
            
            return $this->sendSuccessResponse('Product updated successfully');
        } catch (\Throwable $th) {dd($th);
            return $this->sendErrorResponse('Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color, $id)
    {
        try {
            $products = Product::whereJsonContains('color_ids', $id)->get();
            if ($products->isEmpty()) {
                Color::where('id', $id)->delete();
                return $this->sendSuccessResponse('Color deleted successfully');
            }
            return $this->sendErrorResponse('Color associated with a product');
        } catch (\Throwable $th) {
            return $this->sendErrorResponse('Something went wrong');
        }
        
    }
}
