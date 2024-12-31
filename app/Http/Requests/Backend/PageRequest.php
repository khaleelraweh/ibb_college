<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST': {
                    return [
                        'title.ar'                       =>  'required|max:255',
                        'content.*'                     =>  'nullable',

                        'page_category_id'              =>  'required',

                        'metadata_title.*'              =>  'nullable',
                        'metadata_description.*'        =>  'nullable',
                        'metadata_keywords.*'           =>  'nullable',
                        'images'                        =>  'required',
                        'images.*'                      =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',

                        // used always 
                        'status'                        =>  'required',
                        'published_on'              =>  'required',
                        'created_by'                    =>  'nullable',
                        'updated_by'                    =>  'nullable',
                        'deleted_by'                    =>  'nullable',
                        // end of used always 

                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'title.ar'                           =>   'required|max:255',
                        'content.*'                         =>   'nullable',

                        'page_category_id'                  =>  'required',

                        'metadata_title.*'                  =>  'nullable',
                        'metadata_description.*'            =>  'nullable',
                        'metadata_keywords.*'               =>  'nullable',

                        // 'images'                         =>  'required',
                        'images.*'                          =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',


                        // used always 
                        'status'                            =>  'required',
                        'published_on'                      =>  'required',
                        'created_by'                        =>  'nullable',
                        'updated_by'                        =>  'nullable',
                        'deleted_by'                        =>  'nullable',
                        // end of used always 
                    ];
                }

            default:
                break;
        }
    }

    public function attributes(): array
    {
        $attr = [
            'content'      => '( ' . __('panel.f_content') . ' )',
            'page_category_id'      => '( ' . __('panel.category_name') . ' )',
            'images'      => '( ' . __('panel.images') . ' )',
            'status'    =>  '( ' . __('panel.status') . ' )',
            'published_on'      => '( ' . __('panel.published_on') . ' )',

        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['title.' . $key       =>  "( " . __('panel.title')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }


        return $attr;
    }
}
