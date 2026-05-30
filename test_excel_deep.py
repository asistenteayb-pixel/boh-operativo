import pandas as pd
import glob

files = glob.glob("*.xlsx")
for f in files:
    try:
        print(f"--- FILE: {f} ---")
        df = pd.read_excel(f, skiprows=5, nrows=10)
        print("Columns:", list(df.columns))
        print(df.head(3).to_string())
        print("\n")
    except Exception as e:
        print(f"Error reading {f}: {e}")
