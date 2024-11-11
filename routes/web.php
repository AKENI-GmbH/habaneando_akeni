<?php

use App\Livewire\Frontend\Checkout\CheckoutSuccess;
use App\Livewire\Frontend\Checkout\CourseCheckout;
use App\Livewire\Frontend\Checkout\CheckoutCancel;
use App\Livewire\Frontend\Auth\CustomerDashboard;
use App\Livewire\Frontend\Auth\CustomerRegister;
use App\Livewire\Frontend\Auth\CustomerLogin;
use App\Http\Controllers\CouponController;
use App\Livewire\Customer\ForgotPassword;
use App\Livewire\Customer\ResetPassword;
use App\Livewire\DefaultPage;
use App\Livewire\Frontend\Club\MembershipCreate;
use App\Livewire\Frontend\Course\CategoryShow;
use App\Livewire\Frontend\Course\CoursesShow;
use App\Livewire\Frontend\Event\EventList;
use App\Livewire\Frontend\Event\EventSingle;
use App\Livewire\Frontend\HomeFrontPage;
use App\Livewire\Frontend\Page\CouponPage;
use App\Livewire\Frontend\Page\PricePage;
use App\Livewire\Frontend\Page\PrivateLessonPage;
use App\Livewire\Frontend\Page\TeamPage;
use App\Livewire\Frontend\Workshop\WorkshopList;
use App\Livewire\Page\CouponSingle;
use App\Livewire\Page\Courseinfo;
use App\Mail\EventPurchaseConfirmationEmail;
use App\Mail\PurchaseConfirmationEmail;
use App\Mail\TestEmail;
use App\Mail\WelcomeEmail;
use App\Models\CourseSubscription;
use App\Models\Customer;
use App\Models\EventSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/send-event-confirmation-email', function () {

//     $customer = Customer::find(1180);

//     $subscription = EventSubscription::first();

//     Mail::to('randy.duran@insimia.com')->send(new EventPurchaseConfirmationEmail( $subscription));

//     return 'Kaufbestätigungs-E-Mail erfolgreich gesendet!';
// });

// Route::get('/send-purchase-confirmation-email', function () {

//     $customer = Customer::find(1180);

//     $subscription = CourseSubscription::first();

//     Mail::to('randy.duran@insimia.com')->send(new PurchaseConfirmationEmail( $subscription));

//     return 'Kaufbestätigungs-E-Mail erfolgreich gesendet!';
// });

Route::get('/send-welcome-email', function () {
    $userName = "Max Mustermann";

    Mail::to('randy.duran@insimia.com')->send(new WelcomeEmail($userName)); // Replace with the actual recipient email address

    return 'Willkommens-E-Mail erfolgreich gesendet!';
});

// Route::get('/send-test-email', function () {
//     $userName = "John Doe"; // Dynamic user name
//     $body = "Thank you for your purchase! We appreciate your business and hope you enjoy your purchase.";
//     $closingMessage = "Best regards,\n\nSalsa Tanzschule Habaneando";

//     Mail::to('randy.duran@insimia.com')->send(new TestEmail($userName, $body, $closingMessage));

//     return 'Email sent successfully!';
// });


Route::get('/', HomeFrontPage::class)->name('frontend.home');
Route::get('/team', TeamPage::class)->name('frontend.team');
Route::get('/preise', PricePage::class)->name('frontend.preise');
Route::get('/gutsheine', CouponPage::class)->name('frontend.coupon');
Route::get('/gutsheine/{slug}', CouponSingle::class)->name('frontend.coupon.show');
Route::get('/privatunterricht', PrivateLessonPage::class)->name('frontend.private.lessons');
Route::get('salsa-tanzschule/{slug}', DefaultPage::class)->name('frontend.page');

Route::get('/forgot-password', ForgotPassword::class)->middleware('guest')->name('password.request');
Route::get('/reset-password/{token}', ResetPassword::class)->middleware('guest')->name('password.reset');


Route::get('/coupon/preview', [CouponController::class, 'preview'])->name('coupon.preview');

Route::get('/kurse/kursuebersicht', Courseinfo::class)->name('frontend.course.info');
Route::get('/kurse/{course}', CoursesShow::class)->name('frontend.course.show');
Route::get('/tanzen/{courseCategory}', CategoryShow::class)->name('frontend.course.category');
Route::get('/mitgliedschaft', MembershipCreate::class)->name('frontend.memebrship.create');

Route::get('/workshop', WorkshopList::class)->name('frontend.workshops.list');

Route::group(['prefix' => '/events'], function () {
    Route::get('/', EventList::class)->name('frontend.event.list');
    Route::get('/{event}', EventSingle::class)->name('frontend.event.single');
});

Route::group(['prefix' => '/checkout'], function () {
    // Route::get('/course/success/{session_id}', CheckoutSuccess::class)->name('frontend.course.checkout');
    Route::get('/course/success/{session_id}', CourseCheckout::class)->name('frontend.checkout.success');
    // Route::get('/success', CheckoutSuccess::class)->name('frontend.checkout.success');
    Route::get('/event/success/{session_id}', CheckoutSuccess::class)->name('frontend.checkout.event.success');
});


Route::middleware(['guest:customer'])->group(function () {
    Route::get('/login', CustomerLogin::class)->name('frontend.login');
    Route::get('/register', CustomerRegister::class)->name('frontend.register');
});

Route::middleware('customer.auth')->group(function () {
    Route::get('/konto', CustomerDashboard::class)->name('frontend.konto');
    Route::get('/profile', CustomerDashboard::class)->name('frontend.profile');
    Route::post('/logout', function () {
        Auth::guard('customer')->logout();
        return redirect()->route('frontend.home');
    })->name('frontend.logout')->middleware('customer.auth');
});
