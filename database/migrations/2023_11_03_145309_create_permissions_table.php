<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id(); // Use id as the identifier/code-name
            $table->string('name')->comment('Type of data is controlling. Eg:- Students, Teachers, O/L Students');
            $table->enum('action', ['*', 'index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
            $table->foreignIdFor(Role::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
