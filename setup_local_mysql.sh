#!/bin/sh
set -eu

MYSQL_BIN="${MYSQL_BIN:-/Applications/XAMPP/xamppfiles/bin/mysql}"
MYSQL_SOCKET="${MYSQL_SOCKET:-/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock}"
MYSQL_USER="${MYSQL_USER:-root}"

"$MYSQL_BIN" --socket="$MYSQL_SOCKET" -u"$MYSQL_USER" < database_schema.sql
"$MYSQL_BIN" --socket="$MYSQL_SOCKET" -u"$MYSQL_USER" < migration_supabase_compat.sql
"$MYSQL_BIN" --socket="$MYSQL_SOCKET" -u"$MYSQL_USER" < seed_operational_data.sql
"$MYSQL_BIN" --socket="$MYSQL_SOCKET" -u"$MYSQL_USER" < seed_excel_catalog.sql
"$MYSQL_BIN" --socket="$MYSQL_SOCKET" -u"$MYSQL_USER" < seed_menu_programado.sql

echo "BOH local MySQL listo."
