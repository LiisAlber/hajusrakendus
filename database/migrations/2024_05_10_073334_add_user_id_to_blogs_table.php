<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Check if the column already exists
            if (!Schema::hasColumn('blogs', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
            } else {
                
                DB::table('blogs')->whereNull('user_id')->update(['user_id' => 1]); // Default user ID
                $table->foreignId('user_id')->change()->nullable(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
