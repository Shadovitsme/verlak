<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueEmailFromUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['email']);  // Удаляем уникальный индекс на email
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unique('email');  // Восстанавливаем индекс при откате
        });
    }
}
