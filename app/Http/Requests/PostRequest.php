<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {   
        //autorizar
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
            'title' => 'required|min:2|max:200',
            'text'  => 'required',
            'image' => 'nullable|mimes:jpg, bmp, png, jpeg',//mimes para validar extensión de archivo
            'date'  => 'required',
            'time'  => 'required',
        ];
    }
}
