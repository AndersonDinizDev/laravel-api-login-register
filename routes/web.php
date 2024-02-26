<?php

use App\Http\Controllers\Produto2Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::any('/any', function() {
    return "Permite todo o tipo de acesso http (put, delete, get e post)";
});

Route::match(['put', 'delete'], '/match', function() {
    return "Permite apenas acessos definidos";
});

Route::get('/produto2/{id}', function($id) {
    return "O id do produto é: $id";
});

Route::get('/sobre', function() {
    return redirect('/empresa'); // Redireciona para outro lugar.
});

Route::redirect('/sobre', '/'); // Redireciona para outro lugar.

Route::view('empresa', 'site/empresa'); // Outra forma de acessar uma view.

Route::get('/news', function() {
    return view('news');
})->name('noticias'); // Nomeando uma view

Route::get('/novidades', function() {
    return redirect()->route('noticias'); // Redireciona para o nome da rota.
});

// Agrupando usando um prefixo.
// Route::prefix('admin')->group(function() {

//     Route::get('/dashboard', function() {
//         return "dashboard";
//     });
    
//     Route::get('/users', function() {
//         return "Users";
//     });
    
//     Route::get('/clientes', function() {
//         return "Clientes";
//     });

// });


// Agrupando usando um nome;
// Route::name('admin.')->group(function() {

//     Route::get('/dashboard', function() {
//         return "dashboard";
//     })->name('dashboard');
    
//     Route::get('/users', function() {
//         return "Users";
//     })->name('users');
    
//     Route::get('/clientes', function() {
//         return "Clientes";
//     })->name('clientes');

// });

// Agrupando por prefixo e nome.
Route::group(['prefix' => 'admin', 'as' => 'admin'], function() {


    Route::get('/dashboard', function() {
        return "dashboard";
    })->name('dashboard');
    
    Route::get('/users', function() {
        return "Users";
    })->name('users');
    
    Route::get('/clientes', function() {
        return "Clientes";
    })->name('clientes');

});

Route::get('/produto', [ProdutoController::class, 'index']);

Route::get('/produto/{id}', [ProdutoController::class, 'show']);

Route::resource('produtos', Produto2Controller::class); // Utiliza todos os métodos.
