import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useApi } from '../hooks/useApi';
import { type SolicitacaoDTO, Status } from '../dtos/SolicitacaoDTO';
import FilteredList from './FilteredList';
import FormNovaSolicitacao from './FormNovaSolicitacao';

export default function Dashboard() {
    const navigate = useNavigate();
    const { loading, error, validationErrors, getSolicitacoes, atualizarStatus, criarSolicitacao } = useApi();
    
    const [solicitacoes, setSolicitacoes] = useState<SolicitacaoDTO[]>([]);
    const [page, setPage] = useState(1);
    const [filtros, setFiltros] = useState({ status: '', categoria: '', prioridade: '' });
    const [view, setView] = useState<'lista' | 'nova'>('lista');

    const carregarDados = async () => {
        const res = await getSolicitacoes(page, filtros.status, filtros.categoria, filtros.prioridade);
        if (res && res.data) setSolicitacoes(res.data);
    };

    useEffect(() => {
        carregarDados();
    }, [page, filtros]);

    const handleMudarStatus = async (id: string, novoStatus: Status) => {
        const sucesso = await atualizarStatus(id, novoStatus);
        if(sucesso){
            carregarDados();
        }
    };

    return (
        <div className="dashboard-container">
            <header className="dashboard-header">
                <button onClick={() => navigate("/")}>
                    Sair do App
                </button>
                <h2>Sistema de Solicitações</h2>
                <nav>
                    <button 
                        onClick={() => setView('lista')}
                        className={view === 'lista' ? 'active' : ''}
                    >
                        Listagem
                    </button>
                    <button 
                        onClick={() => setView('nova')}
                        className={view === 'nova' ? 'active' : ''}
                    >
                        Nova Solicitação
                    </button>
                </nav>
            </header>

            <main className="dashboard-content">
                {error && <div className="feedback-error">Erro: {error}</div>}
        
                {view === 'lista' ? (
                    <FilteredList 
                        filtros={filtros}
                        setFiltros={setFiltros}
                        loading={loading}
                        solicitacoes={solicitacoes}
                        handleMudarStatus={handleMudarStatus}
                        page={page}
                        setPage={setPage}
                    />
                ) : (
                    <FormNovaSolicitacao
                        validationErrors={validationErrors} 
                        onSubmit={async (dados) => {
                            await criarSolicitacao(dados);
                            setView('lista');
                            carregarDados();
                        }} 
                    />
                )}
            </main>
        </div>
    );
}