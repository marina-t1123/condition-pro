<?php

namespace App\Http\Controllers;

use App\Models\MEventPosition;
use App\Models\MEvent;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMEventPositionRequest;
use App\Http\Requests\UpdateMEventPositionRequest;
use Inertia\Inertia;

class MEventPositionController extends Controller
{
    // 種目ポジションマスタ一覧表示・検索
    public function index(Request $request)
    {
        // 検索ID取得
        $search_id = $request->input('event_id');

        if(!empty($search_id)) {
            $query = MEventPosition::query();
            $m_event_positions = $query->with(['mEvent'])->whereHas('mEvent', function ($q) use ($search_id) {
                $q->where('id', $search_id);
            })->get();
            // dd($m_event_positions);
        } else {
            $m_event_positions = MEventPosition::with('mEvent')->get();
        }
        // 登録済みの種目マスタを取得する
        $m_events = MEvent::all();

        return Inertia::render('MEventPosition/Index', [
            'm_event_positions' => $m_event_positions,
            'm_events' => $m_events
        ]);
    }


    // 種目ポジションマスタ作成ページ
    public function create() {
        // 登録済みの種目マスタ取得
        $m_events = MEvent::all();

        return Inertia::render('MEventPosition/Create', [
            'm_events' => $m_events
        ]);
    }


    // 種目ポジションマスタ作成
    public function store(StoreMEventPositionRequest $request) {

        // バリデーション済みのデータを取得
        $validated = $request->validated();

        $m_event_position =  MEventPosition::create($validated);

        $m_event = MEvent::findOrFail($m_event_position->m_event_id);

        return to_route('m_event_position.index')->with('message', '種目名【'.$m_event->event_name.'】に【'.$m_event_position->event_position_name.'】の情報を登録しました');
    }


    // 種目ポジションマスタ編集ページ
    public function edit($id)
    {
        $m_event_position = MEventPosition::findOrFail($id);
        $m_event = $m_event_position->mEvent;

        return Inertia::render('MEventPosition/Edit', [
            'm_event' => $m_event,
            'm_event_position' => $m_event_position
        ]);
    }

    // 種目ポジションマスタ更新
    public function update(UpdateMEventPositionRequest $request, $id)
    {
        // 対象のポジション・種目マスタを取得する
        $m_event_position = MEventPosition::findOrFail($id);

        // ポジションに紐づく種目マスタを取得
        $m_event = $m_event_position->mEvent;

        //バリデーション後の値を取得
        $validated = $request->validated();

        // 対象のポジション・階級マスタの名前を更新する
        $m_event_position->update([
            'event_position_name' => $validated['event_position_name']
        ]);

        // リダイレクト処理で一覧画面にリダイレクトさせる
        return to_route('m_event_position.index')->with('message', '種目名【'.$m_event->event_name.'】のポジション・階級名【'.$m_event_position->event_position_name.'】を更新しました。');
    }


    // 種目ポジションマスタ削除
    public function destroy($id)
    {

        // 削除対象の種目ポジションマスタを取得
        $m_event_position = MEventPosition::findOrFail($id);

        $destroy_position_name = $m_event_position->event_position_name;
        $m_event = $m_event_position->mEvent;

        $m_event_position->delete();

        // 一覧画面にリダイレクトする
        return to_route('m_event_position.index')->with('message', '種目【'.$m_event->event_name.'】のポジション・階級【'.$destroy_position_name.'】を削除しました。');
    }

}
