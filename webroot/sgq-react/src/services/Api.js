const API_BASE = '/api'; // prefixo para CakePHP API

async function request(endpoint, options = {}) {
  const url = `${API_BASE}/${endpoint}.json`;
  const defaultOptions = {
    credentials: 'include',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
  };

  const merged = {
    ...defaultOptions,
    ...options,
    headers: {
      ...defaultOptions.headers,
      ...(options.headers || {}),
    },
  };

  try {
    const res = await fetch(url, merged);
    const text = await res.text();
    const data = text ? JSON.parse(text) : null;

    if (!res.ok) {
      const error = new Error('API error');
      error.status = res.status;
      error.data = data;
      throw error;
    }

    return data;
  } catch (err) {
    throw new Error(err.message || 'Network error');
  }
}

// Autenticação
export const login = (credentials) =>
  request('login', { method: 'POST', body: JSON.stringify(credentials) });

export const logout = () =>
  request('user-account/logout', { method: 'POST' });

// Tarefas
export const getTasks = () => request('tasks', { method: 'GET' });
export const addTask = (payload) =>
  request('tasks/add', { method: 'POST', body: JSON.stringify(payload) });
export const updateTask = (id, payload) =>
  request(`tasks/edit/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
export const deleteTask = (id) => request(`tasks/delete/${id}`, { method: 'DELETE' });

// Perfil de usuário
export const getProfile = () => request('user-account/profile', { method: 'GET' });
export const updateProfile = (payload) =>
  request('user-account/edit', { method: 'PUT', body: JSON.stringify(payload) });
