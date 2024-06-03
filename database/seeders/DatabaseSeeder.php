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
                $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('medic_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
            });
        }
        
        if (!Schema::hasTable('examens')) {
            Schema::create('examens', function ($table) {
                $table->bigIncrements('id');
                $table->foreignId('order_id')->constrained('ordenes')->onDelete('cascade');
                $table->string('archivo');
                $table->timestamps();
            });
        }
        
        if (!Schema::hasTable('detalles')) {
            Schema::create('detalles', function ($table) {
                $table->bigIncrements('id');
                $table->foreignId('order_id')->constrained('ordenes')->onDelete('cascade');
                $table->string('detalle', 100);
                $table->timestamps();
            });
        }         
    }
}
   
