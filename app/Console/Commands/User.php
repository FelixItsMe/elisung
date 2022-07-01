<?php

namespace App\Console\Commands;

use App\Models\User as ModelsUser;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class User extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user {nik}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        try {
            $nik = $this->argument('nik');

            $faker = Factory::create('id_ID');
            ModelsUser::create([
                'name' => $faker->name,
                'nik' => $this->argument('nik'),
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);

            $this->info("Berhasil membuat user");
        } catch (\Throwable $th) {
            $this->info($th);
        }

    }
}
