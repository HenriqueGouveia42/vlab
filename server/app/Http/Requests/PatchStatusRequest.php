<?php

namespace App\Http\Requests;

use App\Enums\StatusSolicitacaoEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatchStatusRequest extends FormRequest
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
            'status' => ['required', Rule::enum(StatusSolicitacaoEnum::class)]
        ];
    }

    // Serve apenas para o scribe gerar documentacao  
    public function bodyParameters(): array
    {
        return [
            'status' => [
                'description' => "Novo status da solicitação. \n\n"
                               . "**Regras de Transição Permitidas:**\n"
                               . "- De `RECEBIDA` para: `EM_ANALISE` ou `CANCELADA`\n"
                               . "- De `EM_ANALISE` para: `AGENDADA` ou `CANCELADA`\n"
                               . "- De `AGENDADA` para: `CONCLUIDA` ou `CANCELADA`\n"
                               . "- `CONCLUIDA` e `CANCELADA` são estados finais e não permitem novas mudanças.",
                'example' => 'AGENDADA',
            ],
        ];
    }
}
