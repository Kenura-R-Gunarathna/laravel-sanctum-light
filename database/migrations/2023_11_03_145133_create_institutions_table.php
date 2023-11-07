<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Slug;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Slug::class);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
