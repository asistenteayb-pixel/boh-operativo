import pandas as pd
import csv

out_sql = open('populate_data.sql', 'w', encoding='utf-8')

# 1. CREATE USERS
out_sql.write("-- INSERT USERS\n")
out_sql.write("INSERT INTO usuarios (nombre_completo, usuario_login, pwd, rol, activo) VALUES \n")
out_sql.write("('Cocinero Solicitante', 'cocina', 'cocina123', 'cocinero', TRUE),\n")
out_sql.write("('Bodeguero Control', 'bodega', 'bodega123', 'control_cocina', TRUE);\n\n")

# 2. INSERT INSUMOS
out_sql.write("-- INSERT INSUMOS\n")
try:
    df_insumos = pd.read_csv("insumos_rows.csv")
    if not df_insumos.empty:
        out_sql.write("INSERT INTO insumos (id_insumo, codigo_interno, nombre, unidad_medida, categoria, formato, costo_est, areas_destino, activo) VALUES \n")
        values = []
        for index, row in df_insumos.iterrows():
            id_insumo = str(row.get('id_insumo', ''))
            cod = str(row.get('codigo_interno', '')).replace("'", "\\'")
            nom = str(row.get('nombre', '')).replace("'", "\\'")
            um = str(row.get('unidad_medida', '')).replace("'", "\\'")
            cat = str(row.get('categoria', '')).replace("'", "\\'")
            form = str(row.get('formato', '')).replace("'", "\\'")
            costo = str(row.get('costo_unitario', '0'))
            if costo == 'nan' or costo == '': costo = '0'
            areas = str(row.get('areas_destino', '')).replace("'", "\\'")
            if areas == 'nan': areas = ''
            activo = "TRUE" if str(row.get('activo', 'true')).lower() == 'true' else "FALSE"
            
            val = f"({id_insumo}, '{cod}', '{nom}', '{cat}', '{form}', '{um}', {costo}, '{areas}', {activo})"
            values.append(val)
        
        out_sql.write(",\n".join(values) + "\nON DUPLICATE KEY UPDATE nombre=VALUES(nombre), costo_est=VALUES(costo_est);\n\n")
except Exception as e:
    print(f"Error processing insumos: {e}")

# 3. INSERT RECETAS
out_sql.write("-- INSERT RECETAS\n")
try:
    df_recetas = pd.read_excel("FICHAS_LE_PLACE_2026_FINAL.xlsx")
    # Col 0: Nombre, Col 1: Costo
    col_name = df_recetas.columns[0]
    out_sql.write("INSERT INTO recetas (nombre) VALUES \n")
    values = []
    # Add the column name itself since it seems to be the first recipe
    name = str(col_name).replace("'", "\\'")
    values.append(f"('{name}')")
    
    for index, row in df_recetas.iterrows():
        name = str(row[col_name]).replace("'", "\\'")
        values.append(f"('{name}')")
        
    out_sql.write(",\n".join(values) + ";\n\n")
except Exception as e:
    print(f"Error processing recetas: {e}")

out_sql.close()
print("SQL file generated successfully.")
