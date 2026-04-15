# Nikoh Test Application Structure

## 📁 Laravel Project Structure

```
fhdyo/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── User/
│   │       │   ├── EntryController.php      # JSHSHIR kirishi va sessiya yaratish
│   │       │   ├── TestController.php       # Test jarayoni va javoblarni saqlash
│   │       │   └── ResultController.php    # Natijalarni ko'rish
│   │       └── Admin/
│   │           ├── AdminController.php      # Admin dashboard va statistika
│   │           ├── UnitController.php       # Bo'limlar CRUD
│   │           └── QuestionController.php   # Savollar CRUD
│   ├── Livewire/
│   │   ├── User/
│   │   │   ├── EntryForm.php         # JSHSHIR kirish formi (Livewire)
│   │   │   └── TestWizard.php        # Test jarayoni (Livewire)
│   │   └── Admin/
│   │       └── QuestionManager.php   # Savollarni boshqarish (Livewire)
│   ├── Models/
│   │   ├── Admin.php               # Admin modeli
│   │   ├── User.php                # Foydalanuvchi modeli
│   │   ├── Unit.php                # Bo'lim modeli
│   │   ├── Question.php            # Savol modeli
│   │   ├── TestSession.php          # Test sessiyasi modeli
│   │   ├── Result.php              # Javob modeli
│   │   └── UnitScore.php           # Bo'lim ballari modeli
│   ├── Services/
│   │   ├── JshshirService.php     # JSHSHIR validatsiyasi va gender aniqlash
│   │   └── CompatibilityService.php # Muvofiqlik hisoblash algoritmi
│   └── Http/Requests/
│       ├── User/
│       │   └── UserEntryRequest.php # Foydalanuvchi kirishi uchun validatsiya
│       └── Admin/
│           ├── UnitRequest.php      # Bo'lim uchun validatsiya
│           └── QuestionRequest.php  # Savol uchun validatsiya
├── database/
│   ├── migrations/
│   │   └── 0001_01_01_000000_create_all_table.php  # Barcha jadvallarni yaratish
│   ├── seeders/
│   │   └── DatabaseSeeder.php    # Ma'lumotlar to'ldirish
│   └── factories/              # Model factorylar
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php         # Asosiy layout (Livewire bilan)
│   │   ├── user/
│   │   │   ├── entry.blade.php       # JSHSHIR kirish sahifasi (eski)
│   │   │   ├── test.blade.php        # Test sahifasi (eski)
│   │   │   └── results.blade.php     # Natijalar sahifasi
│   │   ├── admin/
│   │   │   ├── index.blade.php       # Admin dashboard
│   │   │   ├── units/
│   │   │   │   ├── index.blade.php   # Bo'limlar ro'yxati
│   │   │   │   ├── create.blade.php  # Bo'lim yaratish
│   │   │   │   └── edit.blade.php    # Bo'lim tahrirlash
│   │   │   └── questions/
│   │   │       ├── index.blade.php   # Savollar ro'yxati
│   │   │       ├── create.blade.php  # Savol yaratish
│   │   │       └── edit.blade.php    # Savol tahrirlash
│   │   └── livewire/
│   │       ├── user/
│   │       │   ├── entry-form.blade.php    # JSHSHIR kirish formi (Livewire)
│   │       │   └── test-wizard.blade.php     # Test jarayoni (Livewire)
│   │       └── admin/
│   │           └── question-manager.blade.php # Savollarni boshqarish (Livewire)
│   ├── css/
│   │   └── app.css               # Tailwind CSS bilan stilizatsiya
│   └── js/
│       └── app.js                # JavaScript fayllari
├── routes/
│   └── web.php                    # Barcha marshrutlar
├── .env                         # Muhit konfiguratsiya fayli
├── config/
│   ├── app.php                   # Asosiy konfiguratsiya
│   ├── database.php              # Ma'lumotlar bazasi sozlamalari
│   ├── session.php              # Sessiyalar sozlamalari (file driver)
│   └── livewire.php             # Livewire konfiguratsiyasi
└── composer.json                # Proyektga bog'liq paketlar
```

## 🔄 Data Flow (Ma'lumotlar oqimi)

### 1️⃣ Foydalanuvchi Kirishi
```
Foydalanuvchi → JSHSHIR kiritish → EntryForm (Livewire) → JshshirService
→ Validatsiya → User yaratish/tekshirish → TestSession yaratish
```

### 2️⃣ Test Jarayoni
```
TestSession → TestWizard (Livewire) → Savollarni yuklash
→ Javob berish (HA/YO'Q) → Result modeliga saqlash
→ Progress tracking → Keyingi savolga o'tish
```

### 3️⃣ Muvofiqlik Hisoblash
```
Ikkala foydalanuvchi testni tugatganda → CompatibilityService
→ Javoblarni solishtirish → Bo'lim bo'yicha hisoblash
→ UnitScore modeliga saqlash → TestSession status = 'completed'
```

### 4️⃣ Natijalarni Ko'rish
```
ResultController → UnitScore ma'lumotlari → Grafiklar va tavsiyalar
→ Umumiy muvofiqlik foizi → Foydalanuvchi interfeysi
```

## 🎯 Asosiy Komponentlar

### **User Interfeysi (Livewire 3)**
- **EntryForm**: JSHSHIR kiritish, real-time validatsiya
- **TestWizard**: Test jarayoni, progress bar, avtomatik navigatsiya

### **Admin Interfeysi**
- **AdminController**: Statistika va dashboard
- **UnitController**: Bo'limlar CRUD (yaratish, o'qish, tahrirlash, o'chirish)
- **QuestionController**: Savollar CRUD (bulk operatsiyalar bilan)
- **QuestionManager** (Livewire): Real-time qidirish, inline toggle'lar

### **Biznes Logikasi**
- **JshshirService**: JSHSHIR validatsiyasi, gender aniqlash
- **CompatibilityService**: Muvofiqlik algoritmi, tavsiyalar generatsiyasi

## 🔧 Texnologiyalar

- **Laravel 12**: PHP framework, type hints, modern sintaksis
- **Livewire 3**: SPA-like interaktiv interfeys
- **Tailwind CSS**: Minimalist oq-qora dizayn
- **MySQL**: Ma'lumotlar bazasi
- **Vite**: Asset kompilyatsiya

## 🎨 Dizayn Prinsiplari

- **Minimalist**: Oq fon, qora matn, ingich chegaralar
- **Uzbek tilida**: Barcha interfeys o'zbek tilida
- **Responsive**: Barcha qurilmalar uchun moslashuvchan
- **SPA-like**: Sahifa qayta yuklamasdan ishlash

## 🚀 Ishga Tushirish

1. **Migrations**: `php artisan migrate`
2. **Livewire**: Komponentlar avtomatik ishlaydi
3. **Routes**: `/` → user entry, `/user/test/{id}` → test, `/admin` → admin panel
4. **Session**: File driver orqali o'rnatilgan

Bu strukturaning asosiy afzalliklari:
- ✅ Modul va qayta ishlash
- ✅ Livewire bilan zamonaviy interfeys
- ✅ To'g'ri validatsiya va xatoliklarni boshqarish
- ✅ O'zbek tilida to'liq interfeys
