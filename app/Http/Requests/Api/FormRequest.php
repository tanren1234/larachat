<?php
namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/5 0005
 * Time: 16:01
 */
class FormRequest extends BaseFormRequest
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
}