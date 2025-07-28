<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController; // Certifique-se de que esta linha está aqui!

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Este grupo de rotas exige que o usuário esteja autenticado
Route::middleware('auth')->group(function () {
    // Rotas de Perfil (já estavam aqui)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // NOVAS POSIÇÕES DAS ROTAS DE DOCUMENTOS (agora protegidas!)
    Route::resource('documents', DocumentController::class);
    Route::get('documents/{document}/download/{format}', [DocumentController::class, 'download'])->name('documents.download');
});


require __DIR__.'/auth.php';