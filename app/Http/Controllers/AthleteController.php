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
     * 選手一覧画面表示
     * 検索条件に一致する選手情報を取得することも可能
     *
     * @var string $searchName
     * @var interger $searchEventId
     * @var interger $searchPositionId
     */
    public function index(SearchAthleteRequest $request)
    {
        $teamId = null;
        $athleteData = Athlete::fetchAthleteData($request, $teamId);

        // リダイレクト処理
        return Inertia::render('Athlete/Index', [
            'athletes' => $athleteData['athletes'],
            'm_events' => $athleteData['m_events']
        ]);
    }

    /**
     * 各チームの選手一覧
     *
     *  @param \App\Http\Requests\SearchAthleteRequest $request
     *  @param int $teamId
     *  @return \Inertia\Responce
     */
    public function showRespectiveTeam(SearchAthleteRequest $request, $teamId)
    {
        $athleteData = Athlete::fetchAthleteData($request, $teamId);

        // リダイレクト処理
        return Inertia::render('Athlete/TeamIndex', [
            'athletes' => $athleteData['athletes'],
            'team' => $athleteData['team'],
            'm_event_id' => $athleteData['m_event_id'],
            'm_event_name' => $athleteData['m_event_name'],
            'm_event_positions' => $athleteData['m_event_positions']
        ]);
    }

    /**
     * 選手登録画面
     *
     * @return \Inertia\Responce
     */
    public function create()
    {
        // 登録されているチーム情報とそのチームに紐づく種目・ポジションを一緒に取得
        $teamEventPositions = Team::with('mEvent.mEventPositions')->get();

        // 性別テーブルの情報を取得
        $sexes = Sex::all();

        // リダイレクト処理
        return Inertia::render('Athlete/Create', [
            'team_event_positions' => $teamEventPositions,
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
        $athlete = DB::transaction(function () use ($storeAthleteRequest) {
            $athlete = Athlete::create([
                'team_id' => intval($storeAthleteRequest->team_id, 10),
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
        return to_route('athlete.index')->with('message', '【'.$athlete->name.'】の選手情報を更新しました。');
    }

    /**
     * 選手詳細画面
     *
     * @param int $athleteId
     * @param int $positionId
     * @return \Inertia\Response
     */
    public function show($athleteId, $positionId)
    {
        // 対象のIDを持つ選手とリレーション関係のデータを取得する
        $athlete = Athlete::with('team.mEvent', 'sex', 'mEventPositions')->findOrFail($athleteId);

        $athleteDataArray = $athlete->setAthletePositionData($athlete, $positionId);

        // 性別テーブルの情報を取得
        $sexes = Sex::all();

        return Inertia::render('Athlete/Show', [
            'athlete' => $athleteDataArray,
            'sexes' => $sexes
        ]);
    }

    /**
     * 選手編集画面
     *
     * @param int $athleteId
     * @param int $positionId
     * @var array $athleteDataArray
     * @return \Inertia\Responce
     */
    public function edit($athleteId, $positionId)
    {
        // 対象のIDを持つ選手とリレーション関係のデータを取得する
        $athlete = Athlete::with('team.mEvent', 'sex', 'mEventPositions')->findOrFail($athleteId);

        $athleteDataArray = $athlete->setAthletePositionData($athlete, $positionId);

        // 登録されているチームに紐づく種目・ポジションを取得する
        $teamEventPositions = MEventPosition::where('m_event_id', '=', $athlete->team->m_event_id)->get();

        // 性別テーブルの情報を取得
        $sexes = Sex::all();

        return Inertia::render('Athlete/Edit', [
            'athlete' => $athleteDataArray,
            'team_event_positions' => $teamEventPositions,
            'sexes' => $sexes
        ]);
    }

    /**
     * 選手更新
     *
     * @param \App\Http\Requests\UpdateAthleteRequest $updateAthleteRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAthleteRequest $updateAthleteRequest)
    {
        $updateAthleteRequest->validated();

        $setAthlete = Athlete::findOrFail($updateAthleteRequest->athlete_id);
        $setPlayerPosition = PlayerPosition::findOrFail($updateAthleteRequest->player_position_id);

        $update_m_event_position_id = intval($updateAthleteRequest['m_event_position_id']);


        DB::transaction(function () use ($setAthlete, $updateAthleteRequest, $setPlayerPosition, $update_m_event_position_id) {

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
        return to_route('athlete.index')->with('message', '【' . $setAthlete->name . '】の選手情報を編集しました。');
    }

    /**
     * 選手削除
     *
     * @param string $athleteId
     * @return \Illuminate\Http\RedirectResponce
     */
    public function destroy($athleteId)
    {
        $featchDeleteData = Athlete::getInfoNecessaryDeleting($athleteId);

        DB::transaction(function () use ($featchDeleteData) {

            $athlete = $featchDeleteData['delete_athlete'];
            $positions = $featchDeleteData['positions'];

            foreach ($positions as $position) {
                DB::table('player_positions')
                    ->where('athlete_id', $athlete->id)
                    ->where('m_event_position_id', $position->id)
                    ->delete();
            };

            $athlete->delete();
        });

        return to_route('athlete.index')->with('message', '【' . $featchDeleteData['athlete_name'] . '】の選手情報・関連登録情報を削除しました。');
    }
}
