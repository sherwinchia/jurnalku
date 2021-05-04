<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user with role of admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->ask('Enter admin email?');
        $name = $this->ask("Enter admin's name?");
        $password = $this->secret('Enter admin password?');
        $confirmPassword = $this->secret('Confirm password?');

        // Passwords don't match
        if ($password != $confirmPassword) {
            $this->error("Passwords don't match");
            return;
        }

        // Email has error
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || User::where('email', $email)->count() != 0) {
            $this->error("Email is invalid or has been taken");
            return;
        }

        $admin = User::create([
            'email' => $email,
            'name' => $name,
            'password' => bcrypt($password),
            'role_id' => 1
        ]);

        if ($admin) {
            $this->info('Admin has been created successfully.');
        } else {
            $this->error("An error occurred, please try again later");
            return;
        }
    }
}
