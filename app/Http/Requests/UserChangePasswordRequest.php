<?php
namespace App\Http\Requests;

use App\Traits\Http\HasApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UserChangePasswordRequest extends FormRequest
{
    use HasApiResponse;

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
        return [
            'oldPassword' => 'required',
            'newPassword' => 'required|string|min:8|different:oldPassword',
            'repeatPassword' => 'required|string|same:newPassword'
        ];
    }

    /**
     * Throw Http Response Exception
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->setResponse(Response::HTTP_UNPROCESSABLE_ENTITY, [], $validator->errors()));
    }
}
