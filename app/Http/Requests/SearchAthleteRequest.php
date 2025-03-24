<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\MEventPosition;
use Illuminate\Validation\Validator;

class SearchAthleteRequest extends FormRequest
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
            'athlete_name' => 'string|max:255',
            'm_event_id' => 'string|exists:m_events.id',
            'm_event_position_id' => 'string|exists:m_event_positions.id'
        ];
    }


}

/**
     * リクエストに対して、追加バリデーションのCallable（クロージャ）の取得
     *
     */
    // public function after(): array
    // {
    //     // 追加バリデーション処理の結果を返却できるようにrerutnを指定
    //     return [
    //         function (Validator $validator) {
    //             $isDuplicate = MEventPosition::where('id', $this->m_event_opsition_id)
    //                 ->where('m_event_id', $this->m_event_id)
    //                 ->doesntExist();

    //             // もし、検索フォームから送信されたポジションID・種目IDの組み合わせが存在しない場合
    //             if($isDuplicate) {

    //                 // バリデーションエラーを追加する
    //                 $validator->errors()->add(
    //                     'm_event_position_id',
    //                     '指定された種目に紐づくポジションではありませんでした'
    //                 );

    //             }
    //         }
    //     ];
    // }
