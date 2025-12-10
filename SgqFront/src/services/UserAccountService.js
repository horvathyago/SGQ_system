/**
 * src/services/UserAccountService.js
 * * Serviço responsável por comunicar com todas as rotas do UserAccountController.
 */

// URL base definida no .env (http://localhost:8765)
const BASE_URL = import.meta.env.VITE_API_BASE_URL;

// Nome do Controller na URL (Padrão do CakePHP para UserAccountController)
// Se você mudar as rotas no CakePHP, ajuste aqui (ex: '/user-accounts')
const CONTROLLER_URL = `${BASE_URL}/user-account`;

/**
 * Helper genérico para fazer as requisições (DRY - Don't Repeat Yourself)
 * Gerencia headers, credenciais (cookies) e tratamento básico de erros.
 */
const request = async (endpoint, options = {}) => {
    // Configurações padrão
    const defaultHeaders = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    };

    // Mescla as opções
    const config = {
        ...options,
        headers: {
            ...defaultHeaders,
            ...options.headers,
        },
        // 🌟 IMPORTANTE: Garante o envio de Cookies de sessão para manter o login
        credentials: 'include', 
    };

    try {
        const response = await fetch(`${CONTROLLER_URL}${endpoint}`, config);
        
        // Tenta fazer o parse do JSON (se houver corpo na resposta)
        let data = {};
        try {
            data = await response.json();
        } catch (e) {
            // Se não for JSON (ex: 204 No Content), data continua vazio
        }

        // Verifica erros HTTP
        if (!response.ok) {
            // Se a API retornou uma mensagem de erro, usa ela. Senão, usa status text.
            const errorMessage = data.message || `Erro HTTP: ${response.status} ${response.statusText}`;
            
            // Se for erro de validação (422), anexa os erros detalhados
            const error = new Error(errorMessage);
            if (response.status === 422 && data.errors) {
                error.validationErrors = data.errors;
            }
            error.status = response.status;
            throw error;
        }

        return data;

    } catch (error) {
        console.error(`Erro na requisição para ${endpoint}:`, error);
        throw error;
    }
};

const UserAccountService = {

    // =========================================================================
    // AUTENTICAÇÃO
    // =========================================================================

    /**
     * [POST] Realiza o login.
     * Endpoint: /user-account/login.json
     * @param {object} credentials - { email: "...", password: "..." }
     */
    login: async (credentials) => {
        const data = await request('/login.json', {
            method: 'POST',
            body: JSON.stringify(credentials),
        });
        return data.user; // Retorna os dados do usuário
    },

    /**
     * [GET] Verifica o status da sessão.
     * Endpoint: /user-account/status.json
     */
    checkStatus: async () => { // 🌟 FUNÇÃO ADICIONADA
        const data = await request('/status.json');
        // O CakePHP retorna { "user": {...} }, então acessamos a propriedade 'user'.
        return data.user; 
    },
    
    /**
     * [POST] Realiza o logout.
     * Endpoint: /user-account/logout.json
     */
    logout: async () => {
        return await request('/logout.json', {
            method: 'POST',
        });
    },

    // =========================================================================
    // CRUD COMPLETO (Baseado nas ações do Controller)
    // =========================================================================

    /**
     * [GET] Lista todos os usuários (Index).
     * Endpoint: /user-account/index.json (ou apenas /user-account.json)
     */
    getAll: async () => {
        const data = await request('/index.json'); 
        // O CakePHP geralmente retorna { userAccounts: [...] } no index
        return data.userAccounts || [];
    },

    /**
     * [GET] Busca um usuário pelo ID (View).
     * Endpoint: /user-account/view/{id}.json
     * @param {number|string} id 
     */
    getById: async (id) => {
        const data = await request(`/view/${id}.json`);
        // O CakePHP retorna { userAccount: {...} } no view
        return data.userAccount;
    },

    /**
     * [POST] Cria um novo usuário (Add).
     * Endpoint: /user-account/add.json
     * @param {object} userData - { nome, email, password, role, etc }
     */
    create: async (userData) => {
        const data = await request('/add.json', {
            method: 'POST',
            body: JSON.stringify(userData),
        });
        // Retorna o usuário criado
        return data.userAccount;
    },

    /**
     * [PUT/PATCH] Atualiza um usuário existente (Edit).
     * Endpoint: /user-account/edit/{id}.json
     * @param {number|string} id 
     * @param {object} userData - Dados a serem atualizados
     */
    update: async (id, userData) => {
        const data = await request(`/edit/${id}.json`, {
            method: 'PUT', // Ou 'PATCH', dependendo da preferência
            body: JSON.stringify(userData),
        });
        return data.userAccount;
    },

    /**
     * [DELETE] Remove um usuário (Delete).
     * Endpoint: /user-account/delete/{id}.json
     * @param {number|string} id 
     */
    remove: async (id) => {
        // Geralmente DELETE não retorna corpo, ou retorna 204
        return await request(`/delete/${id}.json`, {
            method: 'DELETE',
        });
    }
};

export default UserAccountService;