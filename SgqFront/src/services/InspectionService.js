// src/services/InspectionService.js

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
            throw new Error(errorMessage);
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
        // Tratamento para payload paginado do CakePHP
        return data.itemMaster || data.itemMasters || data.data || [];
    },

    getAllChecklistTemplates: async () => {
        try {
            const data = await request('checklist-template', '/index.json');
            if (Array.isArray(data)) return data;
            return data.checklistTemplate || data.checklistTemplates || data.items || data.data || [];
        } catch (err) {
            console.warn('Erro ao buscar templates:', err);
            return [];
        }
    },

    // Retorna as definições do template
    getTemplateItems: async (checklistId, phaseId) => {
        let query = `checklist_id=${checklistId}`;
        if (phaseId) query += `&phase_id=${phaseId}`;
        
        try {
            const data = await request('template-item', `/index.json?${query}`);
            
            // DEBUG: Verifique se o backend está retornando { templateItems: [...] } ou direto [...]
            if (Array.isArray(data)) return data;
            return data.templateItems || data.templateItem || data.data || [];
        } catch (error) {
            console.error("Erro ao buscar itens do template:", error);
            return [];
        }
    },

    // Retorna os itens JÁ salvos
    getInspectionItems: async (inspectionId, phaseId = null) => {
        const params = new URLSearchParams();
        if (inspectionId) params.append('inspection_id', inspectionId);
        if (phaseId) params.append('phase_id', phaseId);
        
        try {
            const data = await request('inspection-item', `/index.json?${params.toString()}`);
            if (Array.isArray(data)) return data;
            return data.inspectionItems || data.inspectionItem || data.data || [];
        } catch (error) {
            console.error("Erro ao buscar itens salvos:", error);
            return [];
        }
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

    saveInspectionItemResults: async (itemResults) => {
        const normalized = itemResults.map(r => ({
            ...r,
            is_ok: r.is_ok === true || r.is_ok === 'true', 
        }));

        return await request('inspection-item', '/add.json', {
            method: 'POST',
            body: JSON.stringify(normalized),
        });
    }
};

export default InspectionService;