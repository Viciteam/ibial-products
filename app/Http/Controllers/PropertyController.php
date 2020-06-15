<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Property\CreatePropertyService;
use App\Http\Services\Property\EditPropertyService;
use App\Http\Services\Property\DeletePropertyService;
use App\Http\Services\Property\GetPropertyDetails;

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

    /**
     * Edit Product
     */
    public function edit(
        Request $request,
        EditPropertyService $editProperty
    )
    {
        $data = $request->all();
        return $editProperty->handle($data);
    }

    /**
     * Delete Product
     */
    public function delete(
        DeletePropertyService $deleteProperty,
        $id
    )
    {
        return $deleteProperty->handle($id);
    }

    /**
     * Get all Products
     */
    public function all(
        GetPropertyDetails $getDetails
    )
    {
        $data = [];
        return $getDetails->handle($data);
    }

    /**
     * Get single product
     */
    public function single(
        GetPropertyDetails $getDetails,
        $id
    )
    {
        $data = [];
        $data['product_id'] = $id;
        return $getDetails->handle($data);
    }

    /**
     * Get products as per meta
     */
    public function meta(
        Request $request,
        GetPropertyDetails $getDetails
    )
    {
        $data = $request->all();
        return $getDetails->handle($data);
    }
}
