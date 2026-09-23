<?php

namespace App\Enums\Enums;

enum PrioridadeEnum: string
{
    case BAIXA = "BAIXA";
    case MEDIA = "MEDIA";
    case ALTA = "ALTA";
    case URGENTE = "URGENTE";
}
