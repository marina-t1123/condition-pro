<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMEventRequest;
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
        return redirect()->route('m_event.index')->with('success', '種目マスタを登録しました');
    }

}
