<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Employee::factory()
            ->count(10) // Cria 10 vendedores
            ->hasSales(5) // Cada vendedor tem 5 vendas
            ->create();
    }
}
