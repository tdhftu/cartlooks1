<?php

namespace Theme\CartLooksTheme\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        return [
            'url' => 'required',
            'title' => 'required',
            'desktop' => 'required',
            'mobile' => 'required',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => translate('Title is required'),
            'url.required' => translate('Url is required'),
            'desktop.required' => translate(' Image for desktop is required'),
            'mobile.required' => translate('Image for mobile is required'),
        ];
    }
}
