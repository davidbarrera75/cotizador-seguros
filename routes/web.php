<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CotizadorForm;
use App\Livewire\ResultadosCotizacion;
use App\Livewire\CheckoutPage; // <-- Esta es la línea que faltaba

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', CotizadorForm::class);
Route::get('/resultados/{cotizacion}', ResultadosCotizacion::class);
Route::get('/checkout/{cotizacion}', CheckoutPage::class);
Route::view('/gracias', 'gracias');
