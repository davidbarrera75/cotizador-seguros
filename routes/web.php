<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\CotizadorForm;
use App\Livewire\ResultadosCotizacion;
use App\Livewire\CheckoutPage;
use App\Livewire\SliderManager;

// Página principal: formulario del cotizador
Route::get('/', CotizadorForm::class)->name('home');

// Resultados de la cotización (con nombre de ruta)
Route::get('/resultados/{cotizacion}', ResultadosCotizacion::class)
    ->name('resultados');

// Checkout (opcional pero útil tener nombre)
Route::get('/checkout/{cotizacion}', CheckoutPage::class)
    ->name('checkout');

// Página de gracias (si tienes una vista simple)
Route::view('/gracias', 'gracias')->name('gracias');

// Healthcheck opcional
Route::get('/ping', fn () => 'pong')->name('ping');

Route::get('/checkout/{cotizacion}', \App\Livewire\CheckoutPage::class)->name('checkout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/slider', SliderManager::class)->name('admin.slider');
});

