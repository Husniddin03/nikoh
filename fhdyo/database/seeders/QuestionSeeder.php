<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Unit;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin
        $admin = Admin::first();
        if (!$admin) {
            $admin = Admin::create([
                'name' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('admin123'),
            ]);
        }

        // Get units by name
        $units = Unit::all()->keyBy('name');

        // MULOQOT VA TUSHUNISH - 50 savol
        $muloqotQuestions = [
            'Siz juftingiz bilan har qanday mavzuda ochiq gaplasha olasizmi?',
            'Muloqotda eshitish va tushunishga harakat qilasizmi?',
            'Ogʻir mavzularda ham murosaga kelishga intilasizmi?',
            'Qarama-qarshi fikr bildirganingizda juftingiz sizni tinglaydimi?',
            'So‘zlaringiz orqali juftingizni ranjitgan vaqtingizda uzr so‘raysizmi?',
            'Suhbat davomida turmush o‘rtog‘ingizga quloq solish muhim deb hisoblaysizmi?',
            'Biror muammo yuzaga kelsa, uni birgalikda hal qilishga harakat qilasizmi?',
            'Juftingiz siz bilan dardlashishni istaganida tayyor bo‘lasizmi?',
            'O‘zingizni tushuntirishda ochiq va halol bo‘lishga harakat qilasizmi?',
            'Xatolaringizni tan olib, muhokamaga tayyormisiz?',
            'Juftingiz sizning fikringizni e’tiborsiz qoldirganida qanday munosabat bildirasiz?',
            'Bahsdan so‘ng yarashishga intilasizmi?',
            'His-tuyg‘ularingizni ifoda etishda qiynalasizmi?',
            'Siz uchun tinch, samimiy suhbatlar muhimmi?',
            'Har doim haqli bo‘lishga intilasizmi?',
            'Suhbat davomida juftingizni ko‘proq tinglaysizmi yoki gapirasizmi?',
            'Suhbatda ko‘tarilgan ohang sizni tez ranjitadimi?',
            'Muloqot davomida sarkazm va istehzo ishlatasizmi?',
            'Juftingizni siz bilan to‘liq tushunishini kutasizmi?',
            'Sizga nisbatan aytilgan tanqidni qanday qabul qilasiz?',
            'Suhbatdan keyin o‘ylab, o‘zingizni tahlil qilasizmi?',
            'Siz bilan gaplashish oson deb o‘ylaysizmi?',
            'Qiyin mavzularni ortga surib, muammoni e’tiborsiz qoldirasizmi?',
            'Juftingiz sizga nisbatan ochiq gapira oladimi?',
            'Sizningcha, to‘g‘ridan-to‘g‘ri tanbeh berish muloqotda foydalimi?',
            'Muloqotda hurmat va e’tiborni saqlashga harakat qilasizmi?',
            'Siz ko‘proq bahslashishni yoqtirasizmi yoki murosani?',
            'Og‘zaki ifoda bilan qiyinchilikka duch kelasizmi?',
            'His-tuyg‘ularingizni yozma shaklda ifoda qilish osonroqmi?',
            'Siz uchun jimlik muloqotsizlik belgisimikan?',
            'Juftingiz bilan kundalik suhbatlar qilasizmi?',
            'Biror gapingiz noto‘g‘ri tushunilganda, uni tushuntirib berasizmi?',
            'Juftingiz fikrini o‘zgartirishga urinasizmi?',
            'Suhbatda birinchi bo‘lib uzr so‘rash siz uchun qiyinmi?',
            'Sizga qarshi fikr bildirgan insonni qanday qabul qilasiz?',
            'Muammoli vaziyatda ovozingizni ko‘tarasizmi?',
            'Muloqotda ishonch va samimiyat siz uchun qanday ahamiyatga ega?',
            'Sizni gapirishga majbur qilishadimi yoki o‘zingiz istaysizmi?',
            'Turli mavzularda suhbatlashish sizga yoqadimi?',
            'O‘z fikringizni bildirgach, boshqalarni ham tinglaysizmi?',
            'Juftingiz sizni tushunmaganda qanday yo‘l tutasiz?',
            'Sizningcha, har qanday muammoni muloqot orqali hal qilish mumkinmi?',
            'Suhbatda diqqatni jamlashda qiynalasizmi?',
            'Muloqotda hissiy reaksiyalarni nazorat qilasizmi?',
            'Juftingiz bilan biror mavzuda tortishganingizda uni keyinchalik muhokama qilasizmi?',
            'Siz juftingizga fikringizni doim to‘liq bildirganmisiz?',
            'Muloqotni rad etish oilaviy aloqaga salbiy ta’sir qiladi deb o‘ylaysizmi?',
            'Muloqot davomida e’tibor qaratilmaganlik sizni ranjitadimi?',
            'Qiyin suhbatlardan qochish odatingiz bormi?',
            'Siz uchun muloqot – bu bir-biringizni tushunish vositasimi?',
        ];

        // QADRIYATLAR VA HAYOTGA QARASHLAR - 50 savol
        $qadriyatQuestions = [
            'Men uchun oilaviy sadoqat har qanday boshqa qadriyatdan ustundir.',
            'Farovonlikka erishish uchun halol yo‘ldan yurish zarur deb hisoblayman.',
            'Har bir insonning hayotda maqsadi bo‘lishi kerak.',
            'Oila meni o‘zligimni to‘liq namoyon etishim uchun muhim tuzilma deb bilaman.',
            'Muammolarni birga yechish oilaviy qadriyatlarning ajralmas qismidir.',
            'Turmush o‘rtog‘imning diniy qarashlariga hurmat bilan qarayman.',
            'Hayotda mehr va rahm-shafqatni eng muhim fazilat deb hisoblayman.',
            'Vaqt o‘tgan sari qarashlarimni yangilab borishga tayyorman.',
            'Katta avlod vakillarining fikri men uchun muhim.',
            'Oila qurishdan oldin hayotiy qadriyatlarni muhokama qilish zarur deb hisoblayman.',
            'Ota-onaga ehtirom oila mustahkamligining asosi deb bilaman.',
            'Men uchun o‘z orzularimni amalga oshirish oilaviy mas’uliyatdan muhim emas.',
            'Jamiyat manfaatini oila manfaatidan ustun qo‘yish kerak deb o‘ylamayman.',
            'Vatanparverlik hayotimda asosiy qadriyatlardan biridir.',
            'Men o‘zim tanlagan hayot yo‘limga sodiqlikni qadrlayman.',
            'Erkin fikrlash va tanlov imkoniyati men uchun muhim qadriyatdir.',
            'Diniy va ma’naviy qadriyatlar hayotimda markaziy o‘ringa ega.',
            'Men uchun to‘g‘rilik har qanday vaziyatda ustun turadi.',
            'Hayotda muvaffaqiyatga erishish mas’uliyat va mehnatni talab qiladi.',
            'Oilaviy hayotda teng huquqlilik va hurmat muhim deb hisoblayman.',
            'Qiyinchiliklarga bardosh berish insonning yetukligini ko‘rsatadi.',
            'Men uchun insoniy hurmat moddiy boylikdan muhimroqdir.',
            'Qaror qabul qilishda o‘z e’tiqodimga tayanaman.',
            'Juftim bilan ma’naviy jihatdan uyg‘un bo‘lish men uchun juda muhim.',
            'Men uchun bolalar tarbiyasida axloqiy qadriyatlar birinchi o‘rinda turadi.',
            'Oilaviy hayotda har ikki tomonning qarashlari teng muhim bo‘lishi kerak.',
            'Meni o‘zgartirishga harakat qiladigan juftlik bilan yashash qiyin deb hisoblayman.',
            'Men uchun sadoqat, ishonch va mehr-oqibat asosiy hayotiy ustuvorliklardir.',
            'Men har qanday vaziyatda adolatli bo‘lishga harakat qilaman.',
            'Men oilaviy muammolarni tashqi aralashuvsiz hal qilish tarafdoriman.',
            'Mening uchun bolalarning tarbiyasi umumiy mas’uliyatdir.',
            'Har bir inson o‘z qarashlariga ega bo‘lish huquqiga ega deb o‘ylayman.',
            'Oila ichidagi qadriyatlar umumiy kelishuv asosida shakllanishi kerak.',
            'Men uchun madaniyat va an’analarni saqlash muhim.',
            'Har bir qaror oldidan ijtimoiy va ma’naviy oqibatlarni hisobga olaman.',
            'Men uchun ruhiy uyg‘unlik moddiy barqarorlikdan ustun.',
            'Men har doim haqiqatni aytishni qadrlayman, hatto bu og‘riqli bo‘lsa ham.',
            'Men uchun oilaviy hayotda bardavomlik va sadoqat muhim.',
            'Men ijtimoiy tazyiqqa emas, ichki e’tiqodimga asoslanaman.',
            'Men har doim o‘z qarorim uchun javobgarlikni his qilaman.',
            'Men doimo farzandlarimga hayotiy qadriyatlarni o‘rgatishga intilaman.',
            'Men turmush o‘rtog‘imning hayotiy pozitsiyasini tushunishga harakat qilaman.',
            'Men uchun oilaviy an’analar muqaddas.',
            'Men qadriyatlarni vaqtinchalik emas, doimiy narsa deb bilaman.',
            'Har bir insonning hayotiy qadriyatlari shakllanadigan muhitga bog‘liq deb hisoblayman.',
            'Men shaxsiy manfaatlardan ko‘ra oila manfaatini ustun qo‘yaman.',
            'Hayotiy pozitsiyalarimiz turli bo‘lsa ham, murosaga tayyorman.',
            'O‘z qarashlarimni tushuntirib bera olish men uchun muhim.',
            'Men uchun turmush o‘rtog‘im bilan qadriyatlardagi uyg‘unlik muhimroq.',
            'Qarashlar farqlansa ham, birga yechim topish mumkinligiga ishonaman.',
        ];

        // MOLIYAVIY YONDASHUV - 50 savol
        $moliyaQuestions = [
            'Pulni tejashga moyilmisiz?',
            'Juftingiz bilan daromadingizni bo‘lishishga tayyormisiz?',
            'Pul sarflayotganda reja asosida harakat qilasizmi?',
            'Kredit olishdan oldin juftingiz bilan maslahat qilasizmi?',
            'Har oy jamg‘arma qilasizmi?',
            'Pul bilan bog‘liq masalalarda stressga tushasizmi?',
            'Moliyaviy qarorlar sizda xavotir uyg‘otadimi?',
            'Yirik xaridlar sizda hissiy bosim keltiradimi?',
            'Moliyaviy rejalar tuzishda turmush o‘rtog‘ingiz qatnashishini xohlaysizmi?',
            'Juftingizning moliyaviy holatini bilish siz uchun muhimmi?',
            'Pul haqida ochiq gaplashish sizga qiyinmi?',
            'Moliyaviy muammolarni juftingizdan yashirasizmi?',
            'Qarzga botganingizni juftingizga bildirasizmi?',
            'To‘lovlarni kechiktirish sizda xavotir uyg‘otadimi?',
            'Pul ishlash sizga quvonch yoki zo‘riqish olib keladimi?',
            'Moliyaviy maqsadlaringizni yozib yuritasizmi?',
            'Jamg‘arma yo‘qligi sizda tashvish uyg‘otadimi?',
            'Pul bilan bog‘liq masalalarda siz o‘zingizga ishonasizmi?',
            'Juftingiz bilan umumiy byudjet yuritish sizga og‘irlik qiladimi?',
            'Moliyaviy mustaqillik siz uchun ruhiy xotirjamlik manbaimi?',
            'Siz pulni sarflashda his-tuyg‘ularga buysunasizmi?',
            'Juftingizdan moliyaviy yordam olish sizga noqulaylik tug‘diradimi?',
            'Yirik xaridlarda pushaymonlik ko‘p bo‘ladimi?',
            'Oila a\'zolarining moliyaviy talablarini qondirish sizga og‘irlik qiladimi?',
            'Pul ishlash va oilaviy vaqtni muvozanatlashtirish siz uchun muammomi?',
            'Siz jamg‘arma qilganingizda o‘zingizni yaxshi his qilasizmi?',
            'Puldan ko‘ra vaqt siz uchun muhimroqmi?',
            'O‘z daromadingiz yetarli emasligidan ko‘p xavotirlanasizmi?',
            'Moliyaviy tanglik paytida asabiylashasizmi?',
            'Pul to‘g‘risidagi bahslar sizni ruhan charchatadimi?',
            'Tejamkorlikni o‘rganish siz uchun muhimmi?',
            'Juftingizning moliyaviy qarorlariga aralashasizmi?',
            'Pul haqida noto‘g‘ri qaror qabul qilganingizda afsuslanasizmi?',
            'Har qanday holatda ham o‘zingizni moddiy jihatdan erkin his qilishni xohlaysizmi?',
            'Jamg‘arma bo‘lmasa, o‘zingizni himoyasiz his qilasizmi?',
            'Har oy mablag‘larni rejalashtirish sizga og‘irlik qiladimi?',
            'Ko‘p pul sarflaganingizda o‘zingizni aybdor his qilasizmi?',
            'Juftingiz sizdan ko‘proq daromad qilsa, bu sizga ta’sir qiladimi?',
            'Siz uchun oilaviy sodiqlik moliyaviy sadoqat bilan ham bog‘liqmi?',
            'Har bir xariddan oldin tafakkur qilasizmi?',
            'Moliyaviy yutuqlar sizga psixologik motivatsiya beradimi?',
            'Qarzdan qutulish sizda yengillik hissini uyg‘otadimi?',
            'Moliyaviy rejalashtirishga vaqt ajrata olasizmi?',
            'Pulga bo‘lgan noaniqlik sizni stressga soladimi?',
            'Siz uchun daromaddan ko‘ra barqarorlik muhimroqmi?',
            'Moliyaviy qiyinchiliklar sizda yakkalanish hissini paydo qiladimi?',
            'Turmush o‘rtog‘ingiz bilan pul haqida suhbat sizni yaqinlashtiradimi?',
            'Pul ishlashda o‘zingizga bosim o‘rnatasizmi?',
            'Moliyaviy erkinlikka erishganingizda o‘zingizni to‘liq qadrlaysizmi?',
            'Moliyaviy kelishmovchiliklar ruhiy muvozanatingizga ta’sir qiladimi?',
        ];

        // HISSIY BARQARORLIK - 50 savol
        $hissiyQuestions = [
            'Stressli vaziyatlarda o‘zingizni tezda bosib olasizmi?',
            'Kutilmagan muammolar sizni ruhiy jihatdan charchatadimi?',
            'Juftingiz bilan janjal qilganingizdan keyin o‘zingizni xafa bo’lasizmi?',
            'Sizdagi asabiylik juftingiz bilan munosabatlarga ta’sir qilamidi?',
            'O‘zingizni tinchlantirishning o‘ziga xos usullari bormi?',
            'Muammolarni ichingizda saqlab yurishga moyilmisiz?',
            'Biror narsa sizga yoqmasa, bu haqda ochiq aytasizmi?',
            'Ko‘p hollarda o‘zingizni tushkun kayfiyatda his qilasizmi?',
            'Turmush o‘rtog‘ingiz sizni tushunmayotganini his qilgan paytingiz bo‘lganmi?',
            'Kutilmagan og‘ir xabarlarni juftingiz bilan bo‘lishasizmi?',
            'Salbiy emotsiyalarni boshqarish sizga osonmi?',
            'O‘z ustingizda ishlashga doimo harakat qilasizmi?',
            'Asabiylikdan keyin tezda tinchlanasizmi?',
            'Sizni jahlingiz tez chiqadimi?',
            'Murojaatga salbiy javob olganingizda buni juftingizga bildirasizmi?',
            'Juftingizning sizga nisbatan tanqidini to‘g‘ri qabul qilasizmi?',
            'Sizga muhim bo‘lgan insonlar bilan tez-tez janjallashib turasizmi?',
            'Uzoq vaqt davomida asabiy holatda bo‘lasizmi?',
            'Hissiy barqarorlikka erishish uchun yoga, meditatsiya yoki ibodat qilasizmi?',
            'Ichki xotirjamlik siz uchun ahamiyatga egami?',
            'Emotsiyalarni boshqarish juftingiz uchun muhim deb hisoblaysizmi?',
            'Kundalik hayotdagi vaziyatlar sizni tez-tez ruhan charchatadimi?',
            'Juftingizda Sizni ilhomlantiradigan qirralar bormi?',
            'His-tuyg‘ularingizni ifoda etishda ochiqmisiz?',
            'O‘zingizni izolyatsiya (qobiqqa uralish) qilish odatingiz bormi?',
            'Sizga yaqin insonlarning muammolari sizga ta’sir qiladimi?',
            'O‘zingizni ruhiy jihatdan sog‘lom deb hisoblaysizmi?',
            'Hissiyotlaringizni boshqalardan yashirasizmi?',
            'Juftingizning hissiy holati sizga qanday ta’sir qiladi?',
            'Kayfiyatingiz tez-tez o‘zgarib turadimi?',
            'Biror kishi sizni tushkunlikka solsa, tezda tiklana olasizmi?',
            'Ba’zan o‘zingizni hech narsaga arzimaydigan deb his qilasizmi?',
            'Siz ruhiy bosimni kamaytirish uchun o‘zingizni yolg‘iz qoldirishga harakat qilasizmi?',
            'Juftingiz bilan ochiq hissiy aloqada bo‘lishga tayyormisiz?',
            'Ichki xotirjamlik siz uchun muhimmi?',
            'Emotsional muvozanatni saqlashga harakat qilasizmi?',
            'Sizga nisbatan ko‘tarilgan ovoz sizni ruhan izdan chiqaradimi?',
            'Siz muammolarni hissiy emas, mantiqiy yondashuv bilan hal qilasizmi?',
            'Juftingiz sizga befarq bo‘lsa, siz ruhiy bezovtalikni his qilasizmi?',
            'Sizni odatda atrofdagilar to‘liq tushunadi, deb o‘ylaysizmi?',
            'Tashqi tanqid sizni ruhiy jihatdan qiynaydimi?',
            'Sizda o‘z-o‘zini tinchlantirishga qaratilgan odatlar bormi?',
            'Siz xavotirlaringiz ustidan nazorat o‘rnatishga odatlanigansizmi?',
            'Sizda tez-tez ruhiy charchoq bo‘lib turadimi?',
            'Hissiy vaziyatlarda sizda asabiylashish alomatlari ko‘rinadimi?',
            'Ruhiy bosim ostida o‘zingizni boshqara olasizmi?',
            'Salbiy vaziyatlardan keyin kayfiyatingizni tiklay olish qobiliyatingiz bormi?',
            'O‘z his-tuyg‘ularingizni tan olishga tayyormisiz?',
            'Kayfiyatga ko‘ra qaror qabul qilasizmi?',
            'Ruhiy barqarorlikni saqlash uchun professional yordam so‘raganmisiz?',
        ];

        // FARZAND TARBIYASI - 50 savol
        $farzandQuestions = [
            'Farzand tarbiyasida ota-onaning ikkalasi ham faol ishtirok etishi kerak deb o‘ylaysizmi?',
            'Bolani jazolashdan ko‘ra tushuntirish samaraliroq deb hisoblaysizmi?',
            'Farzandni mehr bilan tarbiyalashning ahamiyatiga ishonasizmi?',
            'Har bir farzandning individual qobiliyatlarini rivojlantirish muhim deb o‘ylaysizmi?',
            'Sizningcha, bolaga qat’iy tartib va intizom kerakmi?',
            'Siz farzand tarbiyasida mehr va nazoratni muvozanatda ushlaysizmi?',
            'Siz bolalarning fikrini inobatga olasizmi?',
            'Siz farzandga o‘z fikrini erkin aytishga ruxsat berasizmi?',
            'Siz uchun diniy tarbiya bolalar uchun zarurmi?',
            'Sizningcha, farzandga yoshligidan mehnatni o‘rgatish kerakmi?',
            'Siz bolaga mustaqillik berishga intilasizmi?',
            'Oila ichidagi nizolarni farzandlardan yashirish lozim deb hisoblaysizmi?',
            'Siz farzandlaringizga doimiy e’tibor ajrata olasizmi?',
            'Siz bolaning muvaffaqiyatini doimo quvvatlaysizmi?',
            'Farzand tarbiyasida kitob o‘qitish va bilim berish muhimmi?',
            'Siz farzandga kichik yoshdan mas’uliyat yuklash tarafdorimisiz?',
            'Farzandlaringiz uchun vaqt ajratish siz uchun ustuvor vazifami?',
            'Siz farzandlaringizga teng muomala qilasizmi?',
            'Bolalar savollariga jiddiy yondashasizmi?',
            'Siz bolalarning psixologik holatiga e’tibor berasizmi?',
            'Siz farzandlaringizga tushuntirib bera olasizmi?',
            'Farzandlarga mustaqil fikr yuritishni o‘rgatish kerak deb o‘ylaysizmi?',
            'Siz farzandlaringizga doim ijobiy namuna bo‘lishga harakat qilasizmi?',
            'Siz bolalarga telefon va gadjetlardan cheklov qo‘yasizmi?',
            'Bolaga moliyaviy tarbiya berish kerak deb hisoblaysizmi?',
            'Farzandlaringizni do‘stlari bilan tanishishga intilasizmi?',
            'Siz bolaning muammolarini e’tiborsiz qoldirmaysizmi?',
            'Siz farzandlaringizni doimo tinglaysizmi?',
            'Siz farzandlaringizni bir-biriga nisbatan hasad qilmaslikka o‘rgatasizmi?',
            'Farzandlar tarbiyasida mehribonlik va intizomni birgalikda olib borasizmi?',
            'Siz bolaning noto‘g‘ri xatti-harakatlariga darhol javob berasizmi?',
            'Siz farzandni moddiy rag‘bat bilan tarbiyalash tarafdorimisiz?',
            'Siz uchun bolaning hissiy holati uning baholaridan muhimmi?',
            'Siz o‘qituvchilar bilan doimiy aloqada bo‘lib borasizmi?',
            'Siz farzandlaringizni ijtimoiy tarmoqlardagi faolligini kuzatasizmi?',
            'Siz bolaning tarbiyasida sport va san’atni muhim deb bilasizmi?',
            'Siz farzandlaringizga hayotiy qadriyatlarni o‘rgatasizmi?',
            'Siz bolalarga jamoada ishlashni o‘rgatasizmi?',
            'Siz farzandlaringizning har bir kichik yutug‘ini qadrlaysizmi?',
            'Siz bolaning maktabdagi harakatlariga qiziqasizmi?',
            'Siz bolani oilaviy muammolardan himoya qilasizmi?',
            'Siz farzandlaringizni mustaqil hayotga tayyorlaysizmi?',
            'Siz farzandlaringizga ishonch bildirasizmi?',
            'Siz bolaning yoshiga mos mas’uliyat yuklaysizmi?',
            'Siz farzand tarbiyasida haddan tashqari nazoratga qarshimisiz?',
            'Siz ota-onangizdan o‘z farzandlaringiz tarbiyasiga aralashmaslikni so‘raysizmi?',
            'Siz bolani tarbiyalashda jismoniy jazoni qo‘llaysizmi?',
            'Siz bola bilan do‘stona munosabatda bo‘lishni afzal bilasizmi?',
            'Siz bolaning xatolariga sabr bilan yondashasizmi?',
            'Siz farzandlaringizni hayotdagi qiyinchiliklarga ruhan tayyorlaysizmi?',
        ];

        // Save questions for each unit
        $this->saveQuestionsForUnit($units['Muloqot va Tushunish'], $admin, $muloqotQuestions);
        $this->saveQuestionsForUnit($units['Qadriyatlar va Hayotga Qarashlar'], $admin, $qadriyatQuestions);
        $this->saveQuestionsForUnit($units['Moliyaviy Yondashuv'], $admin, $moliyaQuestions);
        $this->saveQuestionsForUnit($units['Hissiy Barqarorlik'], $admin, $hissiyQuestions);
        $this->saveQuestionsForUnit($units['Farzand Tarbigasi va Oilaviy Mas\'uliyat'], $admin, $farzandQuestions);
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
