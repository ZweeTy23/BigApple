<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add username to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
        });

        // 1. Empleados de cada Sucursal
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('position'); // Cocinero, Cajero, Repartidor, Encargado, Mesero
            $table->string('phone')->nullable();
            $table->decimal('salary_monthly', 10, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Registro de Asistencia / Reloj Checador
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('clock_in')->nullable();
            $table->time('clock_out')->nullable();
            $table->enum('status', ['on_time', 'late', 'absent', 'justified'])->default('on_time');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 3. Apertura y Cierre de Caja (Cortes de Turno)
        Schema::create('cash_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Quien abre/cierra
            $table->dateTime('opened_at');
            $table->dateTime('closed_at')->nullable();
            $table->decimal('opening_amount', 10, 2)->default(0.00); // Fondo inicial en efectivo
            $table->decimal('cash_sales', 10, 2)->default(0.00);
            $table->decimal('card_sales', 10, 2)->default(0.00);
            $table->decimal('transfer_sales', 10, 2)->default(0.00);
            $table->decimal('cash_expenses', 10, 2)->default(0.00); // Salidas de dinero de caja
            $table->decimal('expected_cash', 10, 2)->default(0.00); // Fondo + Ventas Efectivo - Gastos Efectivo
            $table->decimal('counted_cash', 10, 2)->nullable(); // Efectivo real contado al cerrar
            $table->decimal('difference', 10, 2)->default(0.00); // counted_cash - expected_cash
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 4. Insumos e Inventario Local
        Schema::create('supplies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('category'); // Carnes & Pollo, Panadería, Quesos & Lácteos, Salsas, Bebidas, Empaques
            $table->string('unit'); // kg, pzas, litros, paquetes, cajas
            $table->decimal('current_stock', 10, 2)->default(0.00);
            $table->decimal('min_stock', 10, 2)->default(0.00);
            $table->decimal('unit_cost', 10, 2)->default(0.00);
            $table->timestamps();
        });

        // 5. Compras y Gastos Operativos
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category'); // Insumos / Materia Prima, Servicios (Luz/Gas/Agua), Mantenimiento, Nómina, Empaques, Otros
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->string('payment_method')->default('cash'); // cash, transfer, card
            $table->string('receipt_number')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('supplies');
        Schema::dropIfExists('cash_shifts');
        Schema::dropIfExists('attendance_records');
        Schema::dropIfExists('employees');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
