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
        Schema::create('cweb_rekon_opsen', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_trn');
            $table->string('kd_upt');
            $table->string('kd_wilayah');
            $table->string('kd_ref')->unique();
            $table->decimal('jml_trf', 20, 2); // Adjust precision and scale as needed
            $table->string('keterangan')->nullable();
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cweb_rekon_opsen');
    }
};
