import os
import zipfile

theme_dir = r"d:\antigravity_projects\apepi_escola\apepi-escolao"

targets = [
    (r"d:\antigravity_projects\apepi_escola\apepi-escola.zip", "apepi-escola"),
    (r"d:\antigravity_projects\apepi_escola\apepi-escola-v3.zip", "apepi-escola-v3"),
    (r"d:\antigravity_projects\apepi_escola\apepi-escola-theme.zip", "apepi-escola-theme"),
    (r"d:\antigravity_projects\apepi_escola\temas\apepi-escola.zip", "apepi-escola"),
    (r"d:\antigravity_projects\apepi_escola\apepi-escolao\apepi-escola.zip", "apepi-escola")
]

for zip_path, folder_name in targets:
    if os.path.exists(zip_path):
        try:
            os.remove(zip_path)
        except Exception:
            pass
    with zipfile.ZipFile(zip_path, "w", zipfile.ZIP_DEFLATED) as zipf:
        for root, dirs, files in os.walk(theme_dir):
            for file in files:
                if file.endswith(".zip"):
                    continue
                full_path = os.path.join(root, file)
                rel_path = os.path.relpath(full_path, theme_dir)
                arcname = os.path.join(folder_name, rel_path).replace("\\", "/")
                zipf.write(full_path, arcname)
    print(f"ZIP {os.path.basename(zip_path)} gerado com sucesso!")

