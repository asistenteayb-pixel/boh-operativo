<template id="tpl-bodega">
        <div class="h-full flex flex-col max-w-7xl mx-auto">
            <div class="flex-1 bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col overflow-hidden">
                <div class="p-4 border-b border-slate-100 bg-slate-50 font-black text-lg text-slate-800 flex justify-between items-center">
                    <div class="flex items-center gap-3"><i class="fas fa-boxes text-cp-blue text-2xl"></i> Control Bodega / Despachos</div>
                    <span id="alert-demora" class="hidden text-xs bg-red-100 text-red-600 px-3 py-1.5 rounded-full border border-red-200 font-bold animate-pulse flex items-center gap-2"><i class="fas fa-siren-on"></i> ALERTA SLA</span>
                </div>
                <div class="flex-1 overflow-y-auto p-6 bg-slate-50/50">
                    <div id="bodega-board" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start content-start"></div>
                </div>
            </div>
        </div>
    </template>