<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchAthleteRequest;
use App\Http\Requests\StoreAthleteRequest;
use App\Http\Requests\UpdateAthleteRequest;
use App\Models\Athlete;
use App\Models\MEvent;
use App\Models\MEventPosition;
use App\Models\PlayerPosition;
use App\Models\Sex;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AthleteController extends Controller
{
    /**
     * 選手一覧画面
     *
     * @var string $search_name
     * @var interger $search_event_id
     * @var interger $search_position_id
     */
    public function index(Request $request)
    {
        $team_id = null;
        // ↓検索機能を実装する際に、以下の内容の処理を実装する
        // 1. 検索フォームでの検索情報の値(バリデーション済み)を取得する
        $search_name = $request->input('athlete_name');
        $search_event_id = $request->input('m_event_id');
        $search_position_id = $request->input('m_event_position_id');

        // 2. Athleteモデルで検索情報に一致する選手情報のメソッドを作成後に、メソッドの引数で検索フォームの値を引数で渡す。
        $athletes = Athlete::fetchSearchAthlete($team_id, $search_name, $search_event_id, $search_position_id)->get();
        // 3. 2で取得した条件に合う選手情報を、$athletesに格納する

        // 種目・種目に紐ずくポジションの情報を取得する
        $m_events = MEvent::getAllMEventAndPositions()->get();

        // リダイレクト処理
        return Inertia::render('Athlete/Index', [
            'athletes' => $athletes,
            'm_events' => $m_events
        ]);
    }
    // /**
    //  * 選手一覧画面
    //  *
    //  * @var string $search_name
    //  * @var interger $search_event_id
    //  * @var interger $search_position_id
    //  */
    // public function index(Request $request)
    // {
    //     // ↓検索機能を実装する際に、以下の内容の処理を実装する
    //     // 1. 検索フォームでの検索情報の値(バリデーション済み)を取得する
    //     $search_name = $request->input('athlete_name');
    //     $search_event_id = $request->input('m_event_id');
    //     $search_position_id = $request->input('m_event_position_id');

    //     $team_id = null;

    //     // 2. Athleteモデルで検索情報に一致する選手情報のメソッドを作成後に、メソッドの引数で検索フォームの値を引数で渡す。
    //     $athletes = Athlete::featchSearchAthlete($team_id, $search_name, $search_event_id, $search_position_id)->get();
    //     // 3. 2で取得した条件に合う選手情報を、$athletesに格納する

    //     // 種目・種目に紐ずくポジションの情報を取得する
    //     $m_events = MEvent::getAllMEventAndPositions()->get();

    //     // リダイレクト処理
    //     return Inertia::render('Athlete/Index', [
    //         'athletes' => $athletes,
    //         'm_events' => $m_events
    //     ]);
    // }

    /**
     * 各チームの選手一覧
     */
    public function showRespectiveTeam(SearchAthleteRequest $request, $team_id)
    {
        // dd($request);
        $team_id = intval($team_id, 10);
        $search_name = $request->input('athlete_name');
        $search_position_id = $request->input('m_event_position_id');
        $search_event_id = $request->input('m_event_id');

        $athletes = Athlete::fetchSearchAthlete($team_id, $search_name, $search_event_id, $search_position_id)->get();

        $team = Team::with('mEvent')->findOrFail($team_id);
        // dd($team);
        $m_event_id = $team->mEvent->id;
        $m_event_name = $team->mEvent->event_name;
        $m_event_positions = $team->mEvent->mEventPositions;

        // リダイレクト処理
        return Inertia::render('Athlete/TeamIndex', [
            'athletes' => $athletes,
            'team' => $team,
            'm_event_id' => $m_event_id,
            'm_event_name' => $m_event_name,
            'm_event_positions' => $m_event_positions
        ]);
    }

    /**
     * 選手登録画面
     */
    public function create()
    {
        // 登録されているチーム情報とそのチームに紐づく種目・ポジションを一緒に取得
        $team_event_positions = Team::with('mEvent.mEventPositions')->get();

        // 性別テーブルの情報を取得
        $sexes = Sex::all();

        // リダイレクト処理
        return Inertia::render('Athlete/Create', [
            'team_event_positions' => $team_event_positions,
            'sexes' => $sexes
        ]);
    }

    /**
     * 選手登録
     *
     * @param App\Http\Requests\StoreAthleteRequest $storeAthleteRequest
     * @return \Inertia\Responce
     */
    public function store(StoreAthleteRequest $storeAthleteRequest)
    {

        $storeAthleteRequest->validated();

        // 選手を新規作成
        $athlete = DB::transaction(function() use($storeAthleteRequest) {
            $athlete = Athlete::create([
                'team_id' => $storeAthleteRequest->team_id,
                'sex_id' => $storeAthleteRequest->sex_id,
                'name' => $storeAthleteRequest->athlete_name,
                'birthday' => $storeAthleteRequest->birthday,
                'memo' => $storeAthleteRequest->memo
            ]);

            $pivotPlayerPositionData = $storeAthleteRequest->m_event_position_id;

            $athlete->mEventPositions()->syncWithoutDetaching($pivotPlayerPositionData);

            return $athlete;

        });

        // リダイレクト時に新規登録メッセージを表示する
        return to_route('athlete.index')->with('message', '【'. $athlete->name . '】の選手情報を更新しました。');
    }

    /**
     * 選手詳細画面
     */
    public function show($athlete_id, $position_id)
    {
        // 対象のIDを持つ選手とリレーション関係のデータを取得する
        $athlete =Athlete::with('team.mEvent', 'sex', 'mEventPositions')->findOrFail($athlete_id);

        $athlete_data_array = $athlete->setAthletePositionData($athlete, $position_id);

        // 性別テーブルの情報を取得
        $sexes = Sex::all();

        return Inertia::render('Athlete/Show', [
            'athlete' => $athlete_data_array,
            'sexes' => $sexes
        ]);
    }

    /**
     * 選手編集画面
     *
     * @var array $athlete_data_array
     */
    public function edit($athlete_id, $position_id)
    {
        // 対象のIDを持つ選手とリレーション関係のデータを取得する
        $athlete =Athlete::with('team.mEvent', 'sex', 'mEventPositions')->findOrFail($athlete_id);

        $athlete_data_array= $athlete->setAthletePositionData($athlete, $position_id);

        // 登録されているチームに紐づく種目・ポジションを取得する
        $team_event_positions = MEventPosition::where('m_event_id', '=', $athlete->team->m_event_id)->get();

        // 性別テーブルの情報を取得
        $sexes = Sex::all();

        return Inertia::render('Athlete/Edit', [
            'athlete' => $athlete_data_array,
            'team_event_positions' => $team_event_positions,
            'sexes' => $sexes
        ]);

    }

    /**
     * 選手編集
     */
    public function update(UpdateAthleteRequest $updateAthleteRequest)
    {
        $updateAthleteRequest->validated();

        $setAthlete = Athlete::findOrFail($updateAthleteRequest->athlete_id);
        $setPlayerPosition = PlayerPosition::findOrFail($updateAthleteRequest->player_position_id);

        $update_m_event_position_id = intval($updateAthleteRequest['m_event_position_id']);


        DB::transaction(function() use($setAthlete, $updateAthleteRequest, $setPlayerPosition, $update_m_event_position_id){

            // 選手情報更新
            $setAthlete->update([
                'sex_id' => $updateAthleteRequest['sex_id'],
                'name' => $updateAthleteRequest['athlete_name'],
                'birthday' => $updateAthleteRequest['birthday'],
                'memo' => $updateAthleteRequest['memo']
            ]);

            // 選手ポジション情報更新
            $setPlayerPosition->update([
                'm_event_position_id' => $update_m_event_position_id
            ]);

            return $setAthlete;
        });

        // リダイレクト時に編集メッセージを表示する
        return to_route('athlete.index')->with('message', '【'. $setAthlete->name . '】の選手情報を編集しました。');
    }

    /**
     * 選手削除
     */
    public function destroy()
    {

    }

}
