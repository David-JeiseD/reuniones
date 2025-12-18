<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UgelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ugels = ['UGEL 01', 'UGEL 02', 'UGEL 03', 'UGEL 04', 'UGEL 05', 'UGEL 06', 'UGEL 07'];
    foreach($ugels as $u) {
        \App\Models\Ugel::create(['nombre' => $u]);
    }
    }
}
