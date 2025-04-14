<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchMHospitalRequest;
use App\Http\Requests\StoreMHospitalRequest;
use App\Http\Requests\UpdateMHospitalRequest;
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

    /**
     * 病院マスタ編集画面
     *
     * @param int $mHospitalId
     * @return \Inertia\Responce
     */
    public function edit($mHospitalId) {
        return Inertia::render('MHospital/Edit', [
            'm_hospital' => MHospital::getHospitalSpecifiedId($mHospitalId)
        ]);
    }

    /**
     * 病院マスタ更新
     *
     * @param App\Http\Requests\UpdateMHospitalRequest
     * @param int $mHospitalId
     * @return \Illuminate\Http\RedirectResponce
     */
    public function update(UpdateMHospitalRequest $request, $mHospitalId) {
        $updateMHospital = MHospital::getHospitalSpecifiedId($mHospitalId);

        $updateMHospital->update([
            'hospital_name' => $request->input('hospital_name')
        ]);

        return to_route('m_hospital.index')->with('message', '【'.$updateMHospital->hospital_name.'】に更新しました。');
    }

    /**
     *  病院マスタ削除
     *
     * @param int $mHospitalId
     * @return \Illuminate\Http\RedirectResponce
     */
    public function destroy($mHospitalId) {
        $deleteHospital = MHospital::getHospitalSpecifiedId($mHospitalId);
        $deleteHospitalName = $deleteHospital->hospital_name;

        $deleteHospital->delete();

        return to_route('m_hospital.index')->with('message', '【'.$deleteHospitalName.'】を削除しました。');
    }
}
