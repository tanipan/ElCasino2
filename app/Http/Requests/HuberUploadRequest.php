<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HuberUploadRequest extends FormRequest
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
        $max_size = 10240;

        return [
            'certified_freelancers' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            'nif' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            //'nifb' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            'criminal_certificate' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            'certificate_treasury' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            'certificate_social' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            'driving_license_doc' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            //'points_certificate' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            'property_title' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            'photographic_description' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            'img1' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            'img2' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            'img3' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            //'img4' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            //'img4' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            //'img5' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
            'disability_certificate' => 'mimes:jpe,jpeg,png,bmp,pdf,doc,docx|max:' . $max_size,
        ];
    }
}
