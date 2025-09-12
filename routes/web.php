<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Home::class)->name('home');

// Route::get('/dashboard', \App\Livewire\Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function (): void {

    // Impersonations
    Route::post('/impersonate/{user}', [\App\Http\Controllers\ImpersonationController::class, 'store'])->name('impersonate.store')->middleware('can:impersonate');
    Route::delete('/impersonate/stop', [\App\Http\Controllers\ImpersonationController::class, 'destroy'])->name('impersonate.destroy');

    // Settings
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', \App\Livewire\Settings\Profile::class)->name('settings.profile');
    Route::get('settings/password', \App\Livewire\Settings\Password::class)->name('settings.password');
    Route::get('settings/appearance', \App\Livewire\Settings\Appearance::class)->name('settings.appearance');
    Route::get('settings/locale', \App\Livewire\Settings\Locale::class)->name('settings.locale');

    // Admin
    Route::prefix('admin')->as('admin.')->group(function (): void {
        Route::get('/', \App\Livewire\Admin\Index::class)->middleware(['auth', 'verified'])->name('index')->middleware('can:access dashboard admin');
        Route::get('/users', \App\Livewire\Admin\Users::class)->name('users.index')->middleware('can:view users');
        Route::get('/users/create', \App\Livewire\Admin\Users\CreateUser::class)->name('users.create')->middleware('can:create users');
        Route::get('/users/{user}', \App\Livewire\Admin\Users\ViewUser::class)->name('users.show')->middleware('can:view users');
        Route::get('/users/{user}/edit', \App\Livewire\Admin\Users\EditUser::class)->name('users.edit')->middleware('can:update users');
        Route::get('/roles', \App\Livewire\Admin\Roles::class)->name('roles.index')->middleware('can:view roles');
        Route::get('/roles/create', \App\Livewire\Admin\Roles\CreateRole::class)->name('roles.create')->middleware('can:create roles');
        Route::get('/roles/{role}/edit', \App\Livewire\Admin\Roles\EditRole::class)->name('roles.edit')->middleware('can:update roles');
        Route::get('/permissions', \App\Livewire\Admin\Permissions::class)->name('permissions.index')->middleware('can:view permissions');
        Route::get('/permissions/create', \App\Livewire\Admin\Permissions\CreatePermission::class)->name('permissions.create')->middleware('can:create permissions');
        Route::get('/permissions/{permission}/edit', \App\Livewire\Admin\Permissions\EditPermission::class)->name('permissions.edit')->middleware('can:update permissions');
    });

    // Manager routes
    Route::prefix('manager')->as('manager.')->middleware(['auth', 'verified', 'can:access dashboard manager'])->group(function (): void {
        Route::get('/', \App\Livewire\Manager\Index::class)->name('index');
        Route::get('/products', \App\Livewire\Manager\Products::class)->name('products.index')->middleware('can:view products');
        Route::get('/products/create', \App\Livewire\Manager\Products\CreateProduct::class)->name('products.create')->middleware('can:create products');
        Route::get('/products/{product}/edit', \App\Livewire\Manager\Products\EditProduct::class)->name('products.edit')->middleware('can:update products');
        Route::get('/discounts', \App\Livewire\Manager\Discounts::class)->name('discounts.index')->middleware('can:view discounts');
        Route::get('/discounts/create', \App\Livewire\Manager\Discounts\CreateDiscount::class)->name('discounts.create')->middleware('can:create discounts');
        Route::get('/discounts/{discount}/edit', \App\Livewire\Manager\Discounts\EditDiscount::class)->name('discounts.edit')->middleware('can:update discounts');
        Route::get('/transactions', \App\Livewire\Manager\Transactions::class)->name('transactions.index')->middleware('can:view transactions');
    });
    
    // Cashier routes
    Route::prefix('cashier')->as('cashier.')->middleware(['auth', 'verified'])->group(function (): void {
        Route::get('/pos', \App\Livewire\Cashier\Pos::class)->name('pos')->middleware('can:view products');
        Route::get('/transactions', \App\Livewire\Cashier\Transactions::class)->name('transactions.index')->middleware('can:view transactions');
        Route::get('/transactions/{transaction}/receipt', \App\Livewire\Cashier\Receipt::class)->name('transactions.receipt')->middleware('can:print receipt');
    });

});

// Public Self-Order routes (no login, pay at counter)
Route::get('/order', \App\Livewire\SelfOrder\Order::class)->name('selforder.order');
Route::get('/order/placed/{transaction}', \App\Livewire\SelfOrder\Placed::class)->name('selforder.placed');

require __DIR__.'/auth.php';