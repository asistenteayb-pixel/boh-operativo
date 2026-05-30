import re
import os

with open('index.html', 'r', encoding='utf-8') as f:
    html = f.read()

# Find all templates
templates = re.findall(r'(<template id="tpl-([^"]+)">(.*?)</template>)', html, re.DOTALL)

for full_match, tpl_name, content in templates:
    # Save to views/templates/
    with open(f'views/templates/{tpl_name}.php', 'w', encoding='utf-8') as tf:
        tf.write(f'<template id="tpl-{tpl_name}">{content}</template>')
    
    # Replace in original html with include
    html = html.replace(full_match, f"<?php include '../views/templates/{tpl_name}.php'; ?>")

# Fix API_PROXY_URL
html = html.replace("new URL('api/proxy.php', window.location.href)", "new URL('../src/api/proxy.php', window.location.href)")

with open('public/index.php', 'w', encoding='utf-8') as f:
    f.write(html)

print("Split completed.")
