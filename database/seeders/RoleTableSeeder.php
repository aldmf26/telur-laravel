<?php

namespace Database\Seeders;

use App\Models\Kirim_ayam;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 10; $i++) { 
            Kirim_ayam::create([
                'qty' => random_int(1,2),
                'tgl' => '2022-09-27',
                'no_nota' => Str::random(5),
                'kode' => Str::random(4),
                'check' => 'T',
                'pemutihan' => 'T',
                'bawa' => 'KANTOR'
            ]);
        }
    }
}
