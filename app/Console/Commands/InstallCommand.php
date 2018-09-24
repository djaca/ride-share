<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Question\Question;

class installCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ride-share:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simplify installation process';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->welcome();

        $this->createEnvFile();

        $this->generateAppKey();

        $this->setAppName();

        $credentials = $this->requestDatabaseCredentials();

        $this->updateEnvironmentFile($credentials);

        $this->migrateDatabase($credentials);

        $this->call('cache:clear');

        $this->goodbye();
    }

    /**
     * Display the welcome message.
     */
    protected function welcome()
    {
        $this->info("Welcome to the 'Ride share' installation process!");
    }

    /**
     * Display the completion message.
     */
    protected function goodbye()
    {
        $this->info('The installation process is complete.');
    }

    /**
     * Create the initial .env file.
     */
    protected function createEnvFile()
    {
        if (!file_exists('.env')) {
            copy('.env.example', '.env');
            $this->line('.env file successfully created');
        }
    }

    /**
     * Generate app key.
     */
    protected function generateAppKey()
    {
        if (strlen(config('app.key')) === 0) {
            $this->call('key:generate');
            $this->line('~ Secret key properly generated.');
        }
    }

    protected function setAppName()
    {
        $envFile = $this->laravel->environmentFilePath();

        file_put_contents($envFile, preg_replace(
            ["/APP_NAME=(.*)/", "/APP_URL=(.*)/"],
            ['APP_NAME="Ride share"', 'APP_URL=http://ride-share.test'],
            file_get_contents($envFile)
        ));
    }

    /**
     * Request the local database details from the user.
     *
     * @return array
     */
    protected function requestDatabaseCredentials()
    {
        return [
            'DB_DATABASE' => $this->ask('Database name'),
            'DB_PORT' => $this->ask('Database port', 3306),
            'DB_USERNAME' => $this->ask('Database user (default: root)', 'root'),
            'DB_PASSWORD' => $this->askHiddenWithDefault('Database password (leave blank for no password)'),
        ];
    }

    /**
     * Update the .env file from an array of $key => $value pairs.
     *
     * @param  array $updatedValues
     *
     * @return void
     */
    protected function updateEnvironmentFile($updatedValues)
    {
        $envFile = $this->laravel->environmentFilePath();

        foreach ($updatedValues as $key => $value) {
            file_put_contents($envFile, preg_replace(
                "/{$key}=(.*)/",
                "{$key}={$value}",
                file_get_contents($envFile)
            ));
        }
    }

    /**
     * @param $credentials
     */
    private function migrateDatabase($credentials)
    {
        if ($this->confirm('Do you want to migrate the database with seeds?', false)) {
            $this->migrateDatabaseWithFreshCredentials($credentials);

            $this->line('Database successfully migrated with seeds.');
        }
    }

    /**
     * Migrate the db with the new credentials.
     *
     * @param array $credentials
     *
     * @return void
     */
    protected function migrateDatabaseWithFreshCredentials($credentials)
    {
        foreach ($credentials as $key => $value) {
            $configKey = strtolower(str_replace('DB_', '', $key));

            if ($configKey === 'password' && $value == 'null') {
                config(["database.connections.mysql.{$configKey}" => '']);
                continue;
            }
            config(["database.connections.mysql.{$configKey}" => $value]);
        }

        $this->call('migrate:fresh');
        $this->call('db:seed');
    }

    /**
     * Prompt the user for optional input but hide the answer from the console.
     *
     * @param  string $question
     * @param  bool   $fallback
     *
     * @return string
     */
    public function askHiddenWithDefault($question, $fallback = true)
    {
        $question = new Question($question, 'null');

        $question->setHidden(true)->setHiddenFallback($fallback);

        return $this->output->askQuestion($question);
    }
}
