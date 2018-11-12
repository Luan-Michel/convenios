<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class FinanciadorRequest extends Request
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
            
            'nm_financiador' => 'required|min:5|max:250',
            'ds_sigla_financiador' => 'required|max:30',
            'tp_esfera' => 'required|max:1',
            
            
            
            ];
    }
}
