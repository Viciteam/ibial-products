<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

use App\Http\Services\Company\AddCompanyService;
use App\Http\Services\Company\InviteToTeamService;
use App\Http\Services\Company\UnInviteToTeamService;
use App\Http\Services\Company\AddTeamInfoService;
use App\Http\Services\Company\ManageService;
use App\Http\Services\Company\MembersService;
use App\Http\Services\Company\SuggestedService;


class CompanyController extends BaseController
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

    public function uninvite(
        Request $request,
        UnInviteToTeamService $uninvite
    )
    {
        $data = $request->all();
        return $uninvite->handle($data);
    }

    public function manage(
        Request $request,
        ManageService $manage
    )
    {
        $data = $request->all();
        return $manage->handle($data);
    }

    // getter
    public function members(
        Request $request,
        MembersService $members
    )
    {
        $data = $request->all();
        return $members->handle($data);
    }

    public function suggest(
        Request $request,
        SuggestedService $suggested
    )
    {
        $data = $request->all();
        return $suggested->handle($data);
    }
}
