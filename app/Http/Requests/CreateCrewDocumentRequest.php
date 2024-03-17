<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCrewDocumentRequest extends FormRequest
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
        // $request->validate([
        //     $fileKey => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        // ]);
        return [
            'file' => 'required|mimes:pdf|max:10000',
            'document_id' => 'required|int',
            'crew_id' => 'required|int',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date'
        ];
    }

    /**
     * Failed validation return
     *
     * @return array
     */
    public function failedValidation(Validator $validator): array
    {
        $errors = $validator->errors();
        $response = response()->json(['message' => $errors->messages()], 200);
        throw new HttpResponseException($response);
    }
}
