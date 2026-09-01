<?php

use App\Livewire\Admin\DashboardComponent;
use App\Livewire\Admin\LoginComponent;
use App\Livewire\Admin\OrderList;
use App\Livewire\Admin\ProductList;
use App\Livewire\Public\MenuComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public Customer Facing Routes
Route::get('/', MenuComponent::class)->name('home');
Route::get('/menu', MenuComponent::class)->name('public.menu');

// Admin Guest / Auth Routes
Route::get('/admin/login', LoginComponent::class)->name('login')->middleware('guest');

Route::post('/admin/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('admin.logout')->middleware('auth');

// Protected Admin Panel Routes (General Admin & Local Branch Managers)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', DashboardComponent::class)->name('admin.dashboard');
    Route::get('/operaciones', \App\Livewire\Admin\OperationsComponent::class)->name('admin.operations');
    Route::get('/productos', ProductList::class)->name('admin.products');
    Route::get('/ordenes', OrderList::class)->name('admin.orders');
});

