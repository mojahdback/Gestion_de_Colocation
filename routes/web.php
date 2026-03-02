<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\CategoryController;


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


Route::get('/', fn() => redirect()->route('colocations.index'));



Route::middleware(['auth', 'check.banned'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/admin/dashboard' , function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');

      // Dashboard / Home
    Route::get('/dashboard', [ColocationController::class, 'index'])->name('dashboard');

    // ─── Colocations ─────────────────────────────────────────────────────────
    Route::resource('colocations', ColocationController::class)
         ->except(['destroy']);

    Route::post('colocations/{colocation}/cancel', [ColocationController::class, 'cancel'])
         ->name('colocations.cancel');

    Route::post('colocations/{colocation}/leave', [ColocationController::class, 'leave'])
         ->name('colocations.leave');

      // send invitation
    Route::post('/colocations/{colocation}/invite', [InvitationController::class, 'store'])
        ->name('invitations.store');

    // view invitation
    Route::get('/invitations/{token}', [InvitationController::class, 'show'])
        ->name('invitations.show');

    // accept
    Route::post('/invitations/{token}/accept', [InvitationController::class, 'accept'])
        ->name('invitations.accept');

    // refuse
    Route::post('/invitations/{token}/refuse', [InvitationController::class, 'refuse'])
        ->name('invitations.refuse');

    Route::get('/colocations/{colocation}/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::post('/colocations/{colocation}/categories', [CategoryController::class, 'store'])
        ->name('categories.store');

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy');



});



require __DIR__.'/auth.php';
