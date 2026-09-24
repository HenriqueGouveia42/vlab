import React, { useState } from 'react';
import { Status, Prioridade, type SolicitacaoDTO } from '../dtos/SolicitacaoDTO';

interface FilteredListProps {
    filtros:{
        status: string;
        categoria: string;
        prioridade: string
    };
    setFiltros: React.Dispatch<React.SetStateAction<{
        status: string;
        categoria: string;
        prioridade: string
    }>>;
    loading: boolean;
    solicitacoes: SolicitacaoDTO[];
    handleMudarStatus: (id: string, novoStatus: Status) => void;
    page: number;
    setPage: React.Dispatch<React.SetStateAction<number>>;
}

function LinhaSolicitacao({ solicitacao, onMudarStatus }: { solicitacao: SolicitacaoDTO, onMudarStatus: (id: string, status: Status) => void }) {
    
    const [detalhesAbertos, setDetalhesAbertos] = useState(false);

    return (
        <React.Fragment>
            <tr 
                style={{ backgroundColor: solicitacao.status === 'CONCLUIDA' ? '#8f8f8f' : undefined }}>
                <td>{solicitacao.solicitante}</td>
                <td>{solicitacao.categoria}</td>
                <td><span className={`badge ${solicitacao.prioridade}`}>{solicitacao.prioridade}</span></td>
                <td>{solicitacao.status}</td>
                <td>
                    <select 
                        value={solicitacao.status} 
                        onChange={(e) => onMudarStatus(solicitacao.id!.toString(), e.target.value as Status)}
                        className="select-status"
                        style={{ marginRight: '10px' }}
                    >
                        {Object.values(Status).map(s => <option key={s} value={s}>{s}</option>)}
                    </select>
                    
                    <button onClick={() => setDetalhesAbertos(!detalhesAbertos)} className="btn-detalhes">
                        {detalhesAbertos ? "Esconder detalhes" : "Mais detalhes"}
                    </button>
                </td>
            </tr>

            {detalhesAbertos && (
                <tr className="linha-detalhes" style={{ backgroundColor: '#f9f9f9' }}>
                    <td colSpan={5} style={{ padding: '15px', textAlign: 'left' }}>
                        <p><strong>Protocolo:</strong> {solicitacao.protocolo || 'N/A'}</p>
                        <p><strong>Descrição:</strong> {solicitacao.detalhes.descricao || 'Nenhuma descrição fornecida.'}</p>
                        
                        {solicitacao.detalhes.justificativa_prioridade && (
                            <p><strong>Justificativa (Prioridade):</strong> {solicitacao.detalhes.justificativa_prioridade}</p>
                        )}
                    </td>
                </tr>
            )}
        </React.Fragment>
    );
}

export default function FilteredList(props: FilteredListProps) {
    const { filtros, setFiltros, loading, solicitacoes, handleMudarStatus, page, setPage } = props;

    const irParaPaginaAnterior = () => setPage(p => p - 1);
    const irParaProximaPagina = () => setPage(p => p + 1);

    return(
        <div className="lista-section">
            <div className="filtros">
                <select value={filtros.status} onChange={e => setFiltros({...filtros, status: e.target.value})}>
                    <option value="">Todos os Status</option>
                    {Object.values(Status).map(s => <option key={s} value={s}>{s}</option>)}
                </select>
                <select value={filtros.prioridade} onChange={e => setFiltros({...filtros, prioridade: e.target.value})}>
                    <option value="">Todas as Prioridades</option>
                    {Object.values(Prioridade).map(p => <option key={p} value={p}>{p}</option>)}
                </select>
            </div>
        
            {loading && (
                <p className="feedback-loading">Buscando solicitações...</p>
            )}

            {!loading && solicitacoes.length === 0 && (
                <p className="feedback-empty">Nenhuma solicitação encontrada com esses filtros.</p>
            )}

            {!loading && solicitacoes.length > 0 && (
                <table className="tabela-solicitacoes">
                    <thead>
                        <tr>
                            <th>Solicitante</th>
                            <th>Categoria</th>
                            <th>Prioridade</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {solicitacoes.map(solicitacao => (
                            <LinhaSolicitacao 
                                key={solicitacao.id} 
                                solicitacao={solicitacao} 
                                onMudarStatus={handleMudarStatus} 
                            />
                        ))}
                    </tbody>
                </table>
            )}
        
            <div className="paginacao">
                <button disabled={page === 1} onClick={irParaPaginaAnterior}>Anterior</button>
                <span>Página {page}</span>
                <button onClick={irParaProximaPagina}>Próxima</button>
            </div>
        </div>
    );
}