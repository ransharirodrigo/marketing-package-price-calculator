<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Models\Business;
use App\Models\Inventory;
use App\Models\InventoryModal;
use App\Models\Metrics;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $business = Business::get();
    $inventory = Inventory::get();
    $metrics=Metrics::get();

    return view('index', compact('business', 'inventory','metrics'));
});

Route::get("/login", [LoginController::class, "index"])->name("login");
Route::post("/login", [LoginController::class, "adminLogin"])->name("admin.login");
Route::get('/home', [HomeController::class, 'index'])->name('admin.dashboard');

Route::post("save-new-business", [BusinessController::class, "store"])->name("business.save");
Route::get("business-list", [BusinessController::class, "show"])->name("business.list");

Route::get("business-related-inventory",[InventoryController::class,"getRelatedInventoryForBusiness"])->name("business.inventory");

Route::post("save-new-price-metrics",[PriceController::class,"saveMetricsPrice"])->name("metrics.price.save");
Route::get("price-list", [PriceController::class, "show"])->name("price.list");
Route::get('business-inventory-metric-prices/{id}/edit', [PriceController::class, 'edit']);
Route::post('business-inventory-metric-prices-update', [PriceController::class, 'update']);
Route::get('businesses/{id}/edit', [BusinessController::class, 'edit']);
Route::put('businesses/{id}', [BusinessController::class, 'update']);

Route::post('calculate-price', [PriceController::class, 'calculatePrice']);

Route::post("/generate-pdf",[PriceController::class,"generatePdf"])->name('generate.pdf');
Route::post("/preview-pdf",[PriceController::class,"previewPdf"])->name('preview.pdf');

Route::get("orders",[OrderController::class,"index"])->name("order.index");
Route::get("orders-list",[OrderController::class,"show"])->name("order.list");
Route::get('view-invoice-items/{invoiceNumber}', [OrderController::class, 'viewInvoiceItems'])->name('invoice.items.view');

Route::get('get-sort-values', [OrderController::class,"getSortValue"])->name('get.sort.values');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::delete('businesses/{business}/delete', [BusinessController::class, 'destroy'])->name('businesses.destroy');

Route::get("inventory-list", [InventoryController::class, "show"])->name("inventory.list");
Route::post("save-new-inventory", [InventoryController::class, "store"])->name("inventory.save");
Route::get('inventories/{id}/edit', [InventoryController::class, 'edit']);
Route::put('inventories/{id}', [InventoryController::class, 'update']);
Route::delete('inventories/{inventory}/delete', [InventoryController::class, 'destroy'])->name('inventories.destroy');
// Route::get('get-inventories-by-business/{business_id}', [InventoryController::class, 'getInventoriesByBusiness'])->name('get.inventories.by.business');

Route::get("settings",[SettingsController::class,"index"])->name("settings.index");
Route::post('notes', [SettingsController::class,'notesStore'])->name('settings.notes.store');

Route::get('/business/{businessId}/inventory/{inventoryId}/price', [PriceController::class, 'getPriceForSelectedInventory']);