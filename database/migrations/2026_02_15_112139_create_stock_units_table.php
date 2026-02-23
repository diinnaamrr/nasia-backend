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
        Schema::create('stock_units', function (Blueprint $table) {
    $table->id();

    $table->foreignId('department_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->string('title');
    $table->string('slug')->unique();

    $table->text('description')->nullable();

    $table->decimal('base_price', 10, 2);

    $table->integer('quantity')->default(0);

    $table->string('thumbnail')->nullable();

    $table->boolean('active')->default(true);

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_units');
    }
};
