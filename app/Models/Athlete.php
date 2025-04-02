<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\PlayerPosition;

class Athlete extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'sex_id', 'name', 'birthday', 'memo'];

    /**
     * 選手の性別譲情報を取得　
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sex(): BelongsTo
    {
        return $this->belongsTo(Sex::class);
    }

    /**
     * 選手のチーム
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * 選手のポジション・階級
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function mEventPositions(): BelongsToMany
    {
        return $this->belongsToMany(MEventPosition::class, 'player_positions', 'athlete_id', 'm_event_position_id')->withTimestamps();
    }

    /**
     * 全選手一覧画面での選手情報を取得する
     *
     */
    public static function fetchAthleteData($request, $teamId)
    {
        $searchName = $request->input('athlete_name');
        $searchEventId = $request->input('m_event_id');
        $searchPositionId = $request->input('m_event_position_id');

        // dd($searchEventId);
        $athleteData['athletes'] = Athlete::retrieveAthlete($teamId, $searchName, $searchEventId, $searchPositionId)->get();

        if (!empty($teamId)) {
            $teamId = intval($teamId, 10);
            $athleteData['team'] = Team::with('mEvent')->findOrFail($teamId);

            $athleteData['m_event_id'] = $athleteData['team']->mEvent->id;
            $athleteData['m_event_name'] = $athleteData['team']->mEvent->event_name;
            $athleteData['m_event_positions'] = $athleteData['team']->mEvent->mEventPositions;

        } else {
            // 全選手の場合は全種目情報を取得
            $athleteData['m_events'] = MEvent::getAllMEventAndPositions()->get();
        }

        return $athleteData;
    }

    /**
     * 選手情報の検索
     * 名前・種目・ポジションでの条件に一致する選手情報を関連情報と一緒に取得
     *
     * @param int|null $teamId
     * @param string|null $searchName
     * @param int|null $searchEventId
     * @param int|null $searchPositionId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function retrieveAthlete($teamId, $searchName, $searchEventId, $searchPositionId)
    {
        // 選手のクエリビルダを設定（この時、リレーション関係にあるteamとsexの情報も一緒に取得する）
        $query = Athlete::query()->with(['team', 'sex', 'mEventPositions.mEvent']);

        // チームIDが指定された場合
        if (!empty($teamId)) {
            $query->whereHas('team', function ($query) use ($teamId) {
                $query->where('id', $teamId);
            });
        }

        // 選手の名前が検索フォームから検索された場合
        if (!empty($searchName)) {
            $query->where('name', 'LIKE', '%' . $searchName . '%');
        }

        // 種目名が検索フォームから検索された場合
        if (!empty($searchEventId)) {
            $query->whereHas('team', function ($query) use ($searchEventId) {
                $query->where('m_event_id', $searchEventId);
            });
        }

        // ポジションIDが検索フォームから検索された場合
        if (!empty($searchPositionId)) {
            $query->whereHas('mEventPositions', function ($query) use ($searchPositionId) {
                $query->where('m_event_positions.id', $searchPositionId);
            });
        }

        // 種目名、ポジション・階級のそれぞれのIDが送信された場合
        if (!empty($searchEventId) && !empty($searchPositionId)) {

            // すでに取得済みの選手情報に紐づくポジションを指定条件で取得
            $query->with(['mEventPositions' => function ($query) use ($searchEventId, $searchPositionId) {
                // 指定されたポジションIDのみ取得する
                $query->where('m_event_positions.id', $searchPositionId)
                    // かつ、そのポジションが指定された種目に属していることを確認
                    ->whereHas('mEvent', function ($query) use ($searchEventId) {
                        $query->where('id', $searchEventId);
                    });

                // ポジションに紐づく種目情報も取得する
                $query->with('mEvent');
            }]);
        }

        $searchAthletes = $query;

        return $searchAthletes;
    }

    /**
     * 対象選手のポジション情報を取得
     * ポジション関連の情報を取得しやすいでデータ構造の配列にしている
     *
     * @param \App\Models\Athlete $athlete 選手情報
     * @param int $position_id ポジションID
     * @return array
     */
    public static function setAthletePositionData($athlete, $position_id)
    {

        // 対象のplayer_positions(中間テーブル)のIDを取得する
        if (!empty($athlete->id) && !empty($position_id)) {
            $player_position = PlayerPosition::where('athlete_id', $athlete->id)
                ->where('m_event_position_id', $position_id)
                ->first();

            $player_position_id = $player_position->id;
        }

        // 選手の種目名を取得する
        if ($player_position_id) {
            $m_event_position = MEventPosition::findOrFail($position_id);
            $position_name = $m_event_position->event_position_name;
        }

        // 選手データを配列に変換
        $athlete_data_array = $athlete->toArray();

        // ポジション情報を直接アクセス可能なプロパティとして追加
        $athlete_data_array['m_event_position_id'] = $position_id;
        $athlete_data_array['event_position_name'] = $position_name;
        $athlete_data_array['player_position_id'] = $player_position_id;

        return $athlete_data_array;
    }

    /**
     * 削除に必要な情報を取得
     *
     * @param int $deleteAthleteId
     * @return array{ delete_athlete: \App|Models|Athlete, athlete_name: string, positions: \Illuminate\Database\Eloquent\Collection }
     */
    public static function getInfoNecessaryDeleting($deleteAthleteId)
    {
        $deleteAthlete = Athlete::with('mEventPositions', 'team')->findOrFail($deleteAthleteId);

        $deleteAthleteNama = $deleteAthlete->name;
        $deleteAthletePositions = $deleteAthlete->mEventPositions()
            ->wherePivot('athlete_id', $deleteAthlete->id)
            ->get();

        return [
            'delete_athlete' => $deleteAthlete,
            'athlete_name' => $deleteAthleteNama,
            'positions' => $deleteAthletePositions
        ];
    }
}
