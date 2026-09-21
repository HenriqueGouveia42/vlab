<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao; // Importanos aqui o modelo
use App\Http\Requests\StoreSolicitacaoRequest; // Form request que valida a entrada antes de passar para o controller

class SolicitacaoController extends Controller
{
    /*
        Função responsável por criar uma nova solicitação.
        O 'Store...' no começo do nome da função é para deixar claro
        que ela cria uma nova solicitacao no banco de dados
    */
    public function store(StoreSolicitacaoRequest $request){

        $dadosValidados = $request->validated();

        $solicitacao = Solicitacao::create($dadosValidados);

        return response()->json($solicitacao, 201);

    }
}
