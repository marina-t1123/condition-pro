<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMInjuryNameRequest;
use App\Http\Requests\UpdateMInjuryNameRequest;
use App\Http\Requests\SearchMInjuryNameRequest;
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
    public function index(SearchMInjuryNameRequest $request)
    {
        $searchInjuryNames = MInjuryName::retrieveMInjuryNames($request->injury_name);
        $mInjuryNames = $searchInjuryNames->get();

        return Inertia::render('MInjuryName/Index', [
            'm_injury_names' => $mInjuryNames
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

    /**
     * 傷病名マスタ編集
     *
     * @return \Inertia\Responce
     */
    public function edit($injuryNameId)
    {
        $mInjuryName = MInjuryName::findOrFail($injuryNameId);
        return Inertia::render('MInjuryName/Edit', [
            'm_injury_name' => $mInjuryName
        ]);
    }

    /**
     * 傷病名マスタ更新
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateMInjuryNameRequest $request,$injuryNameId)
    {
        $validated = $request->validated();
        $mInjuryName = MInjuryName::findOrFail($injuryNameId);

        $mInjuryName->update($validated);

        return to_route('m_injury_name.index')->with('message', '【'.$mInjuryName->injury_name.'】 を更新しました。');
    }

    /**
     * 傷病名マスタ削除
     *
     * 傷病情報機能を実装した際に、作成された傷病情報に傷病名マスタが使用されている場合は、削除できないようにする処理を実装する必要あり。
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($injuryNameId)
    {
        $mInjuryName = MInjuryName::findOrFail($injuryNameId);

        $deleteInjuryName = $mInjuryName->injury_name;

        $mInjuryName->delete();

        return to_route('m_injury_name.index')->with('message', '【'.$deleteInjuryName.'】を削除しました。');
    }

}
