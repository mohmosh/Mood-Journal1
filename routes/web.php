<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\MoodJournalController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard should redirect to mood journals
    Route::get('/dashboard', function () {
        return redirect()->route('mood-journals.index');
    })->name('dashboard');

    // Mood Journals CRUD
    Route::resource('mood-journals', MoodJournalController::class);

    Route::get('mood-journals/{moodJournal}', [MoodJournalController::class, 'show'])->name('mood-journals.show');
});;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->get('/donate', [DonationController::class, 'redirectToIntaSend'])->name('donate');
Route::post('/webhook/donation', [DonationController::class, 'webhook'])->name('webhook.donation');

Route::middleware('auth')->post('/donate/stk', [DonationController::class, 'stkPush'])->name('donate.stk');
Route::post('/webhook/donation', [DonationController::class, 'webhook'])->name('webhook.donation');





require __DIR__ . '/auth.php';
