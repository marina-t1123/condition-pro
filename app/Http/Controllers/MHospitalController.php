<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchMHospitalRequest;
use App\Models\MHospital;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MHospitalController extends Controller
{
    public function index(SearchMHospitalRequest $request)
    {
        $mHospitals = MHospital::retrieveHospital($request)->get();

        return Inertia::render('MHospital/Index',[
            'm_hospitals' => $mHospitals
        ]);
    }

    public function create()
    {

    }

    public function store()
    {

    }
}
