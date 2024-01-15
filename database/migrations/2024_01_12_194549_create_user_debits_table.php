<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('debit_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_account_id')->constrained();
            $table->string('card_number')->unique();
            $table->integer('cvv2')->default(rand(100, 9999));
            $table->dateTime('expired_at')->default(now()->addYears(2));;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('debit_cards');
    }
};
