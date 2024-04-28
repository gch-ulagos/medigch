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

        if (!Schema::hasTable('ordenes')) {
            Schema::create('ordenes', function ($table) {
                $table->bigIncrements('id');
                $table->foreignId('patient_id')->constrained('users');
                $table->foreignId('medic_id')->constrained('users');
                $table->timestamps();
            });
        }


        if (!Schema::hasTable('examen')) {
            Schema::create('examen', function ($table) {
                $table->bigIncrements('id');
                $table->foreignId('order_id')->constrained('ordenes');
                $table->string('archivo');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('detalleOrden')) {
            Schema::create('detalleOrden', function ($table) {
                $table->bigIncrements('id');
                $table->foreignId('order_id')->constrained('ordenes');
                $table->string('detalle', 100);
            });
        }    
    }
}
   
