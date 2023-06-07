<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');

            $table->string('name',100);
            $table->string('first_name',50);
            $table->string('last_name',50);

            $table->timestamp('start_at')->nullable();

            $table->bigInteger('position_id')->unsigned();
            $table->bigInteger('company_id')->unsigned();

            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->timestamps();
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
