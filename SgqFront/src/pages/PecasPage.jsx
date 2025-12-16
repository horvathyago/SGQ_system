import React, { useEffect, useState, useCallback } from "react";
import Sidebar from "../components/Dashboard/Sidebar";
import PecasToolbar from "../components/Pecas/PecasToolbar";
import PecasList from "../components/Pecas/PecasList";
import PecaForm from "../components/Pecas/PecasForm";
import PecasService from "../services/pecasService";

export default function PecasPage() {
  const [pecas, setPecas] = useState([]);
  const [loading, setLoading] = useState(true);
  const [errorMsg, setErrorMsg] = useState("");

  // --- LÓGICA DE PESQUISA INTELIGENTE ---
  const [query, setQuery] = useState(""); 
  const [debouncedQuery, setDebouncedQuery] = useState("");

  // Delay de 500ms para não travar enquanto digita
  useEffect(() => {
    const timer = setTimeout(() => {
      setDebouncedQuery(query);
      if (query !== debouncedQuery) setPage(1); 
    }, 500);
    return () => clearTimeout(timer);
  }, [query]);

  // Filtros e Paginação
  const [filters, setFilters] = useState({ family: "all", status: "all" });
  const [page, setPage] = useState(1);
  const [pageSize] = useState(12);
  const [total, setTotal] = useState(0);

  // Modal
  const [modalOpen, setModalOpen] = useState(false);
  const [editing, setEditing] = useState(null);

  const loadPecas = useCallback(async () => {
    setLoading(true);
    setErrorMsg("");
    
    try {
      // Se tiver busca, aumentamos o limite para garantir que o item apareça
      // Se não tiver busca, usamos a paginação normal (12 itens)
      const isSearching = debouncedQuery.trim().length > 0;
      const currentLimit = isSearching ? 1000 : pageSize; 

      const params = {
        q: debouncedQuery, 
        family: filters.family,
        status: filters.status,
        page: isSearching ? 1 : page, // Na busca, sempre busca na pág 1
        pageSize: currentLimit
      };

      const response = await PecasService.fetchAll(params);
      let list = response.data || [];

      // --- FILTRAGEM NO FRONTEND (GARANTIA) ---
      // Se o usuário digitou algo, filtramos a lista manualmente para garantir
      // que o resultado bata com 'titulo' OU 'codigo_item'
      if (isSearching) {
        const term = debouncedQuery.toLowerCase();
        list = list.filter(item => {
            const code = String(item.codigo_item || item.code || "").toLowerCase();
            const title = String(item.titulo || item.title || "").toLowerCase();
            return code.includes(term) || title.includes(term);
        });
      }

      setPecas(list);
      
      // Se estiver buscando, o total é o tamanho da lista filtrada. 
      // Se não, é o total do banco.
      setTotal(isSearching ? list.length : (response.total || 0));

    } catch (err) {
      console.error("Erro no Page:", err);
      setErrorMsg("Erro ao carregar itens.");
      setPecas([]);
    } finally {
      setLoading(false);
    }
  }, [debouncedQuery, filters, page, pageSize]);

  useEffect(() => {
    loadPecas();
  }, [loadPecas]);

  // Funções do Modal
  function openCreate() {
    setEditing(null);
    setModalOpen(true);
  }

  function openEdit(peca) {
    setEditing(peca);
    setModalOpen(true);
  }

  async function handleSave(payload) {
    try {
      if (editing?.id) {
        await PecasService.update(editing.id, payload);
      } else {
        await PecasService.create(payload);
        setPage(1); 
      }
      setModalOpen(false);
      loadPecas();
    } catch (err) {
      alert("Erro ao salvar: " + (err.message || "Erro desconhecido"));
    }
  }

  async function handleDelete(id) {
    if (!window.confirm("Deseja excluir este item?")) return;
    try {
      await PecasService.remove(id);
      loadPecas();
    } catch (err) {
      alert("Erro ao deletar.");
    }
  }

  return (
    <div className="flex min-h-screen bg-slate-950 text-slate-200 font-sans">
      <Sidebar />

      <main className="ml-72 w-full p-8 transition-all duration-300">
        <div className="max-w-[1600px] mx-auto">
          
          {/* Header */}
          <header className="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 border-b border-slate-800 pb-6">
            <div>
              <span className="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-1 block">Recursos</span>
              <h1 className="text-3xl font-bold text-white tracking-tight">Catálogo de Itens</h1>
            </div>

            <div className="flex items-center gap-3">
               {/* CAMPO DE PESQUISA */}
               <div className="relative">
                 <input
                   type="text"
                   value={query}
                   onChange={(e) => setQuery(e.target.value)}
                   className="bg-slate-900 border border-slate-700 text-slate-200 text-sm rounded-lg px-4 py-2 w-72 focus:border-indigo-500 outline-none placeholder-slate-600 transition-all focus:w-80"
                   placeholder="Pesquisar Nome ou Código..."
                 />
                 {/* Spinner de loading da busca */}
                 {query !== debouncedQuery && (
                    <div className="absolute right-3 top-2.5">
                        <div className="w-4 h-4 border-2 border-indigo-500/30 border-t-indigo-500 rounded-full animate-spin"></div>
                    </div>
                 )}
                 {/* Ícone de Lupa (quando não está carregando) */}
                 {query === debouncedQuery && (
                    <div className="absolute right-3 top-2.5 pointer-events-none text-slate-500">
                        <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                 )}
               </div>

               <button
                  onClick={openCreate}
                  className="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2 rounded-lg font-bold transition-all shadow-lg shadow-indigo-500/20"
               >
                  + Novo Item
               </button>
            </div>
          </header>

          {/* Mensagem de Erro */}
          {errorMsg && (
            <div className="mb-6 p-4 bg-red-900/20 border border-red-500/50 text-red-200 rounded-lg">
                {errorMsg}
            </div>
          )}

          {/* Barra de Ferramentas / Filtros */}
          <div className="bg-slate-900 border border-slate-800 rounded-t-xl p-4 mb-0 flex justify-between items-center">
             <div className="flex gap-4">
                {/* Espaço reservado para filtros extras se precisar no futuro */}
             </div>
             {/* Toolbar só exibe paginação se não estiver buscando (busca filtra tudo numa página só) */}
             {!query && (
                <PecasToolbar total={total} page={page} pageSize={pageSize} setPage={setPage} />
             )}
             {query && (
                <span className="text-xs text-slate-400 font-medium">
                    Encontrados: <strong className="text-indigo-400">{pecas.length}</strong> resultados para "{debouncedQuery}"
                </span>
             )}
          </div>

          {/* Lista */}
          <div className="bg-slate-900 border-x border-b border-slate-800 rounded-b-xl overflow-hidden shadow-sm">
             <PecasList 
                data={pecas} 
                loading={loading} 
                onEdit={openEdit} 
                onDelete={handleDelete} 
             />
          </div>
        </div>
      </main>

      {modalOpen && (
        <PecaForm
          initial={editing}
          onClose={() => setModalOpen(false)}
          onSave={handleSave}
        />
      )}
    </div>
  );
}