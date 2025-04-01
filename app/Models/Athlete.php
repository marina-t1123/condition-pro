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
     * 　選手の性別
     */
    public function sex(): BelongsTo
    {
        return $this->belongsTo(Sex::class);
    }

    /**
     * 選手のチーム
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * 選手のポジション・階級
     */
    public function mEventPositions():BelongsToMany
    {
        return $this->belongsToMany(MEventPosition::class, 'player_positions', 'athlete_id', 'm_event_position_id')->withTimestamps();
    }

    /**
     * 名前・種目・ポジションでの条件に一致する選手情報を関連情報と一緒に取得
     */
    public static function fetchSearchAthlete($team_id, $search_name, $search_event_id, $search_position_id)
    {
        // 選手のクエリビルダを設定（この時、リレーション関係にあるteamとsexの情報も一緒に取得する）
        $query = Athlete::query()->with(['team', 'sex', 'mEventPositions.mEvent']);

        // チームIDが指定された場合
        if(!empty($team_id)) {
            $query->whereHas('team', function($query) use ($team_id) {
                $query->where('id', $team_id);
            });
        }

        // 選手の名前が検索フォームから検索された場合
        if(!empty($search_name)) {
            $query->where('name', 'LIKE', '%'.$search_name.'%');
        }

        // 種目名が検索フォームから検索された場合
        if(!empty($search_event_id)) {
            $query->whereHas('team', function($query) use ($search_event_id) {
                $query->where('m_event_id', $search_event_id);
            });
        }

        // 種目名、ポジション・階級のそれぞれのIDが送信された場合
        if(!empty($search_event_id) && !empty($search_position_id)) {

            // すでに取得済みの選手情報に紐づくポジションを指定条件で取得
            $query->with(['mEventPositions' => function($query) use($search_event_id, $search_position_id) {
                // 指定されたポジションIDのみ取得する
                $query->where('m_event_positions.id', $search_position_id)
                    // かつ、そのポジションが指定された種目に属していることを確認
                    ->whereHas('mEvent', function($query) use ($search_event_id) {
                        $query->where('id', $search_event_id);
                    });

                // ポジションに紐づく種目情報も取得する
                $query->with('mEvent');

            }]);
        }

        $search_athletes = $query;

        return $search_athletes;
    }
    // /**
    //  * 名前・種目・ポジションでの条件に一致する選手情報を関連情報と一緒に取得
    //  */
    // public static function featchSearchAthlete($search_name, $search_event_id, $search_position_id)
    // {
    //     // 選手のクエリビルダを設定（この時、リレーション関係にあるteamとsexの情報も一緒に取得する）
    //     $query = Athlete::query()->with(['team', 'sex', 'mEventPositions.mEvent']);

    //     // 選手の名前が検索フォームから検索された場合
    //     if(!empty($search_name)) {
    //         $query->where('name', 'LIKE', '%'.$search_name.'%');
    //     }

    //     // 種目名が検索フォームから検索された場合
    //     if(!empty($search_event_id)) {
    //         $query->whereHas('team', function($query) use ($search_event_id) {
    //             $query->where('m_event_id', $search_event_id);
    //         });
    //     }

    //     // 種目名、ポジション・階級のそれぞれのIDが送信された場合
    //     if(!empty($search_event_id) && !empty($search_position_id)) {

    //         // すでに取得済みの選手情報に紐づくポジションを指定条件で取得
    //         $query->with(['mEventPositions' => function($query) use($search_event_id, $search_position_id) {
    //             // 指定されたポジションIDのみ取得する
    //             $query->where('m_event_positions.id', $search_position_id)
    //                 // かつ、そのポジションが指定された種目に属していることを確認
    //                 ->whereHas('mEvent', function($query) use ($search_event_id) {
    //                     $query->where('id', $search_event_id);
    //                 });

    //             // ポジションに紐づく種目情報も取得する
    //             $query->with('mEvent');

    //         }]);
    //     }

    //     $search_athletes = $query;

    //     return $search_athletes;
    // }

    /**
     * 対象選手のポジション情報関連の情報をデータ配列にして取得
     */
    public static function setAthletePositionData($athlete, $position_id) {

        // 対象のplayer_positions(中間テーブル)のIDを取得する
        if(!empty($athlete->id) && !empty($position_id)) {
            $player_position = PlayerPosition::where('athlete_id', $athlete->id)
                ->where('m_event_position_id', $position_id)
                ->first();

            $player_position_id = $player_position->id;
        }

        // 選手の種目名を取得する
        if($player_position_id) {
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

}
