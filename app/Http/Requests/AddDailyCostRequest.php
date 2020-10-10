<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDailyCostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'percent' => [
                function ($attribute, $value, $fail) {
                    if (array_sum($value) > 100) {
                        return $fail('Tổng % phải bằng 100%');
                    } else if (array_sum($value) < 100) {
                        return $fail('Tổng % phải bằng 100%');
                    }
                }
            ],
            'date' => 'required',
            'payfor' => 'required',
            'total' => 'required',
            'is_together' => 'required',
        ];
    }

    /**
     * Get the messages that apply to the rules.
     *
     * @return array
     */
    public function messages(){
        return [
            'date.required' => 'Vui lòng chọn ngày chi',
            'payfor.required' => 'Vui lòng nhập nội dung',
            'total.required' => 'Vui lòng nhập tổng tiền',
            'is_together.required' => 'Vui lòng chọn chi tiêu chung/chi tiêu cá nhân'
        ];
    }
}
