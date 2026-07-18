<?php

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
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

    Route::resource("customers", CustomerController::class);
    Route::resource("services", ServiceController::class);

    Route::get("/orders/trash", [OrderController::class, "trash"])->name("orders.trash");
    Route::patch("/orders/{id}/restore", [OrderController::class, "restore"])->name("orders.restore");
    Route::get("/orders/{order}/payment", [OrderController::class, "payment"])->name("orders.payment");
    Route::get("/orders/{order}/invoice", [OrderController::class, "invoice"])->name("orders.invoice");
    Route::resource("orders", OrderController::class);

    Route::post("/payments", [PaymentController::class, "store"])->name("payments.store");
    Route::patch("/payments/{payment}", [PaymentController::class, "update"])->name("payments.update");
    Route::delete("/payments/{payment}", [PaymentController::class, "destroy"])->name("payments.destroy");

    Route::get("/reports", [ReportController::class, "index"])->name("reports");
    Route::get("/reports/export", [ReportController::class, "export"])->name("reports.export");

    Route::get("/profile", [ProfileController::class, "edit"])->name("profile.edit");
    Route::patch("/profile", [ProfileController::class, "update"])->name("profile.update");
    Route::delete("/profile", [ProfileController::class, "destroy"])->name("profile.destroy");

    // Landing page admin
    Route::prefix("admin")->name("admin.")->group(function () {
        Route::get("/landing-settings", [LandingSettingController::class, "index"])
            ->name("landing-settings.index");
        Route::post("/landing-settings", [LandingSettingController::class, "update"])
            ->name("landing-settings.update");

        Route::resource("testimonials", TestimonialController::class);
        Route::resource("galleries", GalleryController::class);
    });
});

require __DIR__ . "/auth.php";
