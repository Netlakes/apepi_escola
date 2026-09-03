import zipfile
import os

theme_dir = r"d:\antigravity_projects\apepi_escola\temas\apepi-escola"
zip_path = r"d:\antigravity_projects\apepi_escola\apepi-escola.zip"

if os.path.exists(zip_path):
    os.remove(zip_path)

with zipfile.ZipFile(zip_path, 'w', zipfile.ZIP_DEFLATED) as zipf:
    for root, dirs, files in os.walk(theme_dir):
        for file in files:
            full_path = os.path.join(root, file)
            rel_path = os.path.relpath(full_path, theme_dir)
            arcname = os.path.join("apepi-escola", rel_path).replace("\\", "/")
            zipf.write(full_path, arcname)

print("ZIP criado com sucesso em:", zip_path)
