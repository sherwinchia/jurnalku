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
            $table->timestamp('exit_date');
            $table->decimal('entry_price', 19, 2);
            $table->decimal('exit_price', 19, 2);
            $table->decimal('take_profit', 19, 2);
            $table->decimal('stop_loss', 19, 2);
            $table->decimal('quantity', 19, 2);
            $table->decimal('fees', 19, 2)->nullable();
            $table->decimal('gain_loss', 19, 2)->nullable();
            $table->boolean('favorite')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // 'portofolio_id',
        // 'entry_date',
        // 'exit_date',
        // 'instrument_id',
        // 'quantity',
        // 'setup_id',
        // 'mistake_id',
        // 'entry_price',
        // 'exit_price',
        // 'take_profit',
        // 'stop_loss',
        // 'fees',
        // 'gain_loss',
        // 'favorite'
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
