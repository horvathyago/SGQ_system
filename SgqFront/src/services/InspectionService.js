/**
 * src/services/InspectionService.js
 */

const BASE_URL = import.meta.env.VITE_API_BASE_URL;

const request = async (controllerName, endpoint, options = {}) => {
    const CONTROLLER_URL = `${BASE_URL}/${controllerName}`;
    const defaultHeaders = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    };

    const config = {
        ...options,
        headers: {
            ...defaultHeaders,
            ...options.headers,
        },
        credentials: 'include',
    };

    try {
        const response = await fetch(`${CONTROLLER_URL}${endpoint}`, config);
        let data = {};
        let text = '';
        
        try {
            text = await response.text();
            data = text ? JSON.parse(text) : {};
        } catch (e) {
            data = { _rawText: text };
        }

        if (!response.ok) {
            const errorMessage = data.message || `Erro HTTP: ${response.status} ${response.statusText}`;
            const error = new Error(errorMessage);
            error.responseData = data;
            if (response.status === 422 && data.errors) {
                error.validationErrors = data.errors;
            }
            error.status = response.status;
            throw error;
        }

        return data;

    } catch (error) {
        console.error(`Erro na requisição para ${controllerName}${endpoint}:`, error);
        throw error;
    }
};

const InspectionService = {
    getAllItemMasters: async () => {
        const data = await request('item-master', '/index.json');
        if (Array.isArray(data)) return data;
        return data.itemMaster || data.itemMasters || data.data || [];
    },

    getAllChecklistTemplates: async () => {
        try {
            const data = await request('checklist-template', '/index.json');
            // Normalização de retorno do CakePHP (pode vir paginado ou não)
            if (Array.isArray(data)) return data;
            if (Array.isArray(data.checklistTemplate)) return data.checklistTemplate;
            if (Array.isArray(data.checklistTemplates)) return data.checklistTemplates;
            if (Array.isArray(data.items)) return data.items;
            return [];
        } catch (err) {
            console.warn('Erro ao buscar templates, tentando endpoint plural...', err);
            // Fallback
            return [];
        }
    },

    // Retorna as definições do template (o que deve ser inspecionado)
    getTemplateItems: async (checklistId, phaseId) => {
        let query = `checklist_id=${checklistId}`;
        if (phaseId) query += `&phase_id=${phaseId}`;
        
        const data = await request('template-item', `/index.json?${query}`);
        // Normalização
        return data.templateItems || data.templateItem || data.data || [];
    },

    // Retorna os itens JÁ salvos (resultados)
    getInspectionItems: async (inspectionId, phaseId = null) => {
        const params = new URLSearchParams();
        if (inspectionId) params.append('inspection_id', inspectionId);
        if (phaseId) params.append('phase_id', phaseId);
        
        const data = await request('inspection-item', `/index.json?${params.toString()}`);
        return data.inspectionItems || data.inspectionItem || data.data || [];
    },

    createInspection: async (inspectionData) => {
        const data = await request('inspection', '/add.json', {
            method: 'POST',
            body: JSON.stringify(inspectionData),
        });
        return data.inspection || data;
    },

    updateInspectionStatus: async (id, updateData) => {
        const data = await request('inspection', `/edit/${id}.json`, {
            method: 'PATCH',
            body: JSON.stringify(updateData),
        });
        return data.inspection || data;
    },

    // Salva resultados em Batch
    saveInspectionItemResults: async (itemResults) => {
        // Pequena normalização para garantir que o backend receba booleanos corretos
        const normalized = itemResults.map(r => ({
            ...r,
            is_ok: r.is_ok === true || r.is_ok === 'true', 
            // Garante que o ID seja enviado se for uma edição, ou removido se for criação nova (embora o add() geralmente trate criação)
            // No caso do InspectionItemController::add batch, ele cria novos. 
            // Para edição em massa, o ideal seria deletar e recriar ou ter lógica de upsert no backend.
            // Assumindo aqui estratégia de "Upsert" ou que o backend trata duplicidade.
        }));

        return await request('inspection-item', '/add.json', {
            method: 'POST',
            body: JSON.stringify(normalized),
        });
    }
};

export default InspectionService;