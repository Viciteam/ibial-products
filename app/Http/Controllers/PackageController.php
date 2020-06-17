<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Packages\CreatePackageService;
use App\Http\Services\Packages\GetPackageService;


class PackageController extends Controller
{
    /**
     * Add Package
     */
    public function create(
        Request $request,
        CreatePackageService $addPackage
    )
    {
        $data = $request->all();
        return $addPackage->handle($data);
    }

    /**
     * Get package info
     */
    public function info(
        GetPackageService $getPackages,
        $product_id
    )
    {
        return $getPackages->handle($product_id);
    }

    



}
