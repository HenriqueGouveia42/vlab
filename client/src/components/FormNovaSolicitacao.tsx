import { useState } from 'react';
import { Categoria, Prioridade } from '../dtos/SolicitacaoDTO';

interface FormNovaSolicitacaoProps {
    onSubmit: (dados: any) => void;
    validationErrors?: Record<string, string[]> | null;
}

export default function FormNovaSolicitacao({ onSubmit, validationErrors }: FormNovaSolicitacaoProps) {

    const [formData, setFormData] = useState<{
        nome_solicitante: string;
        categoria: Categoria | "";
        descricao: string;
        prioridade: Prioridade;
        justificativa_prioridade: string;
    }>({ 
        nome_solicitante: '', 
        categoria: "",
        descricao: '', 
        prioridade: Prioridade.BAIXA,
        justificativa_prioridade: ''
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        
        if (!formData.nome_solicitante) {
            return alert('O nome do solicitante é obrigatório.');
        }

        if(!formData.descricao){
            return alert('A descricao da solicitacao é obrigatória.')
        }

        if (formData.prioridade === Prioridade.URGENTE && !formData.justificativa_prioridade) {
            return alert('A justificativa é obrigatória para solicitações urgentes.');
        }

        onSubmit(formData);
    };

    return (
        <form className="form-solicitacao" onSubmit={handleSubmit}>
            <h3>Criar Nova Solicitação</h3>
            
            <input 
                placeholder="Nome do Solicitante *" 
                value={formData.nome_solicitante}
                onChange={e => setFormData({...formData, nome_solicitante: e.target.value})}
            />

            {validationErrors?.nome_solicitante && (
                <span style={{ color: 'red', fontSize: '12px' }}>
                    {validationErrors.nome_solicitante[0]}
                </span>
            )}
            
            <select
                value={formData.categoria}
                onChange={e => setFormData({...formData, categoria: e.target.value as Categoria})} // "... as Categoria" -> Para Typescript parar de reclamar
            >
                <option value="" disabled>Selecione a Categoria</option>
                {Object.values(Categoria).map(c => <option key={c} value={c}>{c}</option>)}
            </select>

            {validationErrors?.categoria && (
                <span style={{ color: 'red', fontSize: '12px'}}>
                    {validationErrors.categoria[0]}
                </span>
            )}
            
            <select 
                value={formData.prioridade} 
                onChange={e => setFormData({...formData, prioridade: e.target.value as Prioridade})} // "... as Prioridade" -> Para Typescript parar de reclamar
            >
                {Object.values(Prioridade).map(p => <option key={p} value={p}>{p}</option>)}
            </select>

            {validationErrors?.prioridade && (
                <span style={{ color: 'red', fontSize: '12px'}}>
                    {validationErrors.prioridade[0]}
                </span>
            )}

            <textarea 
                placeholder="Descrição da solicitação *"
                value={formData.descricao}
                onChange={e => setFormData({...formData, descricao: e.target.value})}
            />

            {validationErrors?.descricao && (
                <span style={{ color: 'red', fontSize: '12px'}}>
                    {validationErrors.descricao[0]}
                </span>
            )}

            {formData.prioridade === Prioridade.URGENTE && (
                <>

                    <textarea 
                        placeholder={`Justificativa de prioridade *`}
                        value={formData.justificativa_prioridade}
                        onChange={e => setFormData({...formData, justificativa_prioridade: e.target.value})}
                    />

                    {validationErrors?.justificativa_prioridade && (
                        <span style={{ color: 'red', fontSize: '12px'}}>
                            {validationErrors.justificativa_prioridade[0]}
                        </span>
                    )}

                </>
                
                
                
            )}

            <button type="submit">Salvar Solicitação</button>
        </form>
    );
}