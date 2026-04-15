<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Question;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AjrimSeeder extends Seeder
{
    /**
     * Run the database seeds for divorce assessment.
     */
    public function run(): void
    {
        // Get or create default admin
        $admin = Admin::first();
        
        if (!$admin) {
            $admin = Admin::create([
                'name' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('admin123'),
            ]);
        }

        $units = [
            [
                'name' => 'Munosabatlardagi Yoriq Uchlari',
                'description' => 'Oilaviy munosabatlardagi konfliktlar, tushunmovchiliklar va kelishmovchiliklarni baholash',
                'category' => 'ajrim',
            ],
            [
                'name' => 'Ishonch va Sadoqat Muammolari',
                'description' => 'Oila ichidagi ishonch, sadoqat va halollikka oid qayg‘uli holatlarni aniqlash',
                'category' => 'ajrim',
            ],
            [
                'name' => 'Hissiy va Ruhiy Jihatdan Uzoqlashish',
                'description' => 'Ruhiy jihatdan ajralish, sevgi va mehrning yo‘qolishi alomatlarini baholash',
                'category' => 'ajrim',
            ],
            [
                'name' => 'Oilaviy Zo‘ravonlik va Bosim',
                'description' => 'Jismoniy, ruhiy va iqtisodiy zo‘ravonlik alomatlarini aniqlash va baholash',
                'category' => 'ajrim',
            ],
            [
                'name' => 'Ajrim O‘rniga Murosani Tanlash',
                'description' => 'Oilani saqlab qolish, murosaga kelish va qayta tiklanish istagini baholash',
                'category' => 'ajrim',
            ],
        ];

        $createdUnits = [];
        foreach ($units as $unitData) {
            $createdUnits[] = Unit::create([
                'admin_id' => $admin->id,
                'name' => $unitData['name'],
                'description' => $unitData['description'],
                'category' => $unitData['category'],
            ]);
        }

        // Add questions for each unit
        $this->addAjrimQuestions($createdUnits, $admin);
    }

    private function addAjrimQuestions(array $units, Admin $admin): void
    {
        // 1. MUNOSABATLARDAGI YORIQ UCHLARI - 50 savol
        $yoriqQuestions = [
            'Siz va juftingiz orasida tez-tez jiddiy janjallar bo‘ladimi?',
            'Munozaralaringiz ko‘pincha yechimsiz yakunlanadimi?',
            'Bir-biringizni tushunishda qiyinchiliklar seziladi?',
            'Muloqot paytida har doim kelishmovchilik bo‘ladimi?',
            'Biror mavzuni muhokama qilish o‘zingizga og‘irlik qiladimi?',
            'Suhbatlaringiz ko‘pincha tanqid va ayblash bilan boshlanadimi?',
            'Juftingiz bilan gaplashishdan qochishga harakat qilasizmi?',
            'O‘rtangizda doimiy so‘kinish va qichqirish bo‘ladimi?',
            'Bir-biringizni e’tiborsiz qoldirasizmi?',
            'Umumiy mavzular topishda qiynalasizmi?',
            'Sizningcha, juftingiz sizni tushunishga harakat qiladimi?',
            'Munosabatlaringizda sovuqlik seziladimi?',
            'Birga vaqt o‘tkazish istagini yo‘qotdingizmi?',
            'Juftingiz bilan bo‘lgan uchrashuvlardan charchaysizmi?',
            'Bir-biringizga nisbatan qiziqish sezilmayapti?',
            'Muhim qarorlarni birga qabul qilish qiyinmi?',
            'Har ikkala tomon ham o‘z fikrini o‘zgartirishga tayyormi?',
            'O‘rtangizda doimiy tanqid va qamchilanish bo‘ladimi?',
            'Bir-biringizni qadrlashni to‘xtatdingizmi?',
            'Oila muammolarini yechishda tashqi yordam olganmisiz?',
            'Munosabatlaringiz sizni ruhiy jihatdan charchatadimi?',
            'Juftingiz bilan kelishmovchiliklar uyqu va ovqatlanishga ta’sir qiladimi?',
            'Oilaviy hayotdan qoniqish darajangiz pastmi?',
            'Birga bo‘lishni istamasligingizni his qilasizmi?',
            'Juftingiz sizni qo‘llab-quvvatlamayapti deb his qilasizmi?',
            'O‘rtangizda moliyaviy kelishmovchiliklar ustunmi?',
            'Oila qurishdan oldingi kutganlaringiz amalga oshmadi?',
            'Munosabatlaringizdagi muammolarni yashirishga majburmisiz?',
            'Juftingiz bilan kelajak haqida bir xil tasavvurlargiz bormi?',
            'O‘rtangizda farzandlar tarbiyasiga oid kelishmovchiliklar bormi?',
            'Oilaviy an’analarni saqlashda qiyinchiliklar bor?',
            'Munosabatlaringizni tiklash uchun qilingan harakatlar natijasizmi?',
            'O‘rtangizda uzoq vaqt davomida jiddiy janjal bo‘lmaganmi?',
            'Juftingiz sizni hurmat qilmasligini his qilasizmi?',
            'Munosabatlaringizda tenglik va adolat yo‘qmi?',
            'Bir-biringizga nisbatan talabchanlik ortib bormoqda?',
            'Oila hayotingizdan norozi ekansizni his qilasizmi?',
            'Juftingiz bilan bo‘lgan muammolarni yechishga umidsizmisiz?',
            'O‘rtangizda doimiy qayg‘u va norozilik muhiti hukum suradimi?',
            'Munosabatlaringizdagi muammolarni kechiktirish odatiy holga aylanadimi?',
            'Oilaviy hayotdan boshqa alternativalarni o‘ylab ko‘rganmisiz?',
            'Juftingiz bilan umumiy til topa olmasligingizni his qilasizmi?',
            'Munosabatlaringiz sizni tushkunlikka soladimi?',
            'Bir-biringizning xatolarini kechirishga qodirmisiz?',
            'O‘rtangizda kechirim so‘rash kam uchraydimi?',
            'Oilaviy hayotdan ko‘chib ketishni istagan vaqt bo‘ladimi?',
            'Juftingiz bilan bo‘lgan munosabatlarni davom ettirish mantiqsizmi?',
            'Munosabatlaringizni yaxshilash uchun professional yordam izlaganmisiz?',
            'O‘rtangizda o‘zaro tushunmovchilik doimiy holga aylanadimi?',
            'Oilaviy hayotdan qoniqishni yo‘qotdingizmi?',
            'Juftingiz bilan kelishmovchiliklar kundan-kunga ortib bormoqda?',
        ];

        // 2. ISHONCH VA SADOQAT MUAMMOLARI - 50 savol
        $ishonchQuestions = [
            'Juftingizga to‘liq ishonch bildira olasizmi?',
            'Juftingiz sizga yolg‘on gapirganini his qilasizmi?',
            'O‘rtangizda sir saqlash muammolari bormi?',
            'Juftingizning telefonini tekshirish istagi paydo bo‘ladimi?',
            'Ishonchni qayta tiklash uchun qilingan harakatlar bor?',
            'Juftingiz sizni aldaganini his qilasizmi?',
            'O‘rtangizda halollik muammolari seziladimi?',
            'Juftingiz sizga yashirincha ishlar qilayotganini his qilasizmi?',
            'Ishonchni yo‘qotishingiz oila hayotiga ta’sir qiladimi?',
            'Juftingiz sizni rad etish yoki inkor qilishga majbur qiladimi?',
            'O‘rtangizda o‘zaro nishonchisizlik muhiti yaratilganmi?',
            'Juftingizning so‘zlariga shubha bilan qaraysizmi?',
            'Ishonch muammolari sababli kayfiyatingiz tushkunmi?',
            'Juftingiz sizni ishonchsizlikka tushirgan holatlar bo‘ladimi?',
            'Oila ichida sir saqlash an’anaviy bo‘lib qoldimi?',
            'Juftingiz bilan ochiq gaplasha olmayotganingizni his qilasizmi?',
            'Ishonchni qayta tiklash imkonsiz deb his qilasizmi?',
            'O‘rtangizda oldindan o‘ylangan yolg‘onlar bo‘ladimi?',
            'Juftingiz sizga nisbatan beparvo bo‘lib qoldimi?',
            'Ishonchni yo‘qotish munosabatlarga halokatli ta’sir qiladimi?',
            'Juftingizning do‘stlari yoki oilasi bilan ishonch muammolari bormi?',
            'O‘rtangizda moliyaviy yashirinlar yoki yolg‘onlar bormi?',
            'Juftingiz sizni ko‘zdan yashirib, maxfiy ishlar qiladimi?',
            'Ishonch muammolari sababli uyqusizliklar yuz beradimi?',
            'Juftingiz sizga va’dalarini bajarmaydimi?',
            'O‘rtangizda o‘zaro nazorat va kuzatish kuchayganmi?',
            'Juftingiz sizni aldashga odatlanganmi?',
            'Ishonchni tiklashga urinishlar natijasizmi?',
            'Oila ichida haqiqatni aytish qiyinlashganmi?',
            'Juftingiz sizni ruhiy jihatdan bosib turishga harakat qiladimi?',
            'O‘rtangizda o‘zaro tushkunlik va umidsizlik seziladimi?',
            'Juftingiz sizga nisbatan haqiqatni aytishdan qochadimi?',
            'Ishonchni yo‘qotish sizni ruhiy jihatdan qiynaydimi?',
            'Juftingiz bilan kelishmovchiliklar ishonchga asoslanadimi?',
            'Oila ichida yolg‘on va aldov kundalik holga aylanadimi?',
            'Juftingiz sizni ishonchsizlik bilan ayblaydimi?',
            'Ishonch muammolari tufayli boshqa oila a\'zolari aziyat chekadimi?',
            'Juftingiz sizga nisbatan yashirin niyatlarga ega deb his qilasizmi?',
            'O‘rtangizda ishonchni tiklash uchun professional yordam izlaganmisiz?',
            'Juftingiz sizni ko‘zdan yashirish uchun maxfiy telefon yoki hisoblardan foydalanadimi?',
            'Ishonchni yo‘qotish ajrimga olib keladi deb his qilasizmi?',
            'Oila ichida haqiqat va halollikni tiklash imkonsizmi?',
            'Juftingiz sizga nisbatan sodiqlikni yo‘qotganini his qilasizmi?',
            'Ishonch muammolari sababli o‘zingizni yolg‘iz his qilasizmi?',
            'O‘rtangizda ishonchni qayta tiklash imkoniyati yo‘qmi?',
            'Juftingiz sizni aldaganidan keyin kechirim so‘raganmi?',
            'Ishonchni yo‘qotish oilaviy barqarorlikka xavf soladimi?',
            'Juftingiz bilan kelishmovchiliklar ishonch va sadoqatga asoslanadimi?',
            'Oila ichida yashirinlar va sirlar ko‘payib ketganmi?',
            'Ishonchni qayta tiklash uchun vaqt ajratishga tayyormisiz?',
        ];

        // 3. HISSIY VA RUHIY JIHATDAN UZOQLASHISH - 50 savol
        $ruhiyQuestions = [
            'Juftingizga bo‘lgan sevgi hislaringiz susayganini his qilasizmi?',
            'O‘rtangizda hissiy aloqa va jismoniy yaqinlik kamayganmi?',
            'Juftingiz bilan bo‘lgan vaqt sizni xursand qilmaydimi?',
            'Bir-biringizga nisbatan mehr va g‘amxo‘rlik kamayganmi?',
            'O‘rtangizda hissiy sovuqlik va beparvolik seziladimi?',
            'Juftingiz bilan bo‘lgan aloqalardan zavq olmayapsizmi?',
            'Siz va juftingiz orasida ruhiy jihatdan uzoqlashish bormi?',
            'Bir-biringizni qo‘llab-quvvatlash istagi yo‘qolganmi?',
            'O‘rtangizda sevgi va mehr o‘rniga odatiy hatti-harakatlar bormi?',
            'Juftingiz sizni ruhiy jihatdan qondirmaydimi?',
            'Birga bo‘lishni istamasligingizni his qilasizmi?',
            'Oila hayotidan boshqa munosabatlarni izlashga moyil bo‘ldingizmi?',
            'Juftingizga nisbatan qiziqishni yo‘qotdingizmi?',
            'O‘rtangizda jismoniy yaqinlik istagi yo‘qolganmi?',
            'Bir-biringizga nisbatan e’tibor va g‘amxo‘rlik kamayganmi?',
            'Juftingiz sizni tushunmasligini his qilasizmi?',
            'Oila hayotingizdan qoniqish darajangiz pastmi?',
            'Juftingiz bilan bo‘lgan muammolardan qochishga harakat qilasizmi?',
            'O‘rtangizda hissiy bog‘liqlik va birlik sezilmaydimi?',
            'Juftingiz sizni ruhiy jihatdan qiynaydimi?',
            'Birga kelajak haqida tasavvur qilish qiyinmi?',
            'Oila hayotidan ko‘chib ketishni istagan vaqtlar bo‘ladimi?',
            'Juftingizga nisbatan norozilik ortib bormoqda?',
            'O‘rtangizda mehr-muhabbat o‘rniga o‘zaro tanqid bormi?',
            'Juftingiz bilan bo‘lgan munosabatlarni saqlashni xohlamaysizmi?',
            'Bir-biringizni tushunish istagi yo‘qolganmi?',
            'Oila ichida hissiy bosim va stress ko‘pmi?',
            'Juftingiz sizni qadrlamasligini his qilasizmi?',
            'O‘rtangizda qayg‘u va tushkunlik muhiti yaratilganmi?',
            'Juftingiz bilan bo‘lgan aloqalar sizni charchatadimi?',
            'Birga bo‘lishdan ko‘ra alohida yashashni afzal ko‘rasizmi?',
            'Oila hayotingiz sizni baxtsiz qiladimi?',
            'Juftingizga nisbatan mehr hissini yo‘qotdingizmi?',
            'O‘rtangizda o‘zaro ishonch va samimiylik yo‘qmi?',
            'Juftingiz bilan kelishmovchiliklar sizni ruhiy jihatdan buzib tashlaydimi?',
            'Birga yashashni mantiqsiz deb his qilasizmi?',
            'Oila ichida mehr va samimiylik o‘rniga sovuqlik hukm suradimi?',
            'Juftingiz sizni baxtli qilmaydimi?',
            'O‘rtangizda hissiy aloqa va bog‘liqlik uzilganmi?',
            'Juftingiz bilan bo‘lgan munosabatlardan umidsizmisiz?',
            'Birga bo‘lishni istamasligingiz doimiy holga aylanadimi?',
            'Oila hayotingizdan qochishni xohlaysizmi?',
            'Juftingizga nisbatan nafrat yoki norozilik hislaringiz bormi?',
            'O‘rtangizda sevgi va mehr o‘rniga o‘zaro o‘rinbosarlik bormi?',
            'Juftingiz bilan bo‘lgan munosabatlarni tiklashga urinishlar qildingizmi?',
            'Oila ichida hissiy zo‘ravonlik yoki beparvolik bormi?',
            'Juftingiz sizni ruhiy jihatdan tushkunlikka soladimi?',
            'Birga bo‘lishni istamasligingiz oila a\'zolariga ta’sir qiladimi?',
            'Oila hayotingiz sizni o‘zgarishga majbur qiladimi?',
            'Juftingizga nisbatan umidsizlikni his qilasizmi?',
        ];

        // 4. OILAVIY ZO‘RAVONLIK VA BOSIM - 50 savol
        $zoravonlikQuestions = [
            'Juftingiz sizga jismoniy zo‘ravonlik qilgani bor?',
            'Oila ichida so‘z bilan zo‘ravonlik va haqoratlar bo‘ladimi?',
            'Juftingiz sizni ruhiy jihatdan qiynaydimi?',
            'Oila ichida qo‘rquv va xavotir muhiti hukm suradimi?',
            'Juftingiz sizni moliyaviy jihatdan bosib turishga harakat qiladimi?',
            'Oila ichida kuchli nazorat va cheklovlar bormi?',
            'Juftingiz sizni kamsitish va haqorat qilish odatiy holga aylanadimi?',
            'Oila ichida zo‘ravonlik alomatlarini yashirishga majbursiz?',
            'Juftingiz sizni do‘stlaringiz va oilangizdan uzoqlashtirishga harakat qiladimi?',
            'Oila ichida zo‘ravonlik tufayli farzandlar aziyat chekadimi?',
            'Juftingiz sizga jismoniy jarohat yetkazganmi?',
            'Oila ichida ruhiy zo‘ravonlik va bosim doimiy bormi?',
            'Juftingiz sizni doimo ayblash va kamsitishga odatlanganmi?',
            'Oila ichida zo‘ravonlik tufayli sog‘lig‘ingiz buzilganmi?',
            'Juftingiz sizni moliyaviy jihatdan mustaqil bo‘lishga yo‘l qo‘ymaydimi?',
            'Oila ichida kuch sifatida qo‘llash holatlari bo‘ladimi?',
            'Juftingiz sizni zo‘ravonlik bilan tahdid qilganmi?',
            'Oila ichida zo‘ravonlik sababli uyquingiz buzilganmi?',
            'Juftingiz sizni o‘z-o‘zini himoya qilish huquqidan mahrum qiladi?',
            'Oila ichida zo‘ravonlik tufayli ish yoki o‘qishdan chetlanganmisiz?',
            'Juftingiz sizni doimo nazorat qilish va kuzatishga harakat qiladimi?',
            'Oila ichida zo‘ravonlik alomatlarini inkor qilishga majbursiz?',
            'Juftingiz sizni ruhiy jihatdan tushkunlikka soladimi?',
            'Oila ichida zo‘ravonlik tufayli professional yordam izlaganmisiz?',
            'Juftingiz sizni jazolash va jarima solish huquqiga ega deb hisoblaydimi?',
            'Oila ichida iqtisodiy zo‘ravonlik va moliyaviy nazorat bormi?',
            'Juftingiz sizni doimo qo‘rquvda yashashga majbur qiladimi?',
            'Oila ichida zo‘ravonlik tufayli psixologik muammolar yuz berganmi?',
            'Juftingiz sizni farzandlaringizdan uzoqlashtirish bilan tahdid qilganmi?',
            'Oila ichida zo‘ravonlik alomatlarini boshqa insonlardan yashirasiz?',
            'Juftingiz sizni jinsiy zo‘ravonlikka uchraganmi?',
            'Oila ichida zo‘ravonlik tufayli huquqiy yordam izlaganmisiz?',
            'Juftingiz sizni doimo ayblash va jazolash huquqiga ega deb hisoblaydimi?',
            'Oila ichida zo‘ravonlik sababli uyqu va dam olishingiz buzilganmi?',
            'Juftingiz sizni o‘z-o‘zini ifoda qilish huquqidan mahrum qiladi?',
            'Oila ichida zo‘ravonlik tufayli ijtimoiy aloqalaringiz cheklanganmi?',
            'Juftingiz sizni doimo qo‘rquv va xavotirda yashashga majbur qiladimi?',
            'Oila ichida zo‘ravonlik alomatlarini qabul qilish odatiy holga aylanadimi?',
            'Juftingiz sizni ruhiy jihatdan zo‘ravonlik qilishni to‘xtatmaydimi?',
            'Oila ichida zo‘ravonlik tufayli farzandlaringiz ta’limi ta’sirlanganmi?',
            'Juftingiz sizni moliyaviy jihatdan qaram qilishga harakat qiladimi?',
            'Oila ichida zo‘ravonlik sababli hayot xavfsizligingiz xavf ostidami?',
            'Juftingiz sizni jismoniy zo‘ravonlik qilishni to‘xtatmaydimi?',
            'Oila ichida zo‘ravonlik alomatlarini davlat organlariga xabar qilganmisiz?',
            'Juftingiz sizni doimo zo‘ravonlik va kamsitish bilan yashashga majbur qiladi?',
            'Oila ichida zo‘ravonlik tufayli sog‘lig‘ingiz jiddiy buzilganmi?',
            'Juftingiz sizni zo‘ravonlikdan himoya qilish uchun boshqa uyingizga ketganmisiz?',
            'Oila ichida zo‘ravonlik tufayli hayot sifat ingiz pastga tushganmi?',
        ];

        // 5. AJRIM O‘RNIGA MUROSANI TANLASH - 50 savol
        $murosaQuestions = [
            'Siz oilani saqlab qolishni istaysizmi?',
            'Oila muammolarini murosaga hal qilishga tayyormisiz?',
            'Juftingiz bilan kelishmovchiliklarni yechishga urinib ko‘rganmisiz?',
            'Oila terapevti yoki psixolog yordamini qabul qilishga tayyormisiz?',
            'Munosabatlaringizni tiklash uchun vaqt ajratishga tayyormisiz?',
            'Juftingiz bilan ochiq muloqot o‘rnatishga harakat qilasizmi?',
            'Oila muammolarini hal qilish uchun o‘z-o‘zingizni o‘zgartirishga tayyormisiz?',
            'Murosaga kelish uchun juftingiz bilan uchrashuvlar tashkil qilganmisiz?',
            'Oila an’analarini tiklash va yangilashga harakat qilasizmi?',
            'Munosabatlaringizni yaxshilash uchun qilingan harakatlardan qoniqasizmi?',
            'Juftingiz bilan kelajak haqida umidli rejalar tuzasizmi?',
            'Oila muammolarini hal qilish uchun do‘stlar yoki oila a\'zolari yordamini olasizmi?',
            'Murosaga kelish uchun o‘z-o‘zingizni tahlil qilishga tayyormisiz?',
            'Juftingiz bilan muammolarni muhokama qilishga xohlaysizmi?',
            'Oila hayotini saqlab qolish uchun har qanday harakat qilishga tayyormisiz?',
            'Munosabatlaringizni tiklash uchun professional yordam izlaganmisiz?',
            'Juftingiz bilan kelishmovchiliklarni yechishga umidsizmisiz?',
            'Oila muammolarini murosaga hal qilish imkoniyatiga ishonasizmi?',
            'Murosaga kelish uchun juftingizdan uzr so‘rashga tayyormisiz?',
            'Oila hayotini yaxshilash uchun qo‘shimcha ta’lim olasizmi?',
            'Munosabatlaringizni tiklash uchun vaqt va kuch sarflashga tayyormisiz?',
            'Juftingiz bilan ochiq va samimiy suhbatlar o‘tkazasizmi?',
            'Oila muammolarini hal qilish uchun o‘z-o‘zingizni rivojlantirasizmi?',
            'Murosaga kelish uchun oila a\'zolari yordamini qabul qilasizmi?',
            'Munosabatlaringizni tiklash uchun qilingan harakatlardan umidsizmisiz?',
            'Juftingiz bilan kelishmovchiliklarni hal qilishga qodirmisiz?',
            'Oila hayotini saqlab qolish uchun boshqa choralar ko‘rganmisiz?',
            'Murosaga kelish uchun juftingiz bilan birga psixologga borishga tayyormisiz?',
            'Oila muammolarini hal qilish uchun sabr-toqat va tushunish kerak deb o‘ylaysizmi?',
            'Munosabatlaringizni tiklash uchun qo‘shimcha kuch sarflashga tayyormisiz?',
            'Juftingiz bilan kelajak haqida umidli rejalar tuzishga harakat qilasizmi?',
            'Oila hayotini yaxshilash uchun o‘z-o‘zingizni o‘zgartirishga tayyormisiz?',
            'Murosaga kelish uchun juftingiz bilan birga dam olishga borasizmi?',
            'Oila muammolarini hal qilish uchun ochiq fikrlashga tayyormisiz?',
            'Munosabatlaringizni tiklash uchun qilingan harakatlar natijasizmi?',
            'Juftingiz bilan kelishmovchiliklarni murosaga hal qilishga tayyormisiz?',
            'Oila hayotini saqlab qolish uchun barcha imkoniyatlarni ishlatasizmi?',
            'Murosaga kelish uchun juftingiz bilan birga sport yoki xobbi bilan shug‘ullanasizmi?',
            'Oila muammolarini hal qilish uchun o‘z-o‘zingizni tahlil qilasizmi?',
            'Munosabatlaringizni tiklash uchun professional yordam olishga tayyormisiz?',
            'Juftingiz bilan ochiq va halol muloqot o‘rnatishga harakat qilasizmi?',
            'Oila hayotini yaxshilash uchun yangi an’analar yaratishga harakat qilasizmi?',
            'Murosaga kelish uchun juftingiz bilan birga kelajak haqida rejalar tuzasizmi?',
            'Oila muammolarini hal qilish uchun sabr-toqat va tushunishga tayyormisiz?',
            'Munosabatlaringizni tiklash uchun qilingan harakatlardan qoniqasizmi?',
            'Juftingiz bilan kelishmovchiliklarni murosaga hal qilish imkoniyatiga ishonasizmi?',
            'Oila hayotini saqlab qolish uchun har qanday chorani ko‘rasizmi?',
            'Murosaga kelish uchun juftingiz bilan birga o‘qish va rivojlanishga tayyormisiz?',
            'Oila muammolarini hal qilish uchun o‘z-o‘zingizni o‘zgartirishga tayyormisiz?',
            'Munosabatlaringizni tiklash uchun qo‘shimcha vaqt ajratishga tayyormisiz?',
            'Juftingiz bilan kelajak haqida umidli va ijobiy rejalar tuzishga harakat qilasizmi?',
        ];

        // Save all questions
        $this->saveQuestionsForUnit($units[0], $admin, $yoriqQuestions);
        $this->saveQuestionsForUnit($units[1], $admin, $ishonchQuestions);
        $this->saveQuestionsForUnit($units[2], $admin, $ruhiyQuestions);
        $this->saveQuestionsForUnit($units[3], $admin, $zoravonlikQuestions);
        $this->saveQuestionsForUnit($units[4], $admin, $murosaQuestions);
    }

    private function saveQuestionsForUnit($unit, $admin, array $questions): void
    {
        foreach ($questions as $index => $questionText) {
            Question::create([
                'unit_id' => $unit->id,
                'admin_id' => $admin->id,
                'question' => $questionText,
                'is_critical' => ($index < 10), // First 10 questions are critical
            ]);
        }
    }
}
