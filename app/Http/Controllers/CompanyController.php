<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Company\AddCompanyService;
use App\Http\Services\Company\AddTeamInfoService;


class CompanyController extends Controller
{
    /**
     * Add Package
     */
    public function insert(
        Request $request,
        AddCompanyService $add
    )
    {
        $data = $request->all();
        return $add->handle($data);
    }

    public function addTeam(
        Request $request,
        AddTeamInfoService $addteam
    )
    {
        $data = $request->all();
        return $addteam->handle($data);
    }


}
