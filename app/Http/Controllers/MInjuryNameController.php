<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMInjuryNameRequest;
use App\Models\MInjuryName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MInjuryNameController extends Controller
{
    /**
     * 傷病名マスタ一覧表示
     *
     * @return \Inertia\Responce
     */
    public function index()
    {
        return Inertia::render('MInjuryName/Index', [
            'm_injury_names' =>  MInjuryName::getAllInjuryName()
        ]);
    }

    /**
     * 傷病名マスタ新規作成画面
     *
     * @return \Inertia\Responce
     */
    public function create()
    {
        return Inertia::render('MInjuryName/Create');
    }

    /**
     * 傷病名マスタ新規作成
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMInjuryNameRequest $request)
    {
        $validated = $request->validated();

        $createMInjuryName = MInjuryName::create($validated);

        return to_route('m_injury_name.index')->with('message', '【'.$createMInjuryName->injury_name.'】の傷病名マスタを作成しました。');
    }

}
