<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Field;

return new class extends Migration
{
    /**
     * This allows users, accounts, institutions, roles and groups to have common fileds through the site.
     */
    public function up(): void
    {
        Schema::create('fieldables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Field::class)->constrained()->onDelete('cascade'); // Field id.
            $table->unsignedBigInteger('fieldable_id');
            $table->string('fieldable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fieldables');
    }
};
