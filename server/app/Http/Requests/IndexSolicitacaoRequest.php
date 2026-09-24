<?php

namespace App\Http\Requests;

use App\Enums\CategoriaEnum;
use App\Enums\PrioridadeEnum;
use App\Enums\StatusSolicitacaoEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexSolicitacaoRequest extends FormRequest
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

    /*
        Aqui a ideia é usar filtros que vieram na URL (ex: ?status=RECEBIDA), que poder EXISTIR ou NAO
    */
    public function rules(): array
    {
        return [
            'status' => ['nullable', Rule::enum(StatusSolicitacaoEnum::class)],
            'categoria' => ['nullable', Rule::enum(CategoriaEnum::class)],
            'prioridade' => ['nullable', Rule::enum(PrioridadeEnum::class)],
            'page' => ['nullable', 'integer', 'min:1']
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'O status informado para o filtro é inválido.',
            'categoria.in' => 'A categoria informada para o filtro é inválida.',
            'prioridade.in' => 'A prioridade informada para o filtro é inválida.',
            'page.integer' => 'A página deve ser um número válido.'
        ];
    }

    // Serve apenas para o scribe gerar documentacao  
    public function queryParameters(): array
    {
        return [
            'status' => [
                'description' => 'Filtra as solicitações pelo status exato.',
                'example' => 'RECEBIDA',
            ],
            'categoria' => [
                'description' => 'Filtra as solicitações por uma categoria específica.',
                'example' => 'EXAME', 
            ],
            'prioridade' => [
                'description' => 'Filtra as solicitações pela prioridade.',
                'example' => 'BAIXA',
            ],
            'page' => [
                'description' => 'Número da página para navegação nos resultados paginados.',
                'example' => 1,
            ],
        ];
    }
}
