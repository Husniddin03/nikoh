# Nikohga Sorovnoma Tizimi

Bu - nikohdan o'tishdan oldin juftliklar uchun psixologik so'rovnoma o'tkazish uchun yaratilgan veb-ilova.

## Xususiyatlari

- **Foydalanuvchilar ro'yxatdan o'tishi**: JSHSHIR, passport ma'lumotlari va kontaktlari bilan
- **So'rovnoma tizimi**: 5 ta bo'lim bo'yicha 250 ta savol (har bir bo'limda 50 ta savol)
- **Avtomatik baholash**: "Ha" (2 ball), "Qisman" (1 ball), "Yo'q" (0 ball) tizimi
- **Moslik darajasi**: 5 darajali baholash tizimi
- **Admin paneli**: Foydalanuvchilar, juftliklar va statistikani boshqarish
- **Dinamik tarkib**: Bo'limlar va savollarni oson boshqarish

## Texnologiyalar

- **Backend**: Laravel 13.x
- **Frontend**: Blade templating, Tailwind CSS
- **Database**: MySQL 8.0
- **Server**: Nginx
- **Containerization**: Docker & Docker Compose

## O'rnatish

### Talablar

- Docker & Docker Compose
- Composer
- Node.js & NPM

### Qadam 1: Konteynerlarni ishga tushurish

```bash
docker compose up -d
```

### Qadam 2: Ma'lumotlar bazasini sozlash

```bash
docker compose exec app php artisan migrate:fresh --seed
```

### Qadam 3: Ilova ga kirish

Ilova quyidagi manzilda mavjud bo'ladi:
- Frontend: http://localhost:8007
- Admin paneli: http://localhost:8007/admin

## Foydalanuvchilar

### Standart foydalanuvchi

- Email: `user@example.com`
- Parol: `password`

### Admin foydalanuvchisi

- Email: `shaxobiddin@gmail.com`
- Parol: `password`
- Role: Super Admin

## So'rovnoma bo'limlari

1. **MULOQOT VA TUSHUNISH** (50 savol)
2. **QADRIYATLAR VA HAYOTGA QARASHLAR** (50 savol)
3. **MOLIYAVIY YONDASHUV** (50 savol)
4. **HESSIY BARQARORLIK** (50 savol)
5. **FARZAND TARBIYASI VA OILAVIY MAS'ULIYAT** (50 savol)

## Baholash mezoni

- **450-500 ball**: Juda mos
- **350-449 ball**: Yaxshi mos
- **250-349 ball**: O'rtacha mos
- **150-249 ball**: Noto'g'ri moslik ehtimoli yuqori
- **0-149 ball**: Jiddiy mos kelmaslik

## Admin paneli funksiyalari

### Asosiy panel
- Umumiy statistika (foydalanuvchilar, testlar, tugatilganlik)
- So'nggi testlar ro'yxati

### Foydalanuvchilar boshqaruvi
- Barcha foydalanuvchilar ro'yxati
- Foydalanuvchi ma'lumotlarini ko'rish
- Foydalanuvchi qo'shish va tahrirlash

### Juftliklar boshqaruvi
- Barcha juftliklar ro'yxati
- Test natijalarini ko'rish
- Batafsil statistika

### Statistika
- Testlar statistikasi
- Moslik darajalari bo'yicha taqsimot
- Oylik testlar dinamikasi

## API marshrutlari

### So'rovnoma
- `GET /survey` - So'rovnoma boshlash sahifasi
- `POST /survey/start` - Testni boshlash
- `GET /survey/take/{testResult}` - Testni olish
- `POST /survey/submit/{testResult}` - Testni yuborish
- `GET /survey/result/{testResult}` - Natijalarni ko'rish

### Foydalanuvchilar
- `GET /user/register` - Ro'yxatdan o'tish formasi
- `POST /user/register` - Ro'yxatdan o'tish

### Admin paneli
- `GET /admin` - Admin paneli asosiy sahifasi
- `GET /admin/users` - Foydalanuvchilar ro'yxati
- `GET /admin/pairs` - Juftliklar ro'yxati
- `GET /admin/statistics` - Statistika

## Ma'lumotlar bazasi tuzilishi

### `users`
- Foydalanuvchilar ma'lumotlari
- JSHSHIR, passport, telefon, manzil

### `survey_sections`
- So'rovnoma bo'limlari
- Nomi, tartibi, maksimal ball

### `questions`
- Savollar
- Bo'limga bog'liq, matni, tartib raqami

### `test_results`
- Test natijalari
- Foydalanuvchi, jufti, ballar, holati

### `answers`
- Javoblar
- Test, savol, ball, javob turi

## Rivojlantirish

### Yangi savollar qo'shish

1. Ma'lumotlar bazasiga yangi savol qo'shing:
```php
Question::create([
    'survey_section_id' => 1,
    'question_text' => 'Yangi savol matni',
    'order' => 51,
    'is_active' => true
]);
```

2. Yoki `nikohga_sorovnoma.txt` faylini yangilang va seeder ni qayta ishga tushiring:
```bash
docker compose exec app php artisan db:seed --class=SurveySeeder
```

### Yangi bo'lim qo'shish

```php
SurveySection::create([
    'title' => 'Yangi bo\'lim nomi',
    'description' => 'Bo\'lim tavsifi',
    'order' => 6,
    'max_score' => 100,
    'is_active' => true
]);
```

## Xavfsizlik

- Barcha foydalanuvchi kiritmalari validatsiyadan o'tkaziladi
- Admin paneli autentifikatsiya talab qiladi
- SQL injection va XSS hujumlaridan himoya
- CSRF tokenlari ishlatiladi

## Litsenziya

Bu loyiha MIT litsenziyasi ostida tarqatiladi.

## Mualliflar

Loyiha Laravel 13.x asosida yaratilgan.

## Bog'liqliklar

- [Laravel](https://laravel.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [MySQL](https://www.mysql.com/)
- [Docker](https://www.docker.com/)
