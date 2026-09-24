<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitacaoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'protocolo' => $this->protocolo,
            'solicitante' => $this->nome_solicitante,
            'categoria' => $this->categoria,
            'prioridade' => $this->prioridade,
            'status' => $this->status->value,
            'detalhes' => [
                'descricao' => $this->descricao,
                'justificativa_prioridade' => $this->justificativa_prioridade
            ],
            'criado_em' => $this->created_at
        ];
    }
}
