<?php

namespace App\Http\Requests;

use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreTeamRequest extends FormRequest
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
            'm_event_id' => 'required|integer|exists:m_events,id',
            'team_name' => 'required|string|max:255',
            'memo' => 'nullable|string|max:3000'
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                // 検索したい条件
                // Teamテーブルで送信されたteam_name・m_event_nameを持つteamのレコードがないかの確認
                $isDuplicate = Team::where('m_event_id', $this->m_event_id)
                    ->where('team_name', $this->team_name)
                    ->exists();

                // エラーメッセージの設定をして、上記条件の場合に返却する
                if($isDuplicate) {
                    $validator->errors()->add(
                        'team_name', //key
                        '対象の種目で、すでにそのチームは登録済みです。違うチーム名に変更するか、登録済みのチームをご確認ください。'
                    );
                }
            }
        ];
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'm_event_id' => '種目',
            'team_name' => 'チーム名',
            'memo' => 'メモ・備考'
        ];
    }
}
