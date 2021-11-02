<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            'instruments' => [],
            'setups' => [],
            'mistakes' => [],
            'generals' => [
                'currency' => 'Rp',
                'decimals' => 2,
                'public_page' => false
            ],
            'balances' => [],
        ];

        Schema::create('settings', function (Blueprint $table) use ($data) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->jsonb('data')->default(json_encode($data));
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
        Schema::dropIfExists('settings');
    }
}
