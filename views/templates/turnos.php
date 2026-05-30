<template id="tpl-turnos">
        <div class="h-full flex flex-col max-w-7xl mx-auto gap-4">
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h2 class="text-xl font-black text-slate-800"><i class="fas fa-user-clock text-cp-gold mr-2"></i> Horario de Turnos</h2>
                    <p class="text-xs text-slate-500">Vista operativa del personal de cocina.</p>
                </div>
                <div class="flex items-end gap-2">
                    <div><label class="text-[10px] uppercase text-slate-500 font-bold">Desde</label><input id="turno-desde" type="date" class="border border-slate-300 rounded-lg px-3 py-2 text-xs"></div>
                    <div><label class="text-[10px] uppercase text-slate-500 font-bold">Hasta</label><input id="turno-hasta" type="date" class="border border-slate-300 rounded-lg px-3 py-2 text-xs"></div>
                    <button onclick="window.cargarTurnos()" class="bg-cp-blue hover:bg-cp-blue-hover text-white px-4 py-2 rounded-lg text-xs font-bold"><i class="fas fa-sync-alt mr-1"></i> Actualizar</button>
                    <button onclick="window.abrirKioskTurnos()" class="bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-lg text-xs font-bold"><i class="fas fa-display mr-1"></i> Kiosk</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3" id="turnos-kpis"></div>

            <div class="flex-1 bg-white border border-slate-200 rounded-2xl shadow-sm overflow-auto">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 sticky top-0 z-10">
                        <tr>
                            <th class="p-3 text-left uppercase tracking-wide text-[10px] text-slate-500">Fecha</th>
                            <th class="p-3 text-left uppercase tracking-wide text-[10px] text-slate-500">Colaborador</th>
                            <th class="p-3 text-left uppercase tracking-wide text-[10px] text-slate-500">Cargo</th>
                            <th class="p-3 text-left uppercase tracking-wide text-[10px] text-slate-500">Ãrea</th>
                            <th class="p-3 text-left uppercase tracking-wide text-[10px] text-slate-500">Turno</th>
                            <th class="p-3 text-left uppercase tracking-wide text-[10px] text-slate-500">Horario</th>
                            <th class="p-3 text-left uppercase tracking-wide text-[10px] text-slate-500">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody id="turnos-body" class="divide-y divide-slate-100"></tbody>
                </table>
            </div>
        </div>
    </template>