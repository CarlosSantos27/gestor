<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidateDocumentRequest extends FormRequest
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
            'title' => 'required|string',
            'summary' => 'required|string',
            'authors' => 'required|string',
            'keywords' => 'required|string',
            'document' => 'mimes:pdf',
        ];
    }

    public function messages()
    {
        return [
            'document.required' => 'Debe seleccionar un documento',
            'document.mimes' => 'Tipo de archivo no permitido, solo pueden ser documentos pdf',

            'title.required' => 'Debe definir un título',
            'title.string' => 'El título debe ser un texto',

            'authors.required' => 'Debe definir uno o varios autores',
            'authors.string' => 'El campo autor debe ser un texto',

            'keywords.required' => 'Debe definir una o varias palabras claves',
            'keywords.string' => 'Las palabras claves deben ser de tipo texto',

            'summary.required' => 'Debe definir un resumen del documento',
            'summary.string' => 'El resumen debe ser un texto',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = [];
        foreach ($validator->getMessageBag()->toArray() as $key => $messages) {
            $errors[$key] = $messages[0];
        }
        throw new HttpResponseException(response()->json($errors, 422));
    }
}
