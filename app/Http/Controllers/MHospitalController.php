<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchMHospitalRequest;
use App\Models\MHospital;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MHospitalController extends Controller
{
    /**
     * 病院マスタ一覧・検索
     *
     * @param \App\Http\Requests\SearchMHospitalRequest $request
     * @return \Inertia\Responce
     */
    public function index(SearchMHospitalRequest $request)
    {
        $mHospitals = MHospital::retrieveHospital($request)->get();

        return Inertia::render('MHospital/Index',[
            'm_hospitals' => $mHospitals
        ]);
    }

    /**
     * 病院マスタ新規作成
     *
     * @return \Inertia\Responce
     */
    public function create()
    {
        return Inertia::render('MHospital/Create', []);
    }

    public function store()
    {
        
    }
}
