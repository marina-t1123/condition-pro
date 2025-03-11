<?php

namespace App\Http\Requests;

use App\Models\MEventPosition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator; // 現在のバリデーション状態を含むオブジェクト

class UpdateMEventPositionRequest extends FormRequest
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
            'm_event_id' => 'required|exists:m_events,id',
            // 'm_event_position_id' => 'required|exists:m_event_positions,id',
            'event_position_name' => 'required|string|max:255',
        ];
    }

    /**
     * リクエストに対して、追加バリデーションのCallable(クロージャ)の取得
     */
    public function after():array
    {
        // 追加のバリデーション処理の結果を返却できるようにreturnを指定
        return [
            // 追加のバリデーションを実施するため、無名関数(クロージャ)で引数に「Validatorインスタンス」（現在のバリデーション状態を含むインスタンス）を使用して、エラーを追加できる
            function (Validator $validator) {
                // MEventPositionテーブルで、送信された「event_id」と「event_position_name」がすでに登録済みかをチェックする
                $isDuplicate = MEventPosition::where('m_event_id', $this->m_event_id)
                    ->where('event_position_name', $this->event_position_name)
                    ->exists();


                // もし、すでに送信された内容でポジション・階級が登録されていた場合
                if($isDuplicate)
                {
                    // バリデーションエラーを追加する
                    $validator->errors()->add(
                        'event_position_name', //key
                        '指定された種目に対して、このポジション・階級はすでに登録されています。' //message
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
            'event_id' => '種目マスタID',
            'event_position_name' => 'ポジション・階級名'
        ];
    }
}
