<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{


	/**
	 * @return array|string[]
	 */
	public function messages()
	{
		return [
			'name.required' => 'The event field is required.',
			'days.required' => 'Please select at least one day.',
		];
	}

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
			'name' => 'required',
			'date_from' => 'required|date|before:date_to',
			'date_to' => 'required|date|after:date_from',
			'days' => 'required|array|min:1',
		];
	}
}
