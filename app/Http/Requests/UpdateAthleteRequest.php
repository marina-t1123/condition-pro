<?php

namespace App\Http\Requests;

use App\Models\Athlete;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator; // 現在のバリデーション状態を含むオブジェクト

class UpdateAthleteRequest extends FormRequest
{
        /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'athlete_id' => 'required|integer|exists:athletes,id',
            'team_id' => 'required|integer|exists:teams,id',
            'team_name' => 'required|string|exists:teams,team_name',
            'event_name' => 'required|string|exists:m_events,event_name',
            'm_event_position_id' => 'required|integer|exists:m_event_positions,id',
            'player_position_id' => 'required|integer|exists:player_positions,id',
            'athlete_name' => 'required|string|max:255',
            'sex_id' => 'required|string|exists:sexes,id',
            'birthday' => 'required|date|before:today',
            'memo' => 'nullable|string|max:5000',
        ];
    }

    /**
     *  リクエストに対して、追加バリデーションのCallable(クロージャ)の取得
     */
    public function after():array
    {
        // 追加バリデーション処理の結果を返却できるようにreturnを指定
        return [
            // 追加のバリデーションを実施するため、無名関数(クロージャ)で引数に「Validatorインスタンス」(現在のバリデーション状態を含むインスタンス)を使用して、エラーを追加できる
            function (Validator $validator) {
                // Athleteテーブルで、送信された「atlete_name」と「birthday」、「m_event_position_id」が重複したの登録内容があるかチェック
                $athleteStoreCheckQuery = Athlete::where('team_id', $this->team_id)
                    ->where('name', $this->athlete_name)
                    ->where('birthday', $this->birthday)
                    ->whereHas('mEventPositions', function($athleteStoreCheckQuery) {
                        $athleteStoreCheckQuery->where('m_event_positions.id', $this->m_event_position_id);
                    })
                    ->exists();

                // もし、すでに送信された内容で選手名・誕生日で登録されている場合
                if($athleteStoreCheckQuery)
                {
                    // バリデーションエラーを追加する
                    $validator->errors()->add(
                        'athlete_name',
                        '指定されたチーム・ポジション・選手名・生年月日での選手情報はすでに登録されています。'
                    );
                }
            }
        ];
    }

    /**
     * 各項目の日本語指定
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'athlete_id' => '選手ID',
            'team_id' => 'チームID',
            'event_name' => '種目名',
            'm_event_position_id' => 'ポジション・階級名',
            'athlete_name' => '選手名',
            'sex_id' => '性別タイプ',
            'birthday' => '生年月日',
            'memo' => '備考'
        ];
    }
}
