<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchAthleteRequest;
use App\Http\Requests\StoreAthleteRequest;
use App\Models\Athlete;
use App\Models\MEvent;
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
        // dd($request->validated());
        // ↓検索機能を実装する際に、以下の内容の処理を実装する
        // 1. 検索フォームでの検索情報の値(バリデーション済み)を取得する
        $search_name = $request->input('athlete_name');
        $search_event_id = $request->input('m_event_id');
        $search_position_id = $request->input('m_event_position_id');

        // dd($search_event_id);

        // 2. Athleteモデルで検索情報に一致する選手情報のメソッドを作成後に、メソッドの引数で検索フォームの値を引数で渡す。
        $athletes = Athlete::featchSearchAthlete($search_name, $search_event_id, $search_position_id)->get();
        // 3. 2で取得した条件に合う選手情報を、$athletesに格納する

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
        // 登録されているチーム情報とそのチームに紐づく種目・ポジションを一緒に取得
        $team_event_positions = Team::with('mEvent.mEventPositions')->get();
        // dd($team_event_datas);

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
     * @param StoreAthleteRequest $request
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

            $athlete->mEventPositions()->sync($pivotPlayerPositionData);

            return $athlete;

        });

        // リダイレクト時に新規登録メッセージを表示する
        return to_route('athlete.index')->with('message', '【'. $athlete->name . '】の選手情報を新規登録しました。');
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
