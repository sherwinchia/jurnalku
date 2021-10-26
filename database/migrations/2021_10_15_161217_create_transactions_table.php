<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('package_id')->constrained();
            $table->enum('status', ['Pending', 'Success', 'Fail', 'Cancelled'])->default('Pending');
            $table->foreignId('promo_code_id')
                ->nullable()
                ->constrained();
            $table->decimal('gross_total', 19, 2);
            $table->decimal('discount', 19, 2)->default(0);
            $table->decimal('net_total', 19, 2);
            $table->string('reference');
            $table->string('merchant_ref');
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
        Schema::dropIfExists('transactions');
    }
}
