import React, { useState, useEffect } from "react";

export default function PecaForm({ initial = null, onClose = () => {}, onSave = async () => {} }) {
  const [code, setCode] = useState("");
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const [status, setStatus] = useState("active");
  const [weight, setWeight] = useState("");
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState("");

  useEffect(() => {
    if (initial) {
      setCode(initial.code ?? "");
      setTitle(initial.title ?? "");
      setDescription(initial.description ?? "");
      setStatus(initial.status ?? "active");
      setWeight(initial.weight ?? "");
    } else {
      setCode("");
      setTitle("");
      setDescription("");
      setStatus("active");
      setWeight("");
    }
  }, [initial]);

  async function submit(e) {
    e.preventDefault();
    setError("");
    if (saving) return;

    if (!code || !code.trim()) {
      setError("O código da peça é obrigatório.");
      return;
    }

    const payload = {
      code: code.trim(),
      title: title.trim(),
      description: description.trim(),
      status,
      weight: weight ? weight : undefined,
    };

    setSaving(true);
    try {
      await onSave(payload);
    } catch (err) {
      let errorMessage = err?.message || "Erro ao salvar peça.";
      if (err?.body?.message) {
          errorMessage = err.body.message;
      } else if (err?.body?.errors?.codigo_item) {
          errorMessage = `Código: ${err.body.errors.codigo_item.join(", ")}`;
      }
      setError(errorMessage);
    } finally {
      setSaving(false);
    }
  }

  // Styles reused
  const labelClass = "block text-[10px] uppercase font-bold text-slate-500 tracking-wider mb-1.5";
  const inputClass = "w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600 transition-colors";

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
      {/* Backdrop */}
      <div className="absolute inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" onClick={onClose}></div>
      
      {/* Modal Content */}
      <form onSubmit={submit} className="relative bg-slate-900 border border-slate-800 rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
        
        {/* Modal Header */}
        <div className="px-6 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-900">
            <h2 className="text-lg font-bold text-white tracking-tight">
                {initial ? "Editar Item do Catálogo" : "Novo Item"}
            </h2>
            <button type="button" onClick={onClose} className="text-slate-500 hover:text-white transition-colors">
                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {/* Modal Body */}
        <div className="p-6 space-y-4">
            {error && (
                <div className="p-3 bg-rose-950/30 border border-rose-900/50 rounded-lg flex items-center gap-3 text-rose-300 text-sm">
                    <svg className="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {error}
                </div>
            )}

            <div className="grid grid-cols-2 gap-5">
            <div>
                <label className={labelClass}>Código *</label>
                <input 
                    value={code} 
                    onChange={(e) => setCode(e.target.value)} 
                    className={`${inputClass} font-mono`}
                    placeholder="Ex: MP-0012"
                    autoFocus 
                />
            </div>

            <div>
                <label className={labelClass}>Título</label>
                <input 
                    value={title} 
                    onChange={(e) => setTitle(e.target.value)} 
                    className={inputClass}
                    placeholder="Nome curto do item"
                />
            </div>

            <div className="col-span-2">
                <label className={labelClass}>Descrição Técnica</label>
                <textarea 
                    value={description} 
                    onChange={(e) => setDescription(e.target.value)} 
                    className={inputClass} 
                    rows={3} 
                    placeholder="Especificações, material, dimensões..."
                />
            </div>

            <div>
                <label className={labelClass}>Peso (kg)</label>
                <input 
                    value={weight} 
                    onChange={(e) => setWeight(e.target.value)} 
                    className={inputClass} 
                    type="number" step="0.01"
                />
            </div>

            <div>
                <label className={labelClass}>Status</label>
                <select value={status} onChange={(e) => setStatus(e.target.value)} className={inputClass}>
                    <option value="active">Ativo</option>
                    <option value="inactive">Inativo (Obsoleto)</option>
                </select>
            </div>
            </div>
        </div>

        {/* Modal Footer */}
        <div className="px-6 py-4 bg-slate-950 border-t border-slate-800 flex items-center justify-end gap-3">
          <button 
            type="button" 
            onClick={onClose} 
            className="px-4 py-2 rounded-lg border border-slate-700 text-slate-300 hover:bg-slate-800 hover:text-white text-sm font-medium transition-colors"
          >
            Cancelar
          </button>
          <button 
            type="submit" 
            disabled={saving} 
            className="px-6 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold shadow-lg shadow-indigo-500/20 disabled:opacity-50 transition-all"
          >
            {saving ? "Salvando..." : "Salvar Alterações"}
          </button>
        </div>
      </form>
    </div>
  );
}