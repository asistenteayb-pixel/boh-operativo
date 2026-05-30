import csv
import sys
try:
    import pandas as pd
    import glob

    files = glob.glob("*.xlsx")
    for f in files:
        try:
            print(f"--- FILE: {f} ---")
            df = pd.read_excel(f, nrows=5)
            print("Columns:", list(df.columns))
        except Exception as e:
            print(f"Error reading {f}: {e}")

except ImportError:
    print("pandas not installed")

try:
    print("--- FILE: insumos_rows.csv ---")
    with open("insumos_rows.csv", newline='', encoding='utf-8') as f:
        reader = csv.reader(f)
        for i, row in enumerate(reader):
            if i < 3:
                print(row)
            else:
                break
except Exception as e:
    print(f"Error reading csv: {e}")
