<template id="tpl-tabla-reqs">
        <div class="h-full flex flex-col bg-white border border-slate-200 rounded-2xl shadow-sm max-w-7xl mx-auto overflow-hidden">
            <div class="p-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h3 class="font-black text-lg text-slate-800" id="tb-tit"><i class="fas fa-database text-cp-blue mr-2"></i> Auditoría Operativa <span class="bg-slate-200 text-slate-600 text-[10px] px-2 py-0.5 rounded-md ml-2 font-mono">ISO: BOH-01</span></h3>
                    <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider hidden sm:inline">Trazabilidad Total</span>
                </div>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-2 text-slate-400 text-xs"></i>
                    <input type="text" id="busqueda-auditoria" placeholder="Filtrar radicados, áreas, etc..." class="pl-8 pr-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none focus:border-cp-blue w-64 shadow-sm" onkeyup="window.smartSearch('busqueda-auditoria', '#tabla-historico tr', ['.radicado', '.solicita', '.area', '.estado'])">
                </div>
            </div>
            <div class="flex-1 overflow-x-auto overflow-y-auto p-2">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 border-b border-slate-200 sticky top-0 z-10">
                        <tr><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Radicado</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Solicita</th><th class="p-3 font-bold uppercase tracking-wider text-[10px] text-cp-blue">Autoriza/Despacha</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Ãrea/Serv</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Tiempos</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Ciclo</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Estado</th></tr>
                    </thead>
                    <tbody id="tabla-historico" class="divide-y divide-slate-100 text-slate-700"></tbody>
                </table>
            </div>
        </div>
    </template>