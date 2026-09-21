<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSolicitacaoRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome_solicitante' => ['required', 'string', 'max:255'],
            'categoria' => ['required', 'in:CONSULTA,EXAME,VACINACAO,OUTRO'],
            'prioridade' => ['required', 'in:BAIXA,MEDIA,ALTA,URGENTE'],
            'descricao' => ['required', 'string'],
            'justificativa_prioridade' => ['required_if:prioridade,URGENTE'] // Solicitações com prioridade URGENTE devem possuir justificativa de prioridade preenchida.
        ];
    }

    public function messages(): array{
        return [
            'justificativa_prioridade.required_if' => 'Solicitacoes URGENTES devem possuir justificativa',
            'categoria.in' => 'Categoria invalida',
            'prioridade.in' => 'Prioridade invalida'
        ];
    }
}
