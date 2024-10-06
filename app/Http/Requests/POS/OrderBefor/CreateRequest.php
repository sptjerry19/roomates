<?php

namespace App\Http\Requests\POS\OrderBefor;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name_customer' => 'required|string|max:255',
            'phone_customer' => 'required|string','max:12',
            'number'=> 'required',
            'date'=> 'required',
            'time'=> 'required',
            'deposit'=> 'nullable',
            'note'=> 'nullable',
            'area_id'=> 'nullable',
            'table_id'=> 'nullable',
            'products'=> 'nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute là bắt buộc',
            'string' => ':attribute phải là chuỗi ký tự',
            'max' => ':attribute chỉ có tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name_customer' => 'Tên khách hàng',
            'phone_customer' => 'Số điện thoại',
            'number' => 'Số người',
            'date' => 'Ngày đặt',
            'time' => 'Giờ đến'
        ];
    }
}
