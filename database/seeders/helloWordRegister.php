<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class helloWordRegister extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $this->call([
            RolAdmin::class,
            UsuarioAdmin::class,
        ]);
    }
}
