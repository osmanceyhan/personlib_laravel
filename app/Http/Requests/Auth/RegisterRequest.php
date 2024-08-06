<?php

namespace App\Http\Requests\Auth;

use App\Enumerations\GenderEnum;
use App\Enumerations\PlatformEnum;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
{
    use ApiResponses;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:'.implode(',', GenderEnum::array())],
            'geo_code' => ['required'],
            'telephone' => ['required', 'size:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'register_platform' => ['required', new Enum(PlatformEnum::class)]
        ];
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(
    //         $this->errorResponse($validator->errors(), __("Form doğrulama başarısız"))
    //     );
    // }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [        
            'name.required' => __('İsim boş bırakılamaz.'),
            'name.string' => __('İsim metin olmalıdır.'),
            'name.max' => __('İsim 255 karakterden fazla olamaz.'),

            'surname.required' => __('Soyisim boş bırakılamaz.'),
            'surname.string' => __('Soyisim metin olmalıdır.'),
            'surname.max' => __('Soyisim 255 karakterden fazla olamaz.'),

            'gender.required' => __('Cinsiyet boş bırakılamaz'),
            'gender.in' => __('Cinsiyet erkek veya kadın olabilir.'),

            'geo_code.required' => __('Ülke kodu boş bırakılamaz.'),

            'telephone.required' => __('Telefon numarası boş bırakılamaz.'),
            'telephone.size' => __("Telefon numarası 10 karakterden oluşmalıdır."),

            'email.required' => __('Email boş bırakılamaz.'),
            'email.string' => __('Email metin olmalıdır.'),
            'email.email' => __('Lütfen geçerli bir email girin.'),
            'email.max' => __('Email 255 karakterden fazla olamaz.'),
            'email.unique' => __('Girdiğiniz email adresi kullanılmaktadır.'),

            'password.required' => __('Şifre boş bırakılamaz.'),
            'password.confirmed' => __('Şifreleriniz uyuşmuyor.'),
            'password.min' => __('Şifre en az 8 karakterden oluşmalıdır.'),
            
            'register_platform.required' => __('Kayıt platformu boş bırakılamaz.'),
            'register_platform.Illuminate\Validation\Rules\Enum' => __('Geçersiz bir platform girdiniz.'),
        ];
    }
}
