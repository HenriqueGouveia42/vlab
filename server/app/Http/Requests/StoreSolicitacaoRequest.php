<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CategoriaEnum;
use App\Enums\PrioridadeEnum;
use Illuminate\Validation\Rule;

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
            'categoria' => ['required', Rule::enum(CategoriaEnum::class)],
            'prioridade' => ['required', Rule::enum(PrioridadeEnum::class)],
            'descricao' => ['required', 'string'],
            'justificativa_prioridade' => ['nullable','required_if:prioridade,URGENTE', 'string', 'max:5000']// Solicitações com prioridade URGENTE devem possuir justificativa de prioridade preenchida.
        ];
    }

    public function messages(): array{
        return [
            'justificativa_prioridade.required_if' => 'Solicitacoes URGENTES devem possuir justificativa',
            'categoria.enum' => 'Categoria invalida',
            'prioridade.enum' => 'Prioridade invalida'
        ];
    }
}
