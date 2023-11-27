<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
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
            'amount' => 'required',
            'payer' => 'required',
            'due_on' => 'required',
            'vat' => 'required',
            'is_vat_inclusive' => 'required',
            // 'payment_status' => 'required|in:paid,outstanding,overdue'
        ];
    }
}
