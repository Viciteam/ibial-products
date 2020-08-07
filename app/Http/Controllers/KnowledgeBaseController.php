<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\KB\AddEntryService;
use App\Http\Services\KB\EditEntryService;
use App\Http\Services\KB\DeactivateEntryService;


class KnowledgeBaseController extends Controller
{
    /**
     * Add Package
     */
    public function insert(
        Request $request,
        AddEntryService $add
    )
    {
        $data = $request->all();
        return $add->handle($data);
    }

    public function edit(
        Request $request,
        EditEntryService $edit
    )
    {
        $data = $request->all();
        return $edit->handle($data);
    }

    public function deactive(
        Request $request,
        DeactivateEntryService $deactivate
    )
    {
        $data = $request->all();
        return $deactivate->handle($data);
    }

}
