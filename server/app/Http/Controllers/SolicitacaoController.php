<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Solicitacao; // Importanos aqui o modelo
use App\Http\Requests\StoreSolicitacaoRequest; // Form request que valida a entrada antes de passar para o controller

class SolicitacaoController extends Controller
{
    public function store(StoreSolicitacaoRequest $request){

        $dadosValidados = $request->validated();

        $solicitacao = Solicitacao::create($dadosValidados);

        return response()->json($solicitacao, 201);

    }
}
