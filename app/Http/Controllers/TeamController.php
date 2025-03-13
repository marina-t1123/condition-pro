<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchTeamRequest;
use App\Http\Requests\StoreTeamRequest;
use App\Models\Team;
use App\Models\MEvent;
use Inertia\Inertia;

class TeamController extends Controller
{
    // チーム一覧ページ表示
    public function index(SearchTeamRequest $request)
    {
        //検索情報を格納する
        $m_event_id = $request->input('m_event_id');
        // dd($m_event_id);
        $keyword = $request->input('team_name');

        $teams = Team::featchSerachItems($m_event_id, $keyword)->get();

        // 登録済みの種目を全権取得
        $m_events = MEvent::all();

        return Inertia::render('Team/Index', [
            'teams' => $teams,
            'm_events' => $m_events,
            'filters' => [ //検索条件の情報を保持するためにfilterオブジェクトを作成
                'team_name' => $keyword,
                'm_event_id' => $m_event_id
            ]
        ]);
    }

    // チーム登録画面表示
    public function create()
    {
        $m_events = MEvent::all();
        // dd($m_events);
        return Inertia::render('Team/Create', [
            'm_events' => $m_events,
        ]);
    }

    // チーム新規登録機能実装
    public function store(StoreTeamRequest $request)
    {
        // バリデーションした値を取得
        $validated = $request->validated();
        // バリデーションした値を使用して、新しくチームを作成
        $team = Team::create($validated);

        // リダイレクト時に新規登録メッセージを表示する
        return to_route('team.index')->with('message', '種目【'.$team->mEvent->event_name.'】にチーム【'.$team->team_name.'】を新規登録しました。');

    }

    // 編集ページ表示
    public function edit($m_event)
    {
        return Inertia::render('Team/Edit', [
            'm_event' => $m_event,
        ]);
    }
}
