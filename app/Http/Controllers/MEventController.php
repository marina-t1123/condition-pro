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
        MEvent::create($validated);

        // 種目マスタ一覧画面のルーティングを指定して、リダイレクトさせる
        // return redirect()->route('m_event.index')->with('message', '種目マスタを登録しました');
        return to_route('m_event.index')->with('message', '種目マスタを登録しました');
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
        return to_route('m_event.index')->with('message', '種目マスタを更新しました');
    }

}
