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
        Schema::create('project_person', function (Blueprint $table) {
            $table->foreignId('project_id')->contrained('projects')->onDelete('cascade');
            $table->foreignId('person_id')->contrained('people')->onDelete('cascade');
            $table->primary(['project_id', 'person_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_person');
    }
};
