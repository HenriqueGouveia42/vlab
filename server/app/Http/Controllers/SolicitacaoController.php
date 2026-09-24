<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexSolicitacaoRequest;
use App\Http\Requests\PatchStatusRequest;
use App\Models\Solicitacao; // Importanos aqui o modelo
use App\Http\Requests\StoreSolicitacaoRequest; // Form request que valida a entrada antes de passar para o controller
use App\Http\Resources\SolicitacaoResource; //Contrato de saída da API

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

        return new SolicitacaoResource($solicitacao);

    }

    public function index(IndexSolicitacaoRequest $request){

        $query = Solicitacao::query();

        // filtro por status
        if($request->filled('status')){
            $query->where('status', $request->status);
        }

        // filtro por categoria
        if($request->filled('categoria')){
            $query->where('categoria', $request->categoria);
        }

        // filtro por prioridade
        if($request->filled('prioridade')){
            $query->where('prioridade', $request->prioridade);
        }

        $solicitacoes = $query->paginate(10);

        //return response()->json($solicitacoes);
        return SolicitacaoResource::collection($solicitacoes);

    }

    public function show(string $id){

        $solicitacao = Solicitacao::findOrFail($id);

        return new SolicitacaoResource($solicitacao);

    }

    public function updateStatus(PatchStatusRequest $request, string $id){

        $solicitacao = Solicitacao::findOrFail($id);

        try{

            $solicitacao->updateStatus($request->status);

            //return response()->json($solicitacao);
            return new SolicitacaoResource($solicitacao);

        }catch(\Exception $e){
            return response()->json(['erro' => $e->getMessage()], 422);
        }

    }
}
