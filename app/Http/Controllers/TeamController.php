<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\SearchTeamRequest;
use App\Models\Team;
use App\Models\MEvent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Unertia\Response;

class TeamController extends Controller
{
    // 選手一覧ページ表示
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

    // 選手登録画面表示
    public function create()
    {
        return Inertia::render('Team/Create');
    }

    // 編集ページ表示
    public function edit($m_event)
    {
        return Inertia::render('Team/Edit', [
            'm_event' => $m_event,
        ]);
    }
}
