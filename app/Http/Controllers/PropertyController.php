<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Property\CreatePropertyService;
use App\Http\Services\Property\EditPropertyService;
use App\Http\Services\Property\DeletePropertyService;
use App\Http\Services\Property\GetPropertyDetailsService;
use App\Http\Services\Property\GetPackagesService;

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
        Request $request,
        GetPropertyDetailsService $getDetails
    )
    {
        $data = [];
        $data = $request->all();
        return $getDetails->handle($data);
    }

    /**
     * Get single product
     */
    public function single(
        GetPropertyDetailsService $getDetails,
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
        GetPropertyDetailsService $getDetails
    )
    {
        $data = $request->all();
        return $getDetails->handle($data);
    }

    /**
     * Get products as per meta
     */
    public function packages(
        Request $request,
        $id,
        GetPackagesService $getPackages
    )
    {
        $data = $request->all();
        $data['product_id'] = $id;
        return $getPackages->handle($data);
    }
}
