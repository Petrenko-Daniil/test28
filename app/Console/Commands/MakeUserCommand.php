<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MakeUserCommand extends Command
{
    protected $signature = 'make:user';

    protected $description = 'Creating a new user with API token';

    public function handle()
    {
        $name = $this->ask('Enter your name: ');
        $email = $this->ask('Enter your email: ');
        $password = $this->ask('Enter your password (press Enter for random)', md5(Carbon::now()->toIso8601String()));
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = \Hash::make($password);
        $user->save();
        $tokenName = $this->ask('Enter name for your token', 'default');
        $token = $user->createToken($tokenName);
        $this->alert('SAVE YOUR AUTH DATA IN SAFE PLACE');
        $this->table(
            ['FIELD', 'VALUE'],
            [
                [
                    'email', $email
                ],
                [
                    'password', $password,
                ],
                [
                    'token-name', $tokenName
                ],
                [
                    'token', $token->plainTextToken
                ]
            ]
        );
        return $this::SUCCESS;
    }
}
