<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LandingSettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get("/", [LandingPageController::class, "index"])->name("home");
Route::get("/cek-status", [LandingPageController::class, "cekStatus"])->name("cek.status");

/*
|--------------------------------------------------------------------------
| Admin Routes (auth required)
|--------------------------------------------------------------------------
*/
Route::middleware(["auth", "verified"])->group(function () {
    // Dashboard - all roles can access
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

    // Role-based route groups
    Route::middleware("role:admin,kasir")->group(function () {
        Route::resource("customers", CustomerController::class);
        Route::resource("orders", OrderController::class);
        Route::get("/orders/trash", [OrderController::class, "trash"])->name("orders.trash");
        Route::patch("/orders/{id}/restore", [OrderController::class, "restore"])->name("orders.restore");
        Route::get("/orders/{order}/payment", [OrderController::class, "payment"])->name("orders.payment");
        Route::get("/orders/{order}/invoice", [OrderController::class, "invoice"])->name("orders.invoice");

        Route::post("/payments", [PaymentController::class, "store"])->name("payments.store");
        Route::patch("/payments/{payment}", [PaymentController::class, "update"])->name("payments.update");
        Route::delete("/payments/{payment}", [PaymentController::class, "destroy"])->name("payments.destroy");
    });

    // Reports - admin & owner
    Route::middleware("role:admin,owner")->group(function () {
        Route::get("/reports", [ReportController::class, "index"])->name("reports");
        Route::get("/reports/export", [ReportController::class, "export"])->name("reports.export");
Route::get("/reports/profit-loss", [ReportController::class, "profitLoss"])->name("reports.profit-loss");

        // Activity Logs - admin & owner only
        Route::get("/activity-logs", [ActivityLogController::class, "index"])->name("activity-logs.index");
    });

    // Services - admin only
    Route::middleware("role:admin")->group(function () {
        Route::resource("services", ServiceController::class);
    Route::resource("expenses", ExpenseController::class);
    Route::resource("packages", PackageController::class);
    Route::get("/orders/{order}/label", [OrderController::class, "label"])->name("orders.label");
    });

    Route::get("/profile", [ProfileController::class, "edit"])->name("profile.edit");
    Route::patch("/profile", [ProfileController::class, "update"])->name("profile.update");
    Route::delete("/profile", [ProfileController::class, "destroy"])->name("profile.destroy");

    // Landing page admin - admin only
    Route::middleware("role:admin")->prefix("admin")->name("admin.")->group(function () {
        Route::get("/landing-settings", [LandingSettingController::class, "index"])
            ->name("landing-settings.index");
        Route::post("/landing-settings", [LandingSettingController::class, "update"])
            ->name("landing-settings.update");

        Route::resource("testimonials", TestimonialController::class);
        Route::resource("galleries", GalleryController::class);
    });
});

require __DIR__ . "/auth.php";
