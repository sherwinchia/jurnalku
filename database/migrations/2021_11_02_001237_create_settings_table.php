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
                'public_profile' => false
            ],
            'balances' => [],
        ];
        // "a:5:{s:11:\"instruments\";a:0:{}s:6:\"setups\";a:0:{}s:8:\"mistakes\";a:0:{}s:8:\"generals\";a:3:{s:8:\"currency\";s:2:\"Rp\";s:8:\"decimals\";i:2;s:14:\"public_profile\";b:0;}s:8:\"balances\";a:0:{}}"
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