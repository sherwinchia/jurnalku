<?php

namespace App\Helpers;

class UserSettings{

    private $data;
    private $total_balance;
    // private $generals;
    // private $instruments;
    // private $setups;
    // private $mistakes;
    // private $balances;

    public function __construct()
    {
        $this->data = json_decode(current_user()->setting->data);
        // $this->generals = $data->generals;
        // $this->instruments = $data->instruments;
        // $this->setups = $data->setups;
        // $this->mistakes = $data->mistakes;
        // $this->balances = $data->balances;
    }

    private function getData()
    {
        return $this->data;
    }

    private function set_data()
    {

    }

    public function get_total_balance()
    {

    }

    public function set_total_balance()
    {
        $balances = $this->data->balances;
        $total_balance = 0;

        foreach ($balances as $balance) {
            if ($balance->type == "deposit") {
                $total_balance += $balance->amount;
            } else{
                $total_balance -= $balance->amount;
            }
        }

        return $total_balance;
    }

    public static function all()
    {
        return app(UserSettings::class)->getData();
    }

}
