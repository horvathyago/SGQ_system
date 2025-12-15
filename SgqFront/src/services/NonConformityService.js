// src/services/NonConformityService.js

const BASE_URL = import.meta.env.VITE_API_BASE_URL;

// Função auxiliar de request (idêntica ao seu InspectionService para manter consistência)
const request = async (controllerName, endpoint, options = {}) => {
    // Nota: O CakePHP geralmente usa "dashed-case" na URL. 
    // Se o controller é NonConformity, a rota definida foi 'non-conformity'
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
            // Tenta pegar erro de validação do CakePHP ou mensagem genérica
            const errorMessage = data.message || `Erro HTTP: ${response.status} ${response.statusText}`;
            throw new Error(errorMessage);
        }

        return data;

    } catch (error) {
        console.error(`Erro na requisição para ${controllerName}${endpoint}:`, error);
        throw error;
    }
};

const NonConformityService = {
    // Lista todas as NCs
    getAll: async () => {
        try {
            const data = await request('non-conformity', '/index.json');
            // O CakePHP retorna { nonConformity: [...] } devido ao set(compact('nonConformity'))
            if (Array.isArray(data)) return data;
            return data.nonConformity || data.data || [];
        } catch (error) {
            console.error("Erro ao buscar não conformidades:", error);
            return [];
        }
    },

    // Pega detalhes de uma NC específica
    getById: async (id) => {
        const data = await request('non-conformity', `/view/${id}.json`);
        return data.nonConformity || data;
    },

    // Cria uma nova NC
    create: async (ncData) => {
        const data = await request('non-conformity', '/add.json', {
            method: 'POST',
            body: JSON.stringify(ncData),
        });
        return data.nonConformity || data;
    },

    // Atualiza uma NC existente
    update: async (id, ncData) => {
        const data = await request('non-conformity', `/edit/${id}.json`, {
            method: 'PUT', // ou PATCH
            body: JSON.stringify(ncData),
        });
        return data.nonConformity || data;
    },

    // Deleta uma NC
    delete: async (id) => {
        await request('non-conformity', `/delete/${id}.json`, {
            method: 'DELETE',
        });
        return true;
    }
};

export default NonConformityService;