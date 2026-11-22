<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    foreach ([
        'products' => 'Produk',
        'categories' => 'Kategori',
        'brands' => 'Brand',
        'orders' => 'Pesanan',
        'rfqs' => 'RFQ',
        'quotations' => 'Quotation',
        'upo' => 'UPO',
        'reviews' => 'Reviews',
        'blog' => 'Blog',
        'faq' => 'FAQ',
        'pages' => 'Halaman',
        'simulation' => 'Simulasi',
        'settings' => 'Settings',
    ] as $slug => $title) {
        Route::inertia($slug, 'admin/placeholder', ['title' => $title])->name($slug.'.index');
    }
});

require __DIR__.'/settings.php';
