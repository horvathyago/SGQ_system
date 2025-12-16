import React, { useEffect, useState, useCallback } from "react";
import Sidebar from "../components/Dashboard/Sidebar"; // Ajuste o caminho se necessário
import PecasToolbar from "../components/Pecas/PecasToolbar";
import PecasList from "../components/Pecas/PecasList";
import PecaForm from "../components/Pecas/PecasForm";
import PecasService from "../services/pecasService";

export default function PecasPage() {
  const [pecas, setPecas] = useState([]);
  const [loading, setLoading] = useState(true);
  const [errorMsg, setErrorMsg] = useState(""); // Novo estado para erros visuais

  // Estados de Filtro
  const [query, setQuery] = useState("");
  const [filters, setFilters] = useState({ family: "all", status: "all" });
  const [page, setPage] = useState(1);
  const [pageSize] = useState(12);
  const [total, setTotal] = useState(0);

  // Estados do Modal
  const [modalOpen, setModalOpen] = useState(false);
  const [editing, setEditing] = useState(null);

  const loadPecas = useCallback(async () => {
    setLoading(true);
    setErrorMsg("");
    
    try {
      const params = {
        q: query,
        family: filters.family,
        status: filters.status,
        page,
        pageSize
      };

      // Chama o service
      const response = await PecasService.fetchAll(params);
      
      console.log("State Atualizado com:", response.data);
      
      setPecas(response.data || []);
      setTotal(response.total || 0);

    } catch (err) {
      console.error("Erro no Page:", err);
      setErrorMsg("Não foi possível carregar os dados. Verifique o console.");
      setPecas([]);
    } finally {
      setLoading(false);
    }
  }, [query, filters, page, pageSize]);

  // Carrega ao iniciar
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
        setPage(1); // Volta pro início para ver o novo item
      }
      setModalOpen(false);
      loadPecas();
    } catch (err) {
      alert("Erro ao salvar: " + (err.message || "Erro desconhecido"));
    }
  }

  async function handleDelete(id) {
    if (!window.confirm("Deseja realmente excluir este item?")) return;
    try {
      await PecasService.remove(id);
      loadPecas();
    } catch (err) {
      alert("Erro ao deletar.");
    }
  }

  return (
    <div className="flex min-h-screen bg-slate-950 text-slate-200 font-sans">
      {/* Sidebar Fixa */}
      <Sidebar />

      {/* Conteúdo Principal (padding-left para compensar a sidebar fixa) */}
      <main className="ml-72 w-full p-8 transition-all duration-300">
        <div className="max-w-[1600px] mx-auto">
          
          {/* Cabeçalho */}
          <header className="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 border-b border-slate-800 pb-6">
            <div>
              <span className="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-1 block">Recursos</span>
              <h1 className="text-3xl font-bold text-white tracking-tight">Catálogo de Itens</h1>
            </div>

            <div className="flex items-center gap-3">
               <input
                 type="text"
                 value={query}
                 onChange={(e) => setQuery(e.target.value)}
                 className="bg-slate-900 border border-slate-700 text-slate-200 text-sm rounded-lg px-4 py-2 w-64 focus:border-indigo-500 outline-none"
                 placeholder="Buscar..."
               />
               <button
                  onClick={openCreate}
                  className="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2 rounded-lg font-bold transition-all"
               >
                  + Novo Item
               </button>
            </div>
          </header>

          {/* Área de Erro (se houver) */}
          {errorMsg && (
            <div className="mb-6 p-4 bg-red-900/20 border border-red-500/50 text-red-200 rounded-lg">
                {errorMsg}
            </div>
          )}

          {/* Filtros e Toolbar */}
          <div className="bg-slate-900 border border-slate-800 rounded-t-xl p-4 mb-0 flex justify-between items-center">
             <div className="flex gap-4">
                {/* Seus selects de filtro aqui (family/status) */}
             </div>
             <PecasToolbar total={total} page={page} pageSize={pageSize} setPage={setPage} />
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

      {/* Modal */}
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