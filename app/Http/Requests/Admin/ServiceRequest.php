<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ServiceRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return !\Auth::guest();
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
			'summary' => 'required',
			'body' => 'required',
			'api' => 'required|numeric',
		];
	}

}
