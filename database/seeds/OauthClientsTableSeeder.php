<?php

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\CodeDelivery\Models\OauthClients::class)->create([
            'id' => 'appid01',
            'secret' => 'secret',
            'name' => 'Minha APP Mobile'
        ]);
    }
}
