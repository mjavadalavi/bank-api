<?php

namespace Database\Seeders;

use App\Models\DebitCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DebitCardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DebitCard::factory()
            ->count(2)
            ->forBankAccount()
            ->hasTransactions(5)
            ->create();
    }
}
