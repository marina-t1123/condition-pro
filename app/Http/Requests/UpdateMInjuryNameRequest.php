<?php

namespace App\Http\Requests;

use App\Models\MInjuryName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator; //　現在のバリデーション状態を含むオブジェクト

class UpdateMInjuryNameRequest extends FormRequest
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
            'injury_name' => 'required|string|max:255'
        ];
    }

        /**
     * リクエストに対して、追加バリデーション処置の結果をcallable（クロージャ）の取得
     *
     */
    public function after():array
    {
        return [
            function (Validator $validator) {
                // MInjuryNameテーブルで、送信された値の「injury_name」がすでに登録済みの場合に弾く
                $isDupicate = MInjuryName::where('injury_name', $this->injury_name)
                    ->exists();

                //　もし、すでに送信された内容でポジション・階級が登録されていた場合
                if($isDupicate) {
                    // バリデーションエラーを追加する
                    $validator->errors()->add(
                        'injury_name', //key
                        '指定された傷害名は、すでに登録されています。' //message
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
            'injury_name' => '傷病名',
        ];
    }
}
