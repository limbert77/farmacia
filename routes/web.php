<?php

use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckIfAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\ventaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\HomeController;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/inicio', [HomeController::class, 'index'])->name('inicio.index');
Route::get('/register', [UsuarioController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UsuarioController::class, 'register']);
Route::get('/proveedoresEdit', [ProveedoresController::class, 'update'])->name('proveedores.edit');
Route::get('/venta', [ventaController::class, 'index'])->name('ventas');
Route::get('/medicamentos', [MedicamentoController::class, 'index'])->name('medicamento.index');

Route::middleware(['auth', CheckAdmin::class])->group(function () {
    Route::get('/proveedores', [ProveedoresController::class, 'index'])->name('proveedores.index');
    Route::get('/compras', [CompraController::class, 'index'])->name('compra.index');
});

Route::middleware(['auth', CheckIfAdmin::class])->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuario.index');
    Route::get('/reportes/ventas', [ReportesController::class, 'ventas'])->name('reportes.ventas');
    Route::get('/reportes/compras', [ReportesController::class, 'compras'])->name('reportes.compras');
    Route::get('/reportes/inventario', [ReportesController::class, 'inventario'])->name('reportes.inventario');
    Route::get('/reportes/proveedores', [ReportesController::class, 'proveedores'])->name('reportes.proveedores');
    Route::get('/reportes/usuarios', [ReportesController::class, 'usuarios'])->name('reportes.usuarios');
    Route::get('/reportes/clientes', [ReportesController::class, 'clientes'])->name('reportes.clientes');
    Route::get('/reportes/ventas/excel', [ReportesController::class, 'exportExcel'])->name('reportes.ventas.excel');
    Route::get('/reportes/ventas/pdf', [ReportesController::class, 'exportPDF'])->name('reportes.ventas.pdf');
    Route::get('/reportes/inventario/pdf', [ReportesController::class, 'exportInventarioPDF'])->name('reportes.inventario.pdf');
    Route::get('/reportes/proveedores/pdf', [ReportesController::class, 'exportProveedoresPDF'])->name('reportes.proveedores.pdf');
    Route::get('/reportes/usuarios/pdf', [ReportesController::class, 'exportUsuariosPDF'])->name('reportes.exportUsuariosPDF');
    Route::get('/reportes/clientes/pdf', [ReportesController::class, 'exportClientesPDF'])->name('reportes.exportClientesPDF');
    Route::get('/reportes/compras/pdf', [ReportesController::class, 'exportComprasPDF'])->name('reportes.exportComprasPDF');
});

