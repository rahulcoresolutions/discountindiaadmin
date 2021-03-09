<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVouchersRequest extends FormRequest {

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
            'title' => 'required', 
            // 'valid_date' => 'required', 
            'terms_condition' => 'required', 
            'barcode' => 'required', 
            'discount' => 'required', 
            // 'voucher_type' => 'required', 
            'voucher_template' => 'required', 
            
		];
	}
}
