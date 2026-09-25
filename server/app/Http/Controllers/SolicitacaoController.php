<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexSolicitacaoRequest;
use App\Http\Requests\PatchStatusRequest;
use App\Models\Solicitacao; // Importanos aqui o modelo
use App\Http\Requests\StoreSolicitacaoRequest; // Form request que valida a entrada antes de passar para o controller
use App\Http\Resources\SolicitacaoResource; //Contrato de saída da API

class SolicitacaoController extends Controller
{
    /**
     * Criar Solicitação
     *
     * @response 422 {
     *   "message": "Os dados fornecidos são inválidos.",
     *   "errors": {
     *     "categoria": ["Categoria inválida"]
     *   }
     * }
     * @response 400 {
     *   "message": "Justificativa é obrigatória para prioridade URGENTE"
     * }
     */
    public function store(StoreSolicitacaoRequest $request){

        $dadosValidados = $request->validated();
        $solicitacao = Solicitacao::create($dadosValidados);
        return new SolicitacaoResource($solicitacao);

    }

    /**
     * Listar Solicitações
     * 
     * Retorna uma lista paginada de solicitações, aceitando filtros.
    */
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

    /**
     * Exibir Solicitação
     *
     * @response 404 {
     *   "message": "Record not found."
     * }
    */
    public function show(string $id){
        $solicitacao = Solicitacao::findOrFail($id);
        return new SolicitacaoResource($solicitacao);
    }

    /**
     * Atualizar Status
     *
     * @response 422 {
     *   "message": "O status selecionado é invalido.",
     *   "errors": {
     *     "status": ["O status selecionado é invalido."]
     *   }
     * }
     * @response 400 {
     *   "message": "Mudanca de status de CONCLUIDA para EM_ANALISE nao permitida."
     * }
     * @response 404 {
     *   "message": "Solicitacao nao encontrada"
     * }
     */
    public function updateStatus(PatchStatusRequest $request, string $id){
        $solicitacao = Solicitacao::findOrFail($id);
        $solicitacao->updateStatus($request->status);
        return new SolicitacaoResource($solicitacao);

    }
}
