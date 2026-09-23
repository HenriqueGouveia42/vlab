<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'status' => ['nullable', 'in:RECEBIDA,EM_ANALISE,AGENDADA,CONCLUIDA,CANCELADA'],
            'categoria' => ['nullable', 'in:CONSULTA,EXAME,VACINACAO,OUTRO'],
            'prioridade' => ['nullable', 'in:BAIXA,MEDIA,ALTA,URGENTE'],
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
}
