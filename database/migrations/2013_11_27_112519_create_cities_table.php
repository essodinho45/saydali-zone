<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country');
            $table->string('ar_name')->unique()->nullable();
            $table->string('en_name')->unique()->nullable();
            $table->timestamps();

            $table->foreign('country')->references('id')->on('countries');

        });
        DB::table('cities')->insert(
            array(
            ['country'=>1,'ar_name'=>'دمشق', 'en_name'=>'Damascus'],
            ['country'=>1,'ar_name'=>'ريف دمشق', 'en_name'=>'Damascus Countryside'],
            ['country'=>1,'ar_name'=>'درعا', 'en_name'=>'Dara\'a'],
            ['country'=>1,'ar_name'=>'السويداء', 'en_name'=>'Sweida'],
            ['country'=>1,'ar_name'=>'القنيطرة', 'en_name'=>'Qunietra'],
            ['country'=>1,'ar_name'=>'حمص', 'en_name'=>'Homs'],
            ['country'=>1,'ar_name'=>'حماه', 'en_name'=>'Hama'],
            ['country'=>1,'ar_name'=>'حلب', 'en_name'=>'Aleppo'],
            ['country'=>1,'ar_name'=>'ادلب', 'en_name'=>'Idlib'],
            ['country'=>1,'ar_name'=>'اللاذقية', 'en_name'=>'Lattakia'],
            ['country'=>1,'ar_name'=>'طرطوس', 'en_name'=>'Tartous'],
            ['country'=>1,'ar_name'=>'الرقة', 'en_name'=>'Raqqa'],
            ['country'=>1,'ar_name'=>'دير الزور', 'en_name'=>'Deir Azzour'],
            ['country'=>1,'ar_name'=>'الحسكة', 'en_name'=>'Al Hasaka'],
            ['country'=>2,'ar_name'=>'بيروت', 'en_name'=>'Beirut'],
            ['country'=>2,'ar_name'=>'الجنوب', 'en_name'=>'South'],
            ['country'=>2,'ar_name'=>'الشمال', 'en_name'=>'North'],
            ['country'=>2,'ar_name'=>'جبل لبنان', 'en_name'=>'Mount Lebanon'],
            ['country'=>2,'ar_name'=>'البقاع', 'en_name'=>'Bekaa'],
            ['country'=>2,'ar_name'=>'النبطية', 'en_name'=>'Nabatiye'],
            ['country'=>2,'ar_name'=>'عكار', 'en_name'=>'Akkar'],
            ['country'=>2,'ar_name'=>'بعلبك-الهرمل', 'en_name'=>'Baalbak-Hermel'],
            ['country'=>3,'ar_name'=>'عمّان', 'en_name'=>'Amman'],
            ['country'=>3,'ar_name'=>'إربد', 'en_name'=>'Irbid'],
            ['country'=>3,'ar_name'=>'عجلون', 'en_name'=>'Ajloun'],
            ['country'=>3,'ar_name'=>'جرش', 'en_name'=>'Jerash'],
            ['country'=>3,'ar_name'=>'المفرق', 'en_name'=>'Mafraq'],
            ['country'=>3,'ar_name'=>'البلقاء', 'en_name'=>'Balqa\'a'],
            ['country'=>3,'ar_name'=>'الزرقاء', 'en_name'=>'Zarqa\'a'],
            ['country'=>3,'ar_name'=>'مادبا', 'en_name'=>'Madaba'],
            ['country'=>3,'ar_name'=>'الكرك', 'en_name'=>'Karak'],
            ['country'=>3,'ar_name'=>'الطفيلة', 'en_name'=>'Tafilah'],
            ['country'=>3,'ar_name'=>'معان', 'en_name'=>'Ma\'an'],
            ['country'=>3,'ar_name'=>'العقبة', 'en_name'=>'Aqaba'],
            ['country'=>4,'ar_name'=>'الرياض', 'en_name'=>'Riyadh'],
            ['country'=>4,'ar_name'=>'مكّة المكرمة', 'en_name'=>'Makkah'],
            ['country'=>4,'ar_name'=>'المدينة المنورة', 'en_name'=>'Madinah'],
            ['country'=>4,'ar_name'=>'عرعر', 'en_name'=>'Arar'],
            ['country'=>4,'ar_name'=>'القصيم', 'en_name'=>'Qassim'],
            ['country'=>4,'ar_name'=>'تبوك', 'en_name'=>'Tabuk'],
            ['country'=>4,'ar_name'=>'الجوف', 'en_name'=>'Jawf'],
            ['country'=>4,'ar_name'=>'حائل', 'en_name'=>'Ha\'il'],
            ['country'=>4,'ar_name'=>'الباحة', 'en_name'=>'Bahah'],
            ['country'=>4,'ar_name'=>'جيزان', 'en_name'=>'Jizan'],
            ['country'=>4,'ar_name'=>'عسير', 'en_name'=>'A\'asir'],
            ['country'=>4,'ar_name'=>'نجران', 'en_name'=>'Najran'],
            ['country'=>4,'ar_name'=>'المنطقة الشرقية', 'en_name'=>'Eastern Province'],
            )
    ); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
