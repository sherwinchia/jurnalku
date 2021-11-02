<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->string('instrument');
            $table->string('setup')->nullable();
            $table->string('mistake')->nullable();
            $table->timestamp('entry_date');
            $table->timestamp('exit_date')->nullable();
            $table->decimal('entry_price', 19, 2);
            $table->decimal('exit_price', 19, 2)->nullable();
            $table->decimal('take_profit', 19, 2);
            $table->decimal('stop_loss', 19, 2);
            $table->decimal('quantity', 19, 2);
            $table->decimal('entry_fee', 19, 2)->default(0);
            $table->decimal('exit_fee', 19, 2)->default(0);
            $table->decimal('gain_loss', 19, 2)->nullable();
            $table->boolean('favorite')->default(0);
            $table->text('note')->nullable();
            $table->enum('status',['open', 'win', 'lose', 'neutral', 'close'])->default('open');
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
        Schema::dropIfExists('trades');
    }
}
