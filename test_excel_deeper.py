import pandas as pd
import glob

files = ["FAYB-130   LISTADO DE INVENTARIO Y PEDIDO.xlsx", "FAYB-98 SOLICITUD DE INSUMOS COCINA.xlsx"]
for f in files:
    try:
        print(f"--- FILE: {f} ---")
        for skip in [8, 12, 15]:
            print(f"Skipping {skip} rows:")
            df = pd.read_excel(f, skiprows=skip, nrows=3)
            print("Columns:", list(df.columns))
            print(df.head(1).to_string())
            print("-" * 20)
    except Exception as e:
        print(f"Error reading {f}: {e}")
