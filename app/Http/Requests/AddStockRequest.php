<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddStockRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'supplier_id' => 'required',
            'total_paid' => 'required',
            // 'medicine_id' => 'required',
            // 'total_units' => 'required',
            // 'price_per_unit' => 'required',
            // 'expiry' => 'required',
        ];
    }
}
