<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Property\CreatePropertyService;
use App\Http\Services\Property\EditPropertyService;
use App\Http\Services\Property\DeletePropertyService;

class PropertyController extends Controller
{
    /**
     * Add Product
     */
    public function create(
        Request $request,
        CreatePropertyService $addProperty
    )
    {
        $data = $request->all();
        return $addProperty->handle($data);
    }

    public function edit(
        Request $request,
        EditPropertyService $editProperty
    )
    {
        $data = $request->all();
        return $editProperty->handle($data);
    }

    public function delete(
        DeletePropertyService $deleteProperty,
        $id
    )
    {
        return $deleteProperty->handle($id);
    }
}
