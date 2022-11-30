<?php
namespace Database\Seeders;

use App\Models\SportEvent;
use Illuminate\Database\Seeder;

class SportEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SportEvent::factory()->count(10)->create();
    }
}
