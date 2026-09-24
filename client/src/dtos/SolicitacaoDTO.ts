export const Prioridade = {
    BAIXA: "BAIXA",
    MEDIA: "MEDIA",
    ALTA: "ALTA",
    URGENTE: "URGENTE"
} as const;

export const Status = {
    RECEBIDA: "RECEBIDA",
    EM_ANALISE: "EM_ANALISE",
    AGENDADA: "AGENDADA",
    CONCLUIDA: "CONCLUIDA",
    CANCELADA: "CANCELADA"
} as const;

export const Categoria = {
    CONSULTA: "CONSULTA",
    EXAME: "EXAME",
    VACINACAO: "VACINACAO",
    OUTRO: "OUTRO"
} as const;



export type Prioridade = typeof Prioridade[keyof typeof Prioridade];
export type Status = typeof Status[keyof typeof Status];
export type Categoria = typeof Categoria[keyof typeof Categoria]

export interface Filter {
    status: Status,
    categoria: Categoria,
    prioridade: Prioridade

}

export type SolicitacaoDTO = {
    id?: string | number,
    protocolo: string,
    solicitante: string,
    categoria: string,
    prioridade: Prioridade,
    status: Status,
    detalhes: {
        descricao: string,
        justificativa_prioridade: string,
    }
   
    criado_em: string,
}

export type CreateSolicitacaoDTO = {
    nome_solicitante: string,
    categoria: Categoria,
    prioridade: Prioridade,
    descricao: string,
    justificativa_prioridade?: string
}