<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    /** @use HasFactory<\Database\Factories\SolicitacaoFactory> */
    use HasFactory;

    protected $fillable = [
        'nome_solicitante',
        'categoria',
        'prioridade',
        'status',
        'descricao',
        'justificativa_prioridade'
    ];

    protected $attributes = [
        'status' => 'RECEBIDA'
    ]; // Toda solicitação deve ser criada com status inicial RECEBIDA.

    protected static function booted(): void{
        static::creating(function (Solicitacao $solicitacao){

            $protocolo_gerado = 'sol-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $solicitacao->protocolo = $protocolo_gerado;

        });
    }

    public function isValidStatusTransition(string $newStatus): bool{

        $allowedChanges = [
            'RECEBIDA'   => ['EM_ANALISE', 'CANCELADA'],
            'EM_ANALISE' => ['AGENDADA', 'CANCELADA'],
            'AGENDADA'   => ['CONCLUIDA', 'CANCELADA'],
            'CONCLUIDA'  => [], 
            'CANCELADA'  => [],
        ];

        return in_array($newStatus, $allowedChanges[$this->status] ?? []);

    }


}
