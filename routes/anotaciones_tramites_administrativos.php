<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ATramitesAdministrativos\PrediosIgnorados\PrediosIgnorados;
use App\Livewire\ATramitesAdministrativos\VariacionesCatastrales\VariacionesCatastrales;

Route::group([], function(){

    Route::get('variaciones_catastrales', VariacionesCatastrales::class)->middleware('permission:Variaciones catastrales')->name('variaciones_catastrales');

    Route::get('predios_ignorados', PrediosIgnorados::class)->middleware('permission:Predios ignorados')->name('predios_ignorados');

});