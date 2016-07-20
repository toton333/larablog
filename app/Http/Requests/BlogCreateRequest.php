<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BlogCreateRequest extends Request
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
            'title' => 'required|min:3|max:50',
            'body'  => 'required'
        ];
    }

    /**
     * Custom error messages.
     *
     * @return array
     */

    public function messages(){


        return [

            'title.required' => 'Please insert a :attribute of this post ',
            'body.required'  => 'Please write some content'

        ];
    }




}
