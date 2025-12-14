/**
 * src/services/InspectionService.js
 * Serviço responsável por comunicar com as rotas dos Controladores de Inspeção.
 */

// URL base definida no .env (http://localhost:8765)
const BASE_URL = import.meta.env.VITE_API_BASE_URL;

/**
 * Helper genérico para fazer as requisições (DRY - Don't Repeat Yourself)
 */
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
            // não-JSON: mantemos text em data._rawText para diagnóstico
            data = { _rawText: text };
        }

        if (!response.ok) {
            const errorMessage = data.message || `Erro HTTP: ${response.status} ${response.statusText}`;
            const error = new Error(errorMessage);
            // attach parsed body for callers to inspect
            error.responseData = data;
            if (response.status === 422 && data.errors) {
                error.validationErrors = data.errors;
            }
            error.status = response.status;
            throw error;
        }

        return data;

    } catch (error) {
        // mantém log detalhado para debug
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

    getItemMasterById: async (id) => {
        const data = await request('item-master', `/view/${id}.json`);
        return data.itemMaster;
    },

    // NOVO/MELHORADO: busca todos os Checklist Templates para popular o select na UI
    getAllChecklistTemplates: async () => {
        // tentativa padrão
        try {
            const data = await request('checklist-template', '/index.json');
            if (Array.isArray(data)) return data;
            if (Array.isArray(data.checklistTemplate)) return data.checklistTemplate;
            if (Array.isArray(data.checklistTemplates)) return data.checklistTemplates;
            if (Array.isArray(data.data)) return data.data;
            // se objeto único com chave 'items'
            if (Array.isArray(data.items)) return data.items;
            // fallback: se for objeto com uma única propriedade array, retorna
            const arr = Object.values(data).find(v => Array.isArray(v));
            if (arr) return arr;
            // vazio
            return [];
        } catch (err) {
            // Se falhar, tentamos endpoint alternativo sem controller prefix (algumas APIs usam plural)
            console.warn('getAllChecklistTemplates: tentativa padrão falhou, tentando endpoint alternativo...', err);
            try {
                const altData = await request('checklist-templates', '/index.json');
                if (Array.isArray(altData)) return altData;
                if (Array.isArray(altData.checklistTemplate)) return altData.checklistTemplate;
                if (Array.isArray(altData.checklistTemplates)) return altData.checklistTemplates;
                if (Array.isArray(altData.data)) return altData.data;
                const arr = Object.values(altData).find(v => Array.isArray(v));
                if (arr) return arr;
                return [];
            } catch (err2) {
                // retornamos erro para o componente lidar (ele exibirá retry)
                console.error('getAllChecklistTemplates: todas tentativas falharam', err2);
                throw err2;
            }
        }
    },

    getChecklistTemplate: async (id) => {
        const data = await request('checklist-template', `/view/${id}.json`);
        return data.checklistTemplate;
    },

    getTemplateItems: async (checklistId, phaseId) => {
        // 🚨 CORREÇÃO DE ROBUSTEZ: Usar URLSearchParams para codificar os parâmetros de forma segura.
        const params = new URLSearchParams();
        if (checklistId) params.append('checklist_id', checklistId);
        if (phaseId) params.append('phase_id', phaseId);
        
        const endpoint = params.toString() ? `/index.json?${params.toString()}` : '/index.json';
        
        // Log detalhado para debug da requisição
        console.debug(`[InspectionService] Fetching TemplateItems: template-item${endpoint}`);
        
        const data = await request('template-item', endpoint);
        return data.templateItem || data.templateItems || data.data || [];
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
        const normalized = itemResults.map(r => {
            const clone = { ...r };
            if (Object.prototype.hasOwnProperty.call(clone, 'result_value')) {
                clone.measured_value = clone.result_value;
                delete clone.result_value;
            }
            if (typeof clone.is_ok !== 'boolean') {
                if (clone.is_ok === 'OK' || clone.is_ok === 'ok' || clone.is_ok === 'true') clone.is_ok = true;
                else if (clone.is_ok === 'NC' || clone.is_ok === 'nc' || clone.is_ok === 'false') clone.is_ok = false;
            }
            return clone;
        });

        return await request('inspection-item', '/add.json', {
            method: 'POST',
            body: JSON.stringify(normalized),
        });
    },

    getInspectionItems: async (inspectionId, phaseId = null) => {
        const params = new URLSearchParams();
        if (inspectionId) params.append('inspection_id', inspectionId);
        if (phaseId) params.append('phase_id', phaseId);
        const endpoint = `/index.json?${params.toString()}`;
        const data = await request('inspection-item', endpoint);
        return data.inspectionItems || data.inspectionItem || data.data || [];
    },

    isPhaseComplete: async (inspectionId, phaseId, templateItems = []) => {
        const savedItems = await InspectionService.getInspectionItems(inspectionId, phaseId);
        if (!savedItems || savedItems.length === 0) return false;

        const templateMap = (templateItems || []).reduce((acc, t) => {
            acc[t.id] = t;
            return acc;
        }, {});

        for (const it of savedItems) {
            if (it.is_ok === null || typeof it.is_ok === 'undefined') return false;
            const template = templateMap[it.template_item_id] || {};
            const tipo = template.tipo_medicao || it.tipo_medicao || null;
            if (tipo === 'QUANTITATIVA') {
                if (!it.measured_value || String(it.measured_value).trim() === '') return false;
            }
            if (it.is_ok === false) {
                if ((!it.measured_value || String(it.measured_value).trim() === '') &&
                    (!it.comentario || String(it.comentario).trim() === '')) return false;
            }
        }

        return true;
    }
};

export default InspectionService;