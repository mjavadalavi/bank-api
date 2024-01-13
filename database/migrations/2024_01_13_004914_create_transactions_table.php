<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_debit_card_id')->constrained('debit_cards');
            $table->foreignId('to_debit_card_id')->constrained('debit_cards');
            $table->double('from_user_balance');
            $table->double('to_user_balance');
            $table->decimal('amount', 10, 2);
            $table->boolean('verified')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
