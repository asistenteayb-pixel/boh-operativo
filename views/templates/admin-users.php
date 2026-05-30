<template id="tpl-admin-users">
        <div class="flex flex-col lg:flex-row gap-6 h-full max-w-7xl mx-auto">
            <div class="w-full lg:w-1/3 bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col overflow-hidden h-fit">
                <div class="p-4 border-b border-slate-100 bg-slate-50 font-black text-slate-800 flex items-center" id="form-user-title"><i class="fas fa-user-plus text-cp-blue mr-2 text-lg"></i> Crear Usuario</div>
                <div class="p-6 space-y-4 bg-white">
                    <input type="hidden" id="nu-id">
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Nombre Completo</label><input type="text" id="nu-nom" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-cp-blue mt-1"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Usuario Login</label><input type="text" id="nu-log" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-cp-blue mt-1"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">ContraseÃ±a</label><input type="password" id="nu-pwd" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-cp-blue mt-1"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Rol en el Sistema</label><select id="nu-rol" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-cp-blue bg-white mt-1"><option value="cocinero">Personal de Cocina</option><option value="control_cocina">Control Cocina</option><option value="admin">Administrador</option></select></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Ãrea / Cargo Real</label><input type="text" id="nu-area" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-cp-blue mt-1" placeholder="Ej: ReposterÃ­a"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Turno</label><input type="text" id="nu-turno" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-cp-blue mt-1"></div>
                    <div class="flex gap-3 pt-4"><button onclick="window.guardarUsuario()" id="btn-save-usr" class="flex-1 bg-cp-blue hover:bg-cp-blue-hover text-white font-bold text-sm py-3 rounded-xl shadow-md transition">GUARDAR</button><button onclick="window.limpiarFormUsuario()" class="bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold text-sm py-3 px-4 rounded-xl transition"><i class="fas fa-times"></i></button></div>
                </div>
            </div>
            <div class="flex-1 bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col overflow-hidden">
                <div class="p-4 border-b border-slate-100 bg-slate-50 font-black text-slate-800 flex justify-between items-center">
                    <div><i class="fas fa-users text-slate-400 mr-2 text-lg"></i> Directorio de Personal <span class="bg-slate-200 text-slate-600 text-[10px] px-2 py-0.5 rounded-md ml-2 font-mono">ISO: HR-12</span></div>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-2 text-slate-400 text-xs"></i>
                        <input type="text" id="busqueda-usuarios" placeholder="Buscar usuario..." class="pl-8 pr-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none focus:border-cp-blue w-64" onkeyup="window.smartSearch('busqueda-usuarios', '#tbl-usuarios-list tr', ['td:nth-child(2)', 'td:nth-child(3)', 'td:nth-child(4)', 'td:nth-child(5)'])">
                    </div>
                </div>
                <div class="flex-1 overflow-auto p-2">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
                            <tr><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Avatar</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Nombre</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Login</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Rol</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Ãrea</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Estado</th><th class="p-3 font-bold uppercase tracking-wider text-[10px] text-center">AcciÃ³n</th></tr>
                        </thead>
                        <tbody id="tbl-usuarios-list" class="divide-y divide-slate-100"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </template>