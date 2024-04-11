<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeDescriptionNullableInToolsTable extends Migration
{
    public function up()
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
        });
    }
}
