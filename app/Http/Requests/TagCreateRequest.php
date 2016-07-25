<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TagCreateRequest extends Request
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
            'name' => 'required|min:3|max:50|unique:tags',
            'description'  => 'required'
        ];
    }

   public function messages(){


        return [

            'name.required' => 'Please insert a :attribute of this tag ',
            'description.required'  => 'Please write something about this tag ',

        ];
    }


}
