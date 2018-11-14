<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CertificateVersions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_versions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('certificate_id')->unsigned()->index();
            $table->foreign('certificate_id')->references('id')->on('certificates')->onDelete('cascade');
            $table->string('verification_code', 20);
            $table->string('user_hash', 40);
            $table->unique(['user_hash', 'verification_code']);
            $table->integer('views')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificate_versions');
    }
}
