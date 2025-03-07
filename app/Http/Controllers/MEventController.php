<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMEventRequest;
use App\Http\Requests\UpdateMEventRequest;
use App\Models\MEvent;
// use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MEventController extends Controller
{
    // 種目マスタ一覧ページ表示
    public function index()
    {
        $m_events = MEvent::all();

        return Inertia::render('MEvent/Index', [
            'm_events' => $m_events,
        ]);
    }

    // 新規登録画面表示
    public function create()
    {
        return Inertia::render('MEvent/Create', []);
    }

    // 登録処理
    public function store(StoreMEventRequest $request)
    {
        // dd('storeメソッド実行されている');
        // バリデーション済みのデータを取得
        $validated = $request->validated();

        // バリデーション済みの入力データを使用して、新しい種目マスタモデルをインスタンス化する
        $m_event = MEvent::create($validated);

        // 種目名を取得
        $event_name = $m_event->event_name;

        // 種目マスタ一覧画面のルーティングを指定して、リダイレクトさせる
        return to_route('m_event.index')->with('message', '種目マスタ【 '.$event_name.' 】を登録しました');
    }

    // 更新画面表示
    public function edit($id)
    {
        $m_event = MEvent::findOrFail($id);

        // dd($m_event);
        return Inertia::render('MEvent/Edit', [
            'm_event' => $m_event
        ]);
    }

    // 更新処理
    public function update(UpdateMEventRequest $request, string $id)
    {
        // dd('updateアクション処理開始');
        $validatedData = $request->validated();

        $m_event = MEvent::findOrFail($id);
        $m_event->update($validatedData);

        // return redirect()->route('m_event.index')->with('message', '種目マスタを更新しました');
        return to_route('m_event.index')->with('message', '種目マスタ【 '.$m_event->event_name.' 】を更新しました');
    }

    // 削除処理
    public function destroy(string $id)
    {
        // 削除対象の種目マスタを取得
        $m_event = MEvent::findOrFail($id);

        // 削除する種目マスタの種目名を取得する
        $delete_event_name = $m_event->event_name;

        // 種目マスタに紐ずくチームの有無

        // チームに紐ずく選手の有無

        // 選手に紐ずく傷病情報の有無

        // マスタに紐ずくチーム・選手・傷病情報がなかった場合、削除を実施
        $m_event->delete();

        // リダイレクト処理
        return redirect()->route('m_event.index')->with('message', '種目名【 '.$delete_event_name.' 】を削除しました');
    }

}
