<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\MEvent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AthleteController extends Controller
{
    /**
     * 選手一覧画面
     */
    public function index()
    {
        // 検索フォームでの検索ワード(バリデーション済み)を取得する(後ほど)

        // 現在の登録済みの各選手に紐ずく情報(チーム・ポジション・種目・性別情報)を取得する
        $athletes = Athlete::with(['team', 'sex', 'mEventPositions.mEvent'])->get();

        // 種目・種目に紐ずくポジションの情報を取得する
        $m_events = MEvent::getAllMEventAndPositions()->get();

        // リダイレクト処理
        return Inertia::render('Athlete/Index', [
            'athletes' => $athletes,
            'm_events' => $m_events
        ]);
    }

    /**
     * 各チームの選手一覧
     */
    public function showRespectiveTeam()
    {

    }

    /**
     * 選手登録画面
     */
    public function create()
    {

    }

    /**
     * 選手登録
     */
    public function store()
    {

    }

    /**
     * 選手詳細画面
     */
    public function show()
    {

    }

    /**
     * 選手編集画面
     */
    public function edit()
    {

    }

    /**
     * 選手編集
     */
    public function update()
    {

    }

    /**
     * 選手削除
     */
    public function destroy()
    {

    }

}
