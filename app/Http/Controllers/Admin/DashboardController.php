<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Rfq;
use App\Models\Order;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController
{
    public function index(): Response
    {
        return Inertia::render('admin/dashboard', [
            'stats' => [
                'products' => Product::count(),
                'orders' => Order::count(),
                'rfqs' => Rfq::where('status', 'new')->count(),
            ],
        ]);
    }
}