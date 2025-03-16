<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchTeamRequest;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Models\MEvent;
use Inertia\Inertia;

class TeamController extends Controller
{
    /**
     * チーム一覧ページ表示
     *
     * @param SearchTeamRequest $request
     * @return \Inertia\Responce
     */
    public function index(SearchTeamRequest $request)
    {
        //検索情報を格納する
        $m_event_id = $request->input('m_event_id');
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

    /**
     * チーム新規作成
     *
     * @return \Inertia|Responce
     */
    public function create()
    {
        $m_events = MEvent::all();

        return Inertia::render('Team/Create', [
            'm_events' => $m_events,
        ]);
    }

    /**
     * チーム新規登録機能実装
     *
     * @param StoreTeamRequest $request
     * @return \Illuminate\Http\RedirectResponce
     */
    public function store(StoreTeamRequest $request)
    {
        // バリデーションした値を取得
        $validated = $request->validated();
        // バリデーションした値を使用して、新しくチームを作成
        $team = Team::create($validated);

        // リダイレクト時に新規登録メッセージを表示する
        return to_route('team.index')->with('message', '種目【' . $team->mEvent->event_name . '】にチーム【' . $team->team_name . '】を新規登録しました。');
    }

    /**
     * チーム詳細ページ表示
     *
     * @param string $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $team = Team::findOrFail($id);
        $m_event = $team->mEvent;

        return Inertia::render('Team/Show', [
            'team' => $team,
            'm_event' => $m_event
        ]);
    }

    /**
     * 編集ページ表示
     *
     * @param string $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        $m_event = $team->mEvent;

        return Inertia::render('Team/Edit', [
            'team' => $team,
            'm_event' => $m_event,
        ]);
    }

    /**
     * 更新処理
     *
     * @param UpdateTeamRequest $request
     * @var string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTeamRequest $request, $id)
    {
        //　バリデーション後の値を取得
        $validated = $request->validated();
        // バリデーション後の値を使用して、対象のteamの情報を更新する
        $team = Team::findOrFail($id);
        $team->update($validated);

        $m_event = $team->mEvent;

        // 詳細画面に更新メッセージと共にリダイレクト実施
        return redirect()->route('team.show', $id)->with('message', '種目【 ' . $m_event->event_name . ' 】の【 ' . $team->team_name . ' 】のチーム情報を更新しました。');
    }

    /**
     *  削除処理
     *
     * @var string $id
     * @return \Illuminate\Http|RedirectResponse
     */
    public function destroy($id)
    {
        dd($id);
        // チームに紐づく選手がいないかチェック、いたら「チームに所属する選手情報が登録されているため、削除できません」と表示

        // 選手に紐づく傷病情報もチェック。あった場合は選手に紐ずく傷病情報があるため、削除できません」と表示

        // 対象のチームを削除する
        $delete_team = Team::findOrFail($id);
        $delete_team_name = $delete_team->team_name;

        $delete_team->delete();

        return to_route('team.index')->with('message', 'チーム名【'.$delete_team_name.'】を削除しました。');
    }
}
