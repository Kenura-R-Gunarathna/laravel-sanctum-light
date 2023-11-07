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
        Schema::create('fields', function (Blueprint $table) {
            $table->id(); // Use id as the identifier/code-name
            $table->string('name')->comment('Name of the field');
            $table->string('placeholder')->comment('Placeholder of the field');
            $table->boolean('required')->default(0)->comment('Nullable or not');
            $table->unsignedInteger('max')->nullable();
            $table->unsignedInteger('min')->nullable();
            $table->string('default')->nullable();
            $table->string('type')->comment('E.g., text, textarea, select, radio, checkbox'); // e.g., text, textarea, select, radio, checkbox
            $table->json('options')->nullable()->comment('JSON field for select, radio, and checkbox options. Save as an identifier by converting to the slug. Special characters are removed.'); // JSON field for select, radio, and checkbox options.
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
