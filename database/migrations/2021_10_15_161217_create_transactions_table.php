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
                ->nullable()
                ->constrained()
                ->onDelete('set null');
            // $table->foreignId('package_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['pending', 'success', 'fail', 'cancelled', 'expired'])->default('pending');
            $table->foreignId('promocode_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');
            $table->decimal('gross_total', 19, 2);
            $table->decimal('discount', 19, 2)->default(0);
            $table->decimal('net_total', 19, 2);
            $table->string('reference')->nullable();
            $table->string('merchant_ref')->unique();
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
