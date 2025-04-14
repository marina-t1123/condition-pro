<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchMHospitalRequest;
use App\Http\Requests\StoreMHospitalRequest;
use App\Models\MHospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $mHospitals = MHospital::retrieveHospitals($request);

        return Inertia::render('MHospital/Index',[
            'm_hospitals' => $mHospitals
        ]);
    }

    /**
     * 病院マスタ新規登録画面
     *
     * @return \Inertia\Responce
     */
    public function create()
    {
        return Inertia::render('MHospital/Create', []);
    }

    /**
     * 病院マスタ新規登録機能
     */
    public function store(StoreMHospitalRequest $storeMHospitalRequest)
    {
        // バリデーション後の値を取得
        // $storeMHospitalRequest->validated();

        // トランザクションを設定して、リクエストパラメータを使用して病院マスタの新規登録を実施する
        $mHospital = DB::transaction(function () use ($storeMHospitalRequest) {
            $mHospital = MHospital::create([
                'hospital_name' => $storeMHospitalRequest->input('hospital_name')
            ]);

            return $mHospital;
        });

        // リダイレクト時に新規登録メッセージを表示
        return to_route('m_hospital.index')->with('message', '【'.$mHospital->hospital_name.'】の病院マスタを登録しました。');


    }
}
