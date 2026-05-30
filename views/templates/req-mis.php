<template id="tpl-req-mis">
        <div class="h-full flex flex-col bg-white rounded-2xl shadow-sm border border-slate-200 max-w-5xl mx-auto overflow-hidden">
            <div class="p-4 border-b border-slate-100 bg-slate-50 font-black text-lg text-slate-800 flex justify-between items-center">
                <div class="flex items-center gap-3"><i class="fas fa-check-double text-emerald-500 text-2xl"></i> RecepciÃ³n de Insumos</div>
            </div>
            <div class="flex-1 overflow-y-auto p-6 bg-slate-50/50">
                <div id="mis-pedidos-container" class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start content-start"></div>
            </div>
        </div>
    </template>