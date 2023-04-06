<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->after('Nama', function($table) {
                $table->unsignedBigInteger('kelas_id')->nullable(); //menambahhkan kolom kelas_id
                $table->foreign('kelas_id')->references('id')->on('kelas'); //menambahkan foreign key di kolom kelas_id
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function(Blueprint $table) {
            $table->dropForeign(['kelas_id']);
        });
    }
};
