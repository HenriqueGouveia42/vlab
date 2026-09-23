<?php

namespace App\Enums\Enums;

enum CategoriaEnum: string
{
    case CONSULTA = "CONSULTA";
    case EXAME = "EXAME";
    case VACINACAO = "VACINACAO";   
    case OUTRO = "OUTRO";
}
