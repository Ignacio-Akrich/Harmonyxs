<?php

namespace App\Http\Requests;

use App\Models\Ad;
use Illuminate\Foundation\Http\FormRequest;

class AnuncioEditRequest extends FormRequest
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
            'title' => 'required|min:5|max:80',
            'description' => 'required|min:10|max:2000',
            'music_genre' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El título no puede estar vacío',
            'title.min' => 'El título debe contener al menos 5 caracteres',
            'title.max' => 'El título debe contener un máximo de 80 caracteres',

            'description.required' => 'La descripción no puede estar vacía',
            'description.min' => 'La descripción debe contener al menos 10 caracteres',
            'description.max' => 'La descripción debe contener un máximo 2000 caracteres',

            'image.mimes' => 'Formatos aceptados: jpeg, png, jpg, gif, svg',
            'image.max' => 'Debes subir una imagen con tamaño inferior a 2 MB',

            'music_genre.required' => 'Especifica un género musical para tu anuncio'
        ];
    }
}
