<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PeerSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\CountrySeeder;
use Illuminate\Support\Facades\App;
use Database\Seeders\SavedPeerSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\PeerRatingSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\OrganizationSeeder;
use Database\Seeders\ConfigurationSeeder;
use Database\Seeders\SavedOrganizationSeeder;
use Database\Seeders\OrganizationRatingSeeder;
use Database\Seeders\UserFirebaseDeleteSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Create Roles
        $this->call(RolesTableSeeder::class);

        // Create Admin User
        $this->call(AdminSeeder::class);

        if (App::environment(['local']) ||  App::environment(['staging']) || App::environment(['acceptance'])) {
            $this->call(UserFirebaseDeleteSeeder::class);

            // Create User for Testing
            $this->call(UserSeeder::class);

            // Create Country & State Data
            $this->call(CountrySeeder::class);

            // Create Organization for testing
            $this->call(OrganizationSeeder::class);

            // Create Department for testing
            $this->call(DepartmentSeeder::class);

            // Create Organization-Rating for testing
            $this->call(OrganizationRatingSeeder::class);

            // Create Saved-Organization for testing
            $this->call(SavedOrganizationSeeder::class);

            // Create Peer for testing
            $this->call(PeerSeeder::class);

            // Create Peer-Rating for testing
            $this->call(PeerRatingSeeder::class);

            // Create Saved-Peer for testing
            $this->call(SavedPeerSeeder::class);
        }

        $this->call(ConfigurationSeeder::class);

        $this->call(TermsConditionSeeder::class);
        $this->call(PrivacyPolicySeeder::class);

        if (App::environment(['local']) ||  App::environment(['staging'])) {
            $this->call(FeedbackSeeder::class);
        }
    }
}
