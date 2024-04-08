<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LaratrustSeeder::class);
        // User::factory(10)->create();

        if (!Schema::hasTable('ordenes')) {
            Schema::create('ordenes', function ($table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->foreignId('medic_id')->constrained('users');
                $table->text('description');
                $table->timestamps();
            });
        }

        // Crear la tabla "examen" si no existe
        if (!Schema::hasTable('examen')) {
            Schema::create('examen', function ($table) {
                $table->id();
                $table->foreignId('order_id')->constrained('ordenes');
                $table->string('archivo'); // Cambiar a tu tipo de dato específico para archivos
                $table->timestamps();
            });
        }
    }
}
   
