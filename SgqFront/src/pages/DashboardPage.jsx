import React, { useEffect, useState } from "react";
import Header from "../components/Dashboard/Header";
import Sidebar from "../components/Dashboard/Sidebar";
import KpiCard from "../components/Dashboard/KpiCard";
import TrendChart from "../components/Dashboard/TrendChart";
import BreakdownChart from "../components/Dashboard/BreakdownChart";
import RecentTable from "../components/Dashboard/RecentTable";
import DetailPanel from "../components/Dashboard/DetailPanel";


/**
 * Página: Dashboard principal
 * Path: src/pages/DashboardPage.jsx
 *
 * Observações:
 * - Rota já definida após login conforme seu comentário.
 * - Adapte endpoints em src/services/dashboardApi.js se necessário.
 */

export default function DashboardPage() {
  const [summary, setSummary] = useState(null);
  const [trends, setTrends] = useState([]);
  const [breakdown, setBreakdown] = useState([]);
  const [recent, setRecent] = useState({ data: [], meta: {} });
  const [loading, setLoading] = useState(true);
  const [selected, setSelected] = useState(null);
  const [filters, setFilters] = useState({
    period: "30d",
    product: "All",
    line: "All",
    owner: "All",
  });

  useEffect(() => {
    let mounted = true;
    async function loadAll() {
      setLoading(true);
      try {
        // Buscar resumo e cards + tendências + breakdowns + recentes (paralelo)
        const [sumRes, trendsRes, breakRes, recentRes] = await Promise.all([
          api.fetchSummary(filters),
          api.fetchTrends("inspections", filters),
          api.fetchBreakdown("nc_type", filters),
          api.fetchRecent("inspections", 1, 10, filters),
        ]);
        if (!mounted) return;
        setSummary(sumRes);
        setTrends(trendsRes);
        setBreakdown(breakRes);
        setRecent(recentRes);
      } catch (err) {
        console.error("Erro carregando dashboard:", err);
      } finally {
        if (mounted) setLoading(false);
      }
    }
    loadAll();
    return () => {
      mounted = false;
    };
  }, [filters]);

  function handleApplyFilters(newFilters) {
    setFilters((prev) => ({ ...prev, ...newFilters }));
  }

  return (
    <div className="min-h-screen flex bg-neutral-900 text-gray-100">
      <Sidebar />

      <div className="flex-1 p-6">
        <Header onApplyFilters={handleApplyFilters} filters={filters} />

        <div className="mt-6 space-y-6">
          {/* KPI row */}
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <KpiCard
              title="Inspeções (30d)"
              value={summary?.inspections ?? "—"}
              onClick={() => console.log("Filtro: inspections")}
            />
            <KpiCard
              title="Checklists concluídos"
              value={summary?.checklists ?? "—"}
              onClick={() => console.log("Filtro: checklists")}
            />
            <KpiCard
              title="NCs abertas"
              value={summary?.openNC ?? "—"}
              accent="red"
              onClick={() => console.log("Filtro: openNC")}
            />
            <KpiCard
              title="Taxa de conformidade"
              value={summary ? `${summary.compliance}%` : "—"}
              accent="green"
            />
            <KpiCard
              title="Calibração vencida"
              value={summary?.calibOverdue ?? "—"}
              accent="yellow"
            />
          </div>

          {/* Charts */}
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div className="lg:col-span-2 bg-[#0f1720] rounded-xl p-4 border border-white/5 shadow">
              <h3 className="text-sm font-semibold text-gray-200 mb-2">
                Tendência — Inspeções / NCs
              </h3>
              <TrendChart data={trends} loading={loading} />
            </div>

            <div className="space-y-4">
              <div className="bg-[#0f1720] rounded-xl p-4 border border-white/5 shadow">
                <h4 className="text-sm font-semibold text-gray-200 mb-2">NCs por tipo</h4>
                <BreakdownChart data={breakdown} type="donut" />
              </div>

              <div className="bg-[#0f1720] rounded-xl p-4 border border-white/5 shadow">
                <h4 className="text-sm font-semibold text-gray-200 mb-2">Itens mais problemáticos</h4>
                <BreakdownChart data={breakdown} type="bars" />
              </div>
            </div>
          </div>

          {/* Recent table + detail panel */}
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div className="lg:col-span-2 bg-[#0f1720] rounded-xl p-4 border border-white/5 shadow">
              <h3 className="text-sm font-semibold text-gray-200 mb-2">Atividades recentes</h3>
              <RecentTable data={recent.data} loading={loading} onOpen={(row) => setSelected(row)} />
            </div>

            <div>
              <DetailPanel item={selected} />
            </div>
          </div>
        </div>

        {/* floating action */}
        <button
          className="fixed right-10 bottom-10 w-14 h-14 rounded-full bg-gradient-to-br from-red-500 to-pink-500 text-white shadow-lg flex items-center justify-center text-2xl"
          title="Criar"
          onClick={() => (window.location.href = "/inspections/new")}
        >
          +
        </button>
      </div>
    </div>
  );
}