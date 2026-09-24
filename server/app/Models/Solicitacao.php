<?php

namespace App\Models;

use App\Enums\CategoriaEnum;
use App\Enums\PrioridadeEnum;
use App\Enums\StatusSolicitacaoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Solicitacao extends Model
{
    /** @use HasFactory<\Database\Factories\SolicitacaoFactory> */
    use HasFactory;

    protected $fillable = [
        'nome_solicitante',
        'categoria',
        'prioridade',
        'descricao',
        'justificativa_prioridade'
    ];
    
    protected $casts = [
        'status' => StatusSolicitacaoEnum::class,
        'categoria' => CategoriaEnum::class,
        'prioridade' => PrioridadeEnum::class,
    ];

    protected $attributes = [
        'status' => StatusSolicitacaoEnum::RECEBIDA->value
    ]; // Toda solicitação deve ser criada com status inicial RECEBIDA.

    protected static function booted(): void{
        static::creating(function (Solicitacao $solicitacao){

            $protocolo_gerado = 'sol-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $solicitacao->protocolo = $protocolo_gerado;

            if ($solicitacao->prioridade->value === PrioridadeEnum::URGENTE->value && empty($solicitacao->justificativa_prioridade)) {
                throw new \Exception("Justificativa é obrigatória para prioridade URGENTE.");
            }

        });
    }

    public function isValidStatusTransition(string $newStatus): bool{

        $allowedChanges = [
            StatusSolicitacaoEnum::RECEBIDA->value   => [ StatusSolicitacaoEnum::EM_ANALISE->value, StatusSolicitacaoEnum::CANCELADA->value],
            StatusSolicitacaoEnum::EM_ANALISE->value => [StatusSolicitacaoEnum::AGENDADA->value, StatusSolicitacaoEnum::CANCELADA->value],
            StatusSolicitacaoEnum::AGENDADA->value   => [StatusSolicitacaoEnum::CONCLUIDA->value, StatusSolicitacaoEnum::CANCELADA->value],
            StatusSolicitacaoEnum::CONCLUIDA->value  => [], 
            StatusSolicitacaoEnum::CANCELADA->value  => [],
        ];

        return in_array($newStatus, $allowedChanges[$this->status->value] ?? []);

    }

    public function updateStatus(string $newStatus): void{

        $is_valid_transition = $this->isValidStatusTransition($newStatus);

        if(!$is_valid_transition){
            throw new \Exception("Mudanca de status invalida. Mmudanca de {$this->status->value} para {$newStatus} nao permitida.");
        }

        $this->status = $newStatus;

        $this->save();
    }


}
