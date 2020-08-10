<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Company\AddCompanyService;
use App\Http\Services\Company\InviteToTeamService;
use App\Http\Services\Company\AddTeamInfoService;
use App\Http\Services\Company\ManageService;


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

    public function invite(
        Request $request,
        InviteToTeamService $invite
    )
    {
        $data = $request->all();
        return $invite->handle($data);
    }

    public function manage(
        Request $request,
        ManageService $manage
    )
    {
        $data = $request->all();
        return $manage->handle($data);
    }


}
