<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payload = [
            [
                'user_id' => null,
                'name' => 'vox-teneo Password Grant Client',
                'secret' => 'D6DKUJAyMZaU8t1wOB8pzhhFv5lobGZjeoCZYU2R',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => false,
                'password_client' => true,
                'revoked' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => null,
                'name' => 'vox-teneo Password Grant Client',
                'secret' => 'ZO8oQTKF5cwTweK4kHO3uYSVshtLIckJgBS1icM2',
                'provider' => null,
                'redirect' => 'http://localhost',
                'personal_access_client' => true,
                'password_client' => false,
                'revoked' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($payload as $item) {
            DB::table('oauth_clients')->insert($item);
        }
    }
}
