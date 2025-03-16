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
    Schema::create('projects',function(Blueprint $table){
        $table->id();
        $table->string("title");
        $table->text("description")->nullable();
        $table->string('source_code')->nullable(); // GitHub/Bitbucket URL
        $table->string('image')->nullable(); // Store image path
        $table->timestamps(); // Created_at & Updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('projects');
    }
};
