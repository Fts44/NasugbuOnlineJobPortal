<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailerController as Mailer;
use App\Http\Controllers\OTPController as OTP;

// start authentication route
    use App\Http\Controllers\Authentication\RegisterController as Register;
    use App\Http\Controllers\Authentication\RecoverController as Recover;
    use App\Http\Controllers\Authentication\LoginController as Login;

    Route::prefix('/')->group(function(){
        Route::get('', [Login::class, 'index'])->name('LoginView');
        Route::post('login', [Login::class, 'login'])->name('Login');
        Route::get('logout', [Login::class, 'logout'])->name('Logout');

        Route::get('recover', [Recover::class, 'index'])->name('RecoverView');
        Route::post('recover', [Recover::class, 'recover'])->name('Recover');
        Route::post('recover/otp', [OTP::class, 'compose_mail'])->name('RecoverSendOTP');

        Route::get('register', [Register::class, 'index'])->name('RegisterView');
        Route::post('register', [Register::class, 'register'])->name('Register');
        Route::post('register/otp', [OTP::class, 'compose_mail'])->name('RegisterSendOTP');
    });
// end authentication route


// start applicant 
    use App\Http\Controllers\Applicant\ProfileController as ProfileApplicant;
    use App\Http\Controllers\Applicant\UpgradeController as UpgradeApplicant;
    use App\Http\Controllers\Applicant\JobPostController as JobPostApplicant;
    use App\Http\Controllers\Applicant\ApplicationController as JobPostApplication;

    Route::prefix('applicant')->middleware('JACounter')->group(function(){
        Route::get('profile', [ProfileApplicant::class, 'index'])->name('ApplicantProfile');
        Route::put('profile/update', [ProfileApplicant::class, 'update'])->name('ApplicantProfileUpdate');

        Route::get('upgrade', [UpgradeApplicant::class, 'index'])->name('ApplicantUpgrade');
        Route::put('upgrade/send', [UpgradeApplicant::class, 'send'])->name('ApplicantUpgradeSend');
        
        Route::get('jobpost', [JobPostApplicant::class, 'index'])->name('JobPostApplicant');
        Route::put('jobpost/apply', [JobPostApplicant::class, 'apply'])->name('JobPostApplicantApply');
        Route::get('jobpost/cancel/{id}', [JobPostApplicant::class, 'cancel'])->name('JobPostApplicantCancel');

        Route::get('application', [JobPostApplication::class, 'index'])->name('JobPostApplication');
    });
// end applicant

// start employer
    use App\Http\Controllers\Employer\ProfileController as ProfileEmployer;
    use App\Http\Controllers\Employer\UpgradeController as UpgradeEmployer;
    use App\Http\Controllers\Employer\JobPosting\YourPostController as JPYPEmployer;
    use App\Http\Controllers\Employer\JobPosting\AllPostController as JPAPEmployer;
    use App\Http\Controllers\Employer\ApplicationController as JobPostApplicationEmployer;
    Route::prefix('employer')->middleware('JCCounter')->group(function(){
        Route::get('profile', [ProfileEmployer::class, 'index'])->name('EmployerProfile');
        Route::put('profile/update', [ProfileEmployer::class, 'update'])->name('EmployerProfileUpdate');

        Route::get('upgrade', [UpgradeEmployer::class, 'index'])->name('EmployerUpgrade');
        Route::put('upgrade/send', [UpgradeEmployer::class, 'send'])->name('EmployerUpgradeSend');
        Route::get('upgrade/cancel/{id}', [UpgradeEmployer::class, 'cancel'])->name('EmployerUpgradeCancel');
        
        Route::get('yourposting', [JPYPEmployer::class, 'index'])->name('EmployerYourJobPosting');
        Route::put('yourposting/insert', [JPYPEmployer::class, 'insert'])->name('EmployerYourJobPostingInsert');
        Route::get('yourposting/retrieve/{id}', [JPYPEmployer::class, 'retrieve'])->name('EmployerYourJobPostingRetrieve');
        Route::put('yourposting/update/{id}', [JPYPEmployer::class, 'update'])->name('EmployerYourJobPostingUpdate');
        Route::get('yourposting/delete/{id}', [JPYPEmployer::class, 'delete'])->name('EmployerYourJobPostingDelete');

        Route::get('allposting', [JPAPEmployer::class, 'index'])->name('EmployerAllJobPosting');

        Route::get('application', [JobPostApplicationEmployer::class, 'index'])->name('JobPostApplicationEmployer');
        Route::get('application/details/{id}', [JobPostApplicationEmployer::class, 'get_details'])->name('JobPostApplicationEmployerDetails');
        Route::put('application/respond', [JobPostApplicationEmployer::class, 'respond'])->name('JobPostApplicationEmployerRespond');
    });
// end employer

// start admin
    use App\Http\Controllers\Admin\Upgrade\RequestController as UpgradeRequest;
    use App\Http\Controllers\Admin\Upgrade\ValidatedController as UpgradeValidated;

    use App\Http\Controllers\Admin\Accounts\BanController as AcccountsBan;
    use App\Http\Controllers\Admin\Accounts\EmployerCotnroller as AccountsEmployer;
    use App\Http\Controllers\Admin\Accounts\ApplicantController as AccountsApplicant;
    use App\Http\Controllers\Admin\JobPostController as JobPostAdmin;
    use App\Http\Controllers\Admin\Configuration\JobCategoryController as ConfigJobCategory;
    use App\Http\Controllers\Admin\DashboardController as Dashboard;
   
    Route::prefix('admin')->group(function(){
        Route::get('dashboard', [Dashboard::class, 'index'])->name('DashboardAdmin');

        Route::get('jobpost', [JobPostAdmin::class, 'index'])->name('JobPostAdmin');

        Route::prefix('upgrade')->group(function(){
            
            Route::get('request', [UpgradeRequest::class, 'index'])->name('UpgradeRequest');
            Route::put('request/respond/{id}', [UpgradeRequest::class, 'respond'])->name('UpgradeRequestRespond');
            
            Route::get('validated', [UpgradeValidated::class, 'index'])->name('UpgradeValidated');
            Route::get('validated/cancel/{id}', [UpgradeValidated::class, 'cancel'])->name('UpgradeValidatedCancel');
        });

        Route::prefix('accounts')->group(function(){
            Route::put('ban/{id}', [AcccountsBan::class, 'ban'])->name('BanAccounts');
            Route::put('unban/{id}', [AcccountsBan::class, 'unban'])->name('UnbanAccounts');

            Route::get('', [AccountsEmployer::class, 'index'])->name('AdminAccounts');
            Route::get('employer/{id}', [AccountsEmployer::class, 'employer'])->name('AdminAccountsEmployer');
        
            Route::get('applicant', [AccountsApplicant::class, 'index'])->name('AccountsApplicant');
            Route::get('applicant/{id}', [AccountsApplicant::class, 'applicant'])->name('AdminAccountsApplicant');
        });
        
        Route::prefix('config')->group(function(){

            Route::prefix('jobtitle')->group(function(){
                Route::get('', [ConfigJobCategory::class, 'index'])->name('AdminConfigurationJC');
                Route::put('insert', [ConfigJobCategory::class, 'insert'])->name('AdminConfigurationJCInsert');
                Route::put('update/{id}', [ConfigJobCategory::class, 'update'])->name('AdminConfigurationJCUpdate');
                Route::get('delete/{id}', [ConfigJobCategory::class, 'delete'])->name('AdminConfigurationJCDelete');
            });
            
        });

    });
// end admin

use App\Http\Controllers\PopulateSelectController as PSC;
use App\Http\Controllers\PrintController as FormPrint;

Route::prefix('populate')->group(function(){
    Route::get('municipality/{prov_code}', [PSC::class, 'get_municipality'])->name('GetMunicipality');
    Route::get('barangay/{mun_code}', [PSC::class, 'get_barangay'])->name('GetBarangay');
});


use App\Http\Controllers\ViewUploadsController as ViewUploads;

Route::get('view/{id}', [ViewUploads::class, 'view'])->name('ViewDocument');
Route::get('viewresume/{id}', [ViewUploads::class, 'view_resume'])->name('ViewResume');

Route::get('view/interview/{id}', [FormPrint::class, 'print_interview'])->name('InterviewPrint');
Route::get('view/result/{id}', [FormPrint::class, 'print_result'])->name('ResultPrint');