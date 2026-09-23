<?php

namespace App\Enums;

enum StatusSolicitacaoEnum: string
{
    case RECEBIDA = 'RECEBIDA';
    case EM_ANALISE = 'EM_ANALISE';
    case AGENDADA = 'AGENDADA';
    case CONCLUIDA = 'CONCLUIDA';
    case CANCELADA = 'CANCELADA';
}
