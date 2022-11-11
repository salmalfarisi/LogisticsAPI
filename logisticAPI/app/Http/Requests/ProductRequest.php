<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
		//Check if parameter id exist
		$id = $this->route()->parameter('id');
		$name = $this->name;
		$validatephoto = ['file', 'mimes:jpg,png,jpeg'];
		$validatename = ['required','string','max:191'];
		if($id == null)
		{	
			array_push($validatename, Rule::unique('products')->where('name', $name)->where('delete_status', false));
			array_push($validatephoto, 'required');
		}
		else
		{
			array_push($validatename, Rule::unique('products')->where('name', $name)->where('delete_status', false)->ignore($id, 'id'));
			array_push($validatephoto, 'nullable');
		}
		
		return [ 
					'name' => $validatename,
					'price' => 'required', 'numeric',
					'product_category_id' => 'required',
					'image' => $validatephoto,
				];
    }
	
	/**
		* Get the error messages for the defined validation rules.*
		* @return array
	*/
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json([
			'errors' => $validator->errors(),
			'status' => true
		], 400));
	}
}
