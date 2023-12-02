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
        Schema::create('employees_count_in_org', function (Blueprint $table) {
            $table->integer('employees_count')->default(0);
            $table->integer('org_id')->unique();
            $table->foreign('org_id')
                ->references('id')
                ->on('organizations')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees_count_in_org');
    }
};
