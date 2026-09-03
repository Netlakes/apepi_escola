from PIL import Image, ImageDraw
import os

width, height = 1200, 900
img = Image.new('RGB', (width, height), color='#003E19')
draw = ImageDraw.Draw(img)

# Create botanical gradient background
for y in range(height):
    r = int(0 + (0 - 0) * y / height)
    g = int(62 - (62 - 25) * y / height)
    b = int(25 - (25 - 10) * y / height)
    draw.line([(0, y), (width, y)], fill=(r, g, b))

# Card Mockup Background (Cream surface)
card_left, card_top, card_right, card_bottom = 100, 200, 1100, 800
draw.rounded_rectangle([card_left, card_top, card_right, card_bottom], radius=24, fill='#F9F7F2', outline='#E2DED4', width=3)

# Header inside card mockup
draw.rounded_rectangle([140, 240, 1060, 480], radius=16, fill='#003E19')

# Sub badge
draw.rounded_rectangle([180, 270, 520, 305], radius=20, fill='#256B38')
draw.text((200, 280), "FORMAÇÃO COMPLETA PARA MÉDICOS", fill='#FFFFFF')

# Course Title Mockup
draw.text((180, 325), "12º Curso de Prescrição de Cannabis Medicinal", fill='#FFFFFF')
draw.text((180, 385), "Capacitação clínica e prática com visita à Fazenda Experimental APEPI", fill='#C8E6C9')

# White Floating Card Mockup
draw.rounded_rectangle([720, 280, 1020, 720], radius=16, fill='#FFFFFF', outline='#E0E0E0', width=2)
draw.text((750, 320), "PRÓXIMA TURMA", fill='#777777')
draw.text((750, 345), "Setembro / 2025", fill='#003E19')
draw.text((750, 400), "CARGA HORÁRIA", fill='#777777')
draw.text((750, 425), "100 Horas Aula", fill='#003E19')
draw.text((750, 480), "MODALIDADE", fill='#777777')
draw.text((750, 505), "Online Ao Vivo", fill='#003E19')

# Green Button inside mockup
draw.rounded_rectangle([750, 580, 990, 640], radius=10, fill='#4C9A2A')
draw.text((780, 600), "INSCREVER-SE", fill='#FFFFFF')

# Feature Items inside card mockup
features = ["Aulas Gravadas", "Material Didático", "Suporte com Especialistas", "Casos Clínicos", "Certificado"]
for i, feat in enumerate(features):
    fx = 140 + (i * 180)
    draw.rounded_rectangle([fx, 520, fx + 160, 600], radius=12, fill='#FFFFFF', outline='#E5E0D5', width=1)
    draw.text((fx + 15, 550), feat, fill='#003E19')

# Top Theme Title
draw.text((100, 80), "APEPI ESCOLA", fill='#FFFFFF')
draw.text((100, 130), "Tema WordPress de Alta Performance — Educação & Cannabis Medicinal", fill='#A5D6A7')

png_path = r"d:\antigravity_projects\apepi_escola\temas\apepi-escola\screenshot.png"
jpg_path = r"d:\antigravity_projects\apepi_escola\temas\apepi-escola\screenshot.jpg"

img.save(png_path)
img.save(jpg_path, quality=95)

print("Screenshots gerados com sucesso:")
print("PNG:", png_path)
print("JPG:", jpg_path)
