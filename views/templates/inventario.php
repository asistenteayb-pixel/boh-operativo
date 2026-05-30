<template id="tpl-inventario">
        <div class="h-full flex flex-col max-w-7xl mx-auto">
            <div id="inv-home" class="flex-1 p-4 grid grid-cols-1 md:grid-cols-2 gap-6 items-start content-start">
                <div class="col-span-full mb-2">
                    <h2 class="text-2xl font-black text-slate-800">Formatos e Inventarios</h2>
                    <p class="text-slate-500">Seleccione el formato que desea diligenciar o consultar.</p>
                </div>

                <div onclick="window.abrirHistorial('FAYB')" class="bg-white border border-slate-200 p-8 rounded-2xl shadow-sm hover-card cursor-pointer group flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform"><i class="fas fa-clipboard-list text-4xl text-cp-blue"></i></div>
                    <h3 class="text-xl font-black text-slate-800 mb-2">LISTADO DE INVENTARIO Y PEDIDO</h3>
                    <p class="text-sm text-slate-500">Abarrotes, CÃ¡rnicos, LÃ¡cteos, Granos, Enlatados y Congelados.</p>
                    <div class="mt-6 text-cp-blue font-bold text-xs bg-blue-50 px-4 py-2 rounded-full">INGRESAR AL HISTORIAL <i class="fas fa-arrow-right ml-1"></i></div>
                </div>

                <div onclick="window.abrirHistorial('FRUVER')" class="bg-white border border-slate-200 p-8 rounded-2xl shadow-sm hover-card cursor-pointer group flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform"><i class="fas fa-leaf text-4xl text-emerald-500"></i></div>
                    <h3 class="text-xl font-black text-slate-800 mb-2">Formato FRUVER</h3>
                    <p class="text-sm text-slate-500">Frutas, Verduras, TubÃ©rculos, Hierbas y Vegetales Frescos.</p>
                    <div class="mt-6 text-emerald-600 font-bold text-xs bg-emerald-50 px-4 py-2 rounded-full">INGRESAR AL HISTORIAL <i class="fas fa-arrow-right ml-1"></i></div>
                </div>
            </div>

            <div id="view-historial" class="hidden flex-1 flex flex-col bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden no-print">
                <div class="p-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center flex-shrink-0">
                    <div class="flex items-center gap-4">
                        <button onclick="window.volverInvHome()" class="w-8 h-8 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-cp-blue hover:border-cp-blue transition"><i class="fas fa-arrow-left"></i></button>
                        <div>
                            <h3 class="font-black text-lg text-slate-800" id="historial-title">Registros</h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase" id="historial-subtitle">Historial de Tomas</p>
                        </div>
                    </div>
                    <button onclick="window.abrirFormularioNuevo()" class="bg-cp-blue hover:bg-cp-blue-hover transition text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center"><i class="fas fa-plus mr-2"></i> CREAR NUEVO REGISTRO DEL DÃA</button>
                </div>
                <div class="flex-1 overflow-auto p-2 bg-slate-50">
                    <table class="w-full text-left text-xs bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm">
                        <thead class="bg-slate-50 text-slate-500 border-b border-slate-100"><tr><th class="p-3 font-semibold uppercase">Formulario</th><th class="p-3 font-semibold uppercase">Fecha</th><th class="p-3 font-semibold uppercase">Responsable</th><th class="p-3 font-semibold uppercase text-center">AcciÃ³n</th></tr></thead>
                        <tbody id="tbl-historial-list" class="divide-y divide-slate-50 text-slate-700"></tbody>
                    </table>
                </div>
            </div>

            <div id="view-detalle" class="hidden flex-1 flex flex-col bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden absolute inset-0 z-10">
                <div class="p-4 border-b border-slate-200 bg-white flex justify-between items-center flex-shrink-0 no-print flex-wrap gap-2">
                    <button onclick="window.volverAlHistorialActual()" class="text-slate-500 hover:text-cp-blue font-bold text-xs flex items-center bg-slate-50 px-3 py-1.5 rounded-lg border transition"><i class="fas fa-arrow-left mr-2"></i> Volver</button>
                    <div class="font-black text-base text-slate-800" id="detalle-title">FECHA</div><div class="text-[10px] text-slate-500 font-bold ml-2">codigo: FAYB-130 V:0 22/10/2025</div>
                    <div class="flex gap-2">
                        <button onclick="window.calcularPedidoInteligente()" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-sm transition flex items-center gap-2"><i class="fas fa-magic"></i> CALCULAR PEDIDO (F.S)</button>
                        <button onclick="window.exportarExcelFormulario()" class="bg-slate-100 text-slate-700 border border-slate-200 hover:bg-slate-200 px-4 py-2 rounded-xl text-xs font-bold shadow-sm transition"><i class="fas fa-file-excel mr-1"></i> EXCEL</button>
                        <button onclick="window.guardarFormularioDetalle()" id="btn-guardar-form" class="bg-cp-blue hover:bg-cp-blue-hover text-white px-6 py-2 rounded-xl text-xs font-bold shadow-md transition"><i class="fas fa-cloud-upload-alt mr-2"></i> GUARDAR EN NUBE</button>
                    </div>
                </div>
                <div class="bg-slate-50 p-3 border-b border-slate-100 flex items-center justify-between flex-shrink-0 no-print">
                    <span class="text-[11px] px-2 font-bold flex items-center gap-2" id="form-alerta-readonly"><i class="fas fa-edit text-cp-blue text-lg"></i> Digite las cantidades en las casillas.</span>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-2 text-slate-400"></i>
                        <input type="text" id="inv-search-detalle" placeholder="Filtrar insumo..." class="text-xs border border-slate-300 rounded-full py-1.5 pl-8 pr-3 outline-none focus:border-cp-blue w-64 shadow-sm" onkeyup="window.filterFormDetalle()">
                    </div>
                </div>
                <div class="flex-1 overflow-auto bg-white p-2">
                    <h1 id="print-header-title" class="hidden print-title">FORMATO</h1><p id="print-header-date" class="hidden print-title text-sm font-normal mb-4 text-center"></p>
                    <table class="w-full table-dense text-[11px]" id="tabla-exportable-form">
                        <thead class="bg-slate-100"><tr id="form-headers"><th class="w-20 text-center border-x border-t border-slate-200">CÃ³digo</th><th class="border-t border-slate-200">DescripciÃ³n del ArtÃ­culo</th><th class="w-20 text-center border-x border-t border-slate-200">Unidad</th><th class="w-32 text-center bg-yellow-50 text-yellow-800 border-x border-t border-slate-200"><i class="fas fa-boxes mr-1"></i> Toma FÃ­sica</th><th class="w-32 text-center bg-blue-50 text-blue-800 border-x border-t border-slate-200"><i class="fas fa-shopping-cart mr-1"></i> Pedido</th></tr></thead>
                        <tbody id="tbl-form-detalle" class="divide-y divide-slate-100"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </template>