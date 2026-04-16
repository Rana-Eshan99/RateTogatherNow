<?php

namespace Database\Seeders;

use App\Models\PrivacyPolicy;
use Illuminate\Database\Seeder;
use App\Traits\CheckExistingEntriesTrait;

class PrivacyPolicySeeder extends Seeder
{
    use CheckExistingEntriesTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->entriesExist(PrivacyPolicy::class)) {
            return;
        }

        PrivacyPolicy::insert([
            'title' => 'Privacy Policy',
            'description' => '<p style="font-size: 14.4px; background-color: rgb(252, 252, 252);"><span style="font-weight: bolder; font-size: 14.4px;">Privacy Policy</span></p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);">By accessing the Confessional Prayer Bible (RateMyPeers) you agree to this Privacy Policy and its terms, and consent to having your data transferred to and processed in the United States. Your use of&nbsp; RateMyPeers is also governed by our Terms of Use. Please read those terms carefully as well. Here’s a summary of what you can expect to find in our Privacy Policy, which covers all RateMyPeers-branded products and services:&nbsp;<br></p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);"><br></p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);"><span style="font-weight: bolder;">How we use your data to make your RateMyPeers experience more personal.&nbsp;</span></p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);">This Privacy Policy outlines the types of data we collect from your interaction with&nbsp; RateMyPeers, as well as how we process that information to enhance your&nbsp; RateMyPeers experience. When you create a&nbsp; RateMyPeers account or use any one of our applications or sites, the information we collect is for the purpose of offering a more personalized experience.<br></p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);"><br></p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);"><span style="font-weight: bolder;">Your privacy protected.</span></p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);">We take the privacy of the information you provide and that we collect seriously and we implement security safeguards designed to protect your data as discussed below. We do not share your personally identifiable data with any third-party advertisers or ad networks for third-party advertising purposes.<br></p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);"><span style="font-weight: bolder; font-size: 0.9rem;"><br></span></p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);"><span style="font-weight: bolder; font-size: 0.9rem;">It’s your experience.</span><br></p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);">You have choices about how your personal information is accessed, collected, shared, and stored by Rabboni Books, which are discussed below. You will make choices about our use and processing of your information when you first engage&nbsp; RateMyPeers and when you engage certain&nbsp; RateMyPeers functionality and may also make certain choices in the settings menu of your&nbsp; RateMyPeers Member account.&nbsp;</p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);"><br></p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);"><span style="font-weight: bolder;">We welcome your questions and comments.</span></p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);">We welcome any questions or comments you may have about this Privacy Policy and our privacy practices. If you have any questions or comments, you may contact us by mail at Rabboni Books, Attn.:&nbsp; RateMyPeers Support, 1700 Broadway Ave. N, Suite #150, Rochester MN 55906, or by email at tell@acts1038.com.</p><p style="font-size: 14.4px; background-color: rgb(252, 252, 252);">Where&nbsp; RateMyPeers has provided you with a translation other than the English language version of the Privacy Policy, then you agree that the translation is provided for your convenience only and that the English language version of the Privacy Policy will govern your relationship with&nbsp; RateMyPeers. If there is any contradiction between what the English language version of the Privacy Policy says and what a translation says, then the English language version shall take precedence.&nbsp;</p>',
            'createdAt' => '12122112',
            'updatedAt' => '12122112',
        ]);
    }
}
