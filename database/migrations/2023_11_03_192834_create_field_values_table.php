<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Fieldable;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('account_id')->constrained()->cascadeOnDelete(); // Role dependant.
            $table->foreignIdFor(Fieldable::class)->constrained()->onDelete('cascade'); // Fieldable id.
            $table->text('value')->comment('Can be a JSON array or a text value. If null it should prefilled.'); // Value of the field.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_values');
    }
};
