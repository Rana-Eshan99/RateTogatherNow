<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\PrivacyPolicyInterface;
use App\Repositories\Interfaces\TermsConditionInterface;
use App\Repositories\Interfaces\User\Auth\AuthInterface;
use App\Repositories\Interfaces\User\Home\HomeInterface;
use App\Repositories\Interfaces\User\Peer\PeerInterface;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Repositories\Interfaces\User\State\StateInterface;
use App\Repositories\Repositories\PrivacyPolicyRepository;
use App\Repositories\Repositories\TermsConditionRepository;
use App\Repositories\Repositories\User\Auth\AuthRepository;
use App\Repositories\Repositories\User\Home\HomeRepository;
use App\Repositories\Repositories\User\Peer\PeerRepository;
use App\Repositories\Repositories\Admin\User\UserRepository;
use App\Repositories\Repositories\User\State\StateRepository;
use App\Repositories\Interfaces\Admin\Peer\AdminPeerInterface;
use App\Repositories\Interfaces\Admin\User\AdminUserInterface;
use App\Repositories\Interfaces\User\Country\CountryInterface;
use App\Repositories\Interfaces\User\Helpful\HelpfulInterface;
use App\Repositories\Interfaces\Admin\Feedback\FeedbackInterface;
use App\Repositories\Repositories\Admin\Peer\AdminPeerRepository;
use App\Repositories\Repositories\User\Country\CountryRepository;
use App\Repositories\Repositories\User\Helpful\HelpfulRepository;
use App\Repositories\Interfaces\Admin\Dashboard\DashboardInterface;
use App\Repositories\Interfaces\User\Department\DepartmentInterface;
use App\Repositories\Repositories\Admin\Feedback\FeedbackRepository;
use App\Repositories\Interfaces\Admin\PeerRating\PeerRatingInterface;
use App\Repositories\Interfaces\User\AppFeedback\AppFeedbackInterface;
use App\Repositories\Repositories\Admin\Dashboard\DashboardRepository;
use App\Repositories\Repositories\User\Department\DepartmentRepository;
use App\Repositories\Interfaces\User\Organization\OrganizationInterface;
use App\Repositories\Interfaces\User\ReportRating\ReportRatingInterface;
use App\Repositories\Repositories\Admin\PeerRating\PeerRatingRepository;
use App\Repositories\Repositories\User\AppFeedback\AppFeedbackRepository;
use App\Repositories\Repositories\User\Organization\OrganizationRepository;
use App\Repositories\Repositories\User\ReportRating\ReportRatingRepository;
use App\Repositories\Interfaces\User\ProfileSetting\ProfileSettingInterface;
use App\Repositories\Interfaces\Admin\ReportComments\ReportCommentsInterface;
use App\Repositories\Interfaces\Admin\Organization\AdminOrganizationInterface;
use App\Repositories\Repositories\User\ProfileSetting\ProfileSettingRepository;
use App\Repositories\Repositories\Admin\ReportComments\ReportCommentsRepository;
use App\Repositories\Repositories\Admin\Organization\AdminOrganizationRepository;
use App\Repositories\Interfaces\Admin\OrganizationRating\OrganizationRatingInterface;
use App\Repositories\Repositories\Admin\OrganizationRating\OrganizationRatingRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(DepartmentInterface::class, DepartmentRepository::class);
        $this->app->bind(OrganizationInterface::class, OrganizationRepository::class);
        $this->app->bind(HomeInterface::class, HomeRepository::class);
        $this->app->bind(ProfileSettingInterface::class, ProfileSettingRepository::class);
        $this->app->bind(CountryInterface::class, CountryRepository::class);
        $this->app->bind(StateInterface::class, StateRepository::class);

        // Binds the PeerInterface with PeerRepository
        $this->app->bind(PeerInterface::class, PeerRepository::class);

        // Binds the ReportRatingInterface with ReportRatingRepository
        $this->app->bind(ReportRatingInterface::class, ReportRatingRepository::class);

        // Binds the HelpfulInterface with HelpfulRepository
        $this->app->bind(HelpfulInterface::class, HelpfulRepository::class);
        $this->app->bind(AppFeedbackInterface::class, AppFeedbackRepository::class);
        //Admin Panel pattren binding
        $this->app->bind(ReportCommentsInterface::class, ReportCommentsRepository::class);
        $this->app->bind(FeedbackInterface::class, FeedbackRepository::class);

        $this->app->bind(OrganizationRatingInterface::class, OrganizationRatingRepository::class);
        $this->app->bind(PeerRatingInterface::class, PeerRatingRepository::class);
        $this->app->bind(DashboardInterface::class, DashboardRepository::class);
        $this->app->bind(AdminOrganizationInterface::class, AdminOrganizationRepository::class);
        $this->app->bind(AdminPeerInterface::class, AdminPeerRepository::class);

        $this->app->bind(TermsConditionInterface::class, TermsConditionRepository::class);
        $this->app->bind(PrivacyPolicyInterface::class, PrivacyPolicyRepository::class);

        $this->app->bind(AdminUserInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
