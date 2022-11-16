<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKirimAyamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kirim_ayams', function (Blueprint $table) {
            $table->id();
            $table->integer('qty');
            $table->date('tgl');
            $table->string('no_nota');
            $table->string('kode');
            $table->enum('check', ['T', 'Y'])->default('T');
            $table->enum('pemutihan', ['T', 'Y'])->default('T');
            $table->string('bawa');
            $table->string('admin');
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
        Schema::dropIfExists('kirim_ayams');
    }
}
