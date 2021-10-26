<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['Percentage', 'Fixed']);
            $table->decimal('value', 19, 2);
            $table->decimal('min_spending', 19, 2)->default(0);
            $table->decimal('max_discount', 19, 2)->nullable();
            $table->integer('max_use_count')->nullable();
            $table->boolean('first_time_user')->default(false);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocodes');
    }
}
