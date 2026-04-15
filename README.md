# 🧩 Compatibility Test System (Nikoh va Ajrim Moslik Testi)

Ushbu loyiha juftliklarning o'zaro mosligini turli hayotiy bo'limlar (iqtisodiy, psixologik, ijtimoiy va h.k.) bo'yicha aniqlash uchun mo'ljallangan tizimdir. Tizim foydalanuvchilarga savollar berish va ularning javoblarini solishtirish orqali foiz ko'rsatkichlarini hisoblab beradi.

## 🚀 Loyiha Maqsadi
* Juftliklarning qarashlari bir-biriga qanchalik mos kelishini aniqlash.
* "Sinxron testlash" orqali ikkala sherikka ham aynan bir xil savollar tushishini ta'minlash.
* Bo'limlar kesimida (Units) tahliliy natijalarni taqdim etish.

## 🛠 Texnologiyalar
* **Framework:** Laravel 11.x
* **Database:** MySQL / PostgreSQL
* **Language:** PHP 8.2+

## 📊 Ma'lumotlar Bazasi Strukturasi

Loyiha quyidagi asosiy mantiqiy bloklardan tashkil topgan:

* **Users:** JSHSHIR orqali identifikatsiya qilinuvchi foydalanuvchilar.
* **Units:** Savollar bo'lingan toifalar (masalan: Oila, Moliyaviy masalalar).
* **Test Sessions:** Juftliklarni bog'lovchi va savollar ketma-ketligini JSON formatida saqlovchi jadval.
* **Results:** Har bir foydalanuvchining individual javoblari.
* **Unit Scores:** Test yakunida har bir bo'lim uchun hisoblangan moslik foizlari.

### ER Diagramma (Mantiqiy ko'rinish)


## ⚙️ O'rnatish (Installation)

1. Repozitoriyani klonlang:
   ```bash
   git clone [https://github.com/username/project-name.git](https://github.com/username/project-name.git)
   cd project-name