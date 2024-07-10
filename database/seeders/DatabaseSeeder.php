<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Note::factory()->count(3)->create(); // Assuming you have a Note factory
        \App\Models\Note::factory()->create(); // Assuming you have a Note
    }
}
