<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher', function (Blueprint $table) {
            $table->increments('voucher_id');
            $table->integer('special_offer_id');
            $table->foreign('special_offer_id')->references('special_offer_id')->on('special_offer')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('recipient_id')->nullable();
            $table->foreign('recipient_id')->references('recipient_id')->on('recipient')->onDelete('cascade')->onUpdate('cascade');
            $table->text('code');
            $table->date('used_at')->nullable();
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
        Schema::dropIfExists('voucher');
    }
}
