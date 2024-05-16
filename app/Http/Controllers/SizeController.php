<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SizeRequest;
use App\Traits\ResponseTrait;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\Crypt;


class SizeController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Size::select('*');
            return DataTables::of($data)
            ->addColumn('encriptedId', function ($size) {
                return Crypt::encrypt($size->id);
            })
            ->addColumn('created_at', function ($size) {
                return $formattedCreatedAt = $size->created_at->format('Y-m-d h:i A');
            })
            ->addColumn('updated_at', function ($size) {
                return $formattedCreatedAt = $size->updated_at->format('Y-m-d h:i A');
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'size';
        return view('size', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SizeRequest $request)
    {
        try {
            $color = new Size($request->validated());
            $color->save();
            return $this->sendCreatedResponse('Size added successfully');

        } catch (\Throwable $th) {dd($th);
            return $this->sendErrorResponse('Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size, $id)
    {
        return $this->sendJsonResponse($size->findOrFail(Crypt::decrypt($id))->toArray(), 200, 'Retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        //
    }
}