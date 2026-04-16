<?php

namespace App\Console\Commands;

use Firebase\JWT\JWT;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateAppleClientSecret extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apple:generateClientSecret';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Apple Sign-In Client Secret (JWT) and update .env file';

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
        $teamId = env('APPLE_TEAM_ID');
        $clientId = env('APPLE_CLIENT_ID');
        $keyId = env('APPLE_KEY_ID');
        $privateKey = file_get_contents(base_path() . '/' . env('APPLE_PRIVATE_KEY_PATH'));

        $now = time();
        $payload = [
            'iss' => $teamId,
            'iat' => $now,
            'exp' => $now + 86400 * 180,
            'aud' => 'https://appleid.apple.com',
            'sub' => $clientId,
        ];

        // Generate the client_secret
        $clientSecret = JWT::encode($payload, $privateKey, 'ES256', $keyId);
        $this->info("Generated Apple Client Secret: " . $clientSecret);

        // Update .env with the new client_secret
        $this->updateEnvFile($clientSecret);
        $this->info("client_secret has been updated in .env file.");

        // Clear config cache to apply the new secret
        $this->call('config:clear');

    }

    protected function updateEnvFile($clientSecret)
    {
        // Get the current environment
        $environment = app()->environment();
        $envPath = '';

        // Determine the corresponding .env file using if-else
        if ($environment === 'local') {
            $envPath = base_path('.local.env');
        } elseif ($environment === 'staging') {
            $envPath = base_path('.staging.env');
        } elseif ($environment === 'acceptance') {
            $envPath = base_path('.acceptance.env');
        } elseif ($environment === 'production') {
            $envPath = base_path('.production.env');
        } else {
            $envPath = base_path('.env');
        }

        // Check if the selected .env file exists
        if (file_exists($envPath)) {
            // Read the .env file contents
            $envContents = file_get_contents($envPath);

            // Replace the old APPLE_CLIENT_SECRET with the new one
            $newEnvContents = preg_replace(
                '/APPLE_CLIENT_SECRET=(.*)/',
                'APPLE_CLIENT_SECRET=' . $clientSecret,
                $envContents
            );

            // Save the updated contents back to the selected .env file
            File::put($envPath, $newEnvContents);

            $this->info("Updated the $environment environment's .env file.");
        } else {
            $this->error("The .env file for $environment environment does not exist.");
        }
    }
}
