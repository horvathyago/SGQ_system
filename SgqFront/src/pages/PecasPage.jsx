// src/pages/PecasPage.jsx
import React, { useEffect, useState, useCallback } from "react";
import Sidebar from "../components/Dashboard/Sidebar";
import PecasToolbar from "../components/Pecas/PecasToolbar";
import PecasList from "../components/Pecas/PecasList";
import PecaForm from "../components/Pecas/PecasForm";
import PecasService from "../services/pecasService";

export default function PecasPage() {
  const [pecas, setPecas] = useState([]);
  const [loading, setLoading] = useState(true);
  const [query, setQuery] = useState("");
  const [filters, setFilters] = useState({ family: "all", status: "all" });
  const [page, setPage] = useState(1);
  const [pageSize] = useState(12);
  const [total, setTotal] = useState(0);

  const [modalOpen, setModalOpen] = useState(false);
  const [editing, setEditing] = useState(null);

  const loadPecas = useCallback(async (opts = {}) => {
    setLoading(true);
    try {
      const params = { q: query, ...filters, page, pageSize, ...opts };
      const res = await PecasService.fetchAll(params);
      const list = res.data ?? [];
      setPecas(list);
      setTotal(typeof res.total === "number" ? res.total : list.length);
    } catch (err) {
      console.error("[PecasPage] Erro ao buscar:", err);
      setPecas([]);
      setTotal(0);
    } finally {
      setLoading(false);
    }
  }, [query, filters, page, pageSize]);

  useEffect(() => {
    loadPecas();
  }, [loadPecas]);

  function openCreate() {
    setEditing(null);
    setModalOpen(true);
  }

  function openEdit(peca) {
    setEditing(peca);
    setModalOpen(true);
  }

  async function handleSave(pecaPayload) {
    try {
      if (editing) {
        const updated = await PecasService.update(editing.id, pecaPayload);
        if (updated) {
           await loadPecas(); 
        }
      } else {
        await PecasService.create(pecaPayload);
        if (page !== 1) setPage(1);
        else await loadPecas();
      }
      setModalOpen(false);
    } catch (err) {
      console.error("Erro save:", err);
      alert(err?.message || "Erro ao salvar item.");
    }
  }

  async function handleDelete(id) {
    if (!window.confirm("Esta ação removerá o item do catálogo. Confirmar?")) return;
    try {
      await PecasService.remove(id);
      await loadPecas();
    } catch (err) {
      alert("Erro ao remover item.");
    }
  }

  return (
    <div className="min-h-screen bg-slate-950 text-slate-200 font-sans">
      <Sidebar />

      <main className="pl-72 w-full transition-all duration-300">
        <div className="max-w-[1600px] mx-auto p-8">
          
          {/* Header */}
          <header className="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 border-b border-slate-800 pb-6">
            <div>
              <span className="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-1 block">Recursos</span>
              <h1 className="text-3xl font-bold text-white tracking-tight">Catálogo de Itens</h1>
              <p className="text-sm text-slate-400 mt-1">Gestão de Peças, Materiais e Componentes Mestres.</p>
            </div>

            <div className="flex items-center gap-3">
               {/* Campo de Busca */}
               <div className="relative group">
                  <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg className="h-4 w-4 text-slate-500 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                       <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </div>
                  <input
                    type="text"
                    value={query}
                    onChange={(e) => { setQuery(e.target.value); setPage(1); }}
                    className="bg-slate-900 border border-slate-700 text-slate-200 text-sm rounded-lg focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 block w-64 pl-10 p-2.5 placeholder-slate-600 transition-all"
                    placeholder="Buscar código ou nome..."
                  />
               </div>

               <button
                  onClick={openCreate}
                  className="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2.5 rounded-lg font-semibold shadow-lg shadow-indigo-500/20 transition-all active:scale-95"
               >
                  <span className="text-lg leading-none mb-0.5">+</span>
                  <span>Novo Item</span>
               </button>
            </div>
          </header>

          {/* Filtros e Toolbar */}
          <div className="bg-slate-900 border border-slate-800 rounded-t-xl p-4 flex flex-wrap gap-4 items-center justify-between">
             <div className="flex gap-4 w-full md:w-auto">
                <div className="relative">
                   <span className="absolute -top-2 left-2 bg-slate-900 px-1 text-[10px] font-bold text-slate-500 uppercase">Família</span>
                   <select
                      value={filters.family}
                      onChange={(e) => setFilters({ ...filters, family: e.target.value })}
                      className="bg-slate-950 border border-slate-700 text-slate-300 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-40 p-2"
                    >
                      <option value="all">Todas</option>
                      <option value="Família A">Família A</option>
                      <option value="Família B">Família B</option>
                    </select>
                </div>
                <div className="relative">
                   <span className="absolute -top-2 left-2 bg-slate-900 px-1 text-[10px] font-bold text-slate-500 uppercase">Status</span>
                   <select
                      value={filters.status}
                      onChange={(e) => setFilters({ ...filters, status: e.target.value })}
                      className="bg-slate-950 border border-slate-700 text-slate-300 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-40 p-2"
                    >
                      <option value="all">Todos</option>
                      <option value="active">Ativo</option>
                      <option value="inactive">Inativo</option>
                    </select>
                </div>
             </div>

             <PecasToolbar total={total} page={page} pageSize={pageSize} setPage={setPage} />
          </div>

          {/* Lista de Dados */}
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