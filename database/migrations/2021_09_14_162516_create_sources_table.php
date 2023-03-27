<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
//            $table->id();
            $table->string('lead_id')->nullable();
            $table->string('ipAddress')->nullable();
            $table->longText('userAgent')->nullable();
            $table->longText('referringUrl')->nullable();
            $table->longText('creationUrl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sources');
    }
}


/**
 * php artisan migrate:refresh --path=/database/migrations/2021_09_15_205156_create_lmspayday_u_s_table.php --force
 *
php artisan migrate:refresh --path=/database/migrations/2021_09_14_162516_create_sources_table.php --force
php artisan migrate:refresh --path=/database/migrations/2021_09_14_162534_create_loans_table.php --force
php artisan migrate:refresh --path=/database/migrations/2021_09_14_162548_create_applicants_table.php --force
php artisan migrate:refresh --path=/database/migrations/2021_09_14_162601_create_residences_table.php --force
php artisan migrate:refresh --path=/database/migrations/2021_09_14_162610_create_employers_table.php --force
php artisan migrate:refresh --path=/database/migrations/2021_09_14_162611_create_expenses_table.php --force
php artisan migrate:refresh --path=/database/migrations/2021_09_14_162619_create_banks_table.php --force
php artisan migrate:refresh --path=/database/migrations/2021_09_14_162628_create_consents_table.php --force
php artisan migrate:refresh --path=/database/migrations/2021_09_14_170120_create_additionals_table.php --force
 *
 */