<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/ebook/get/{id}', [App\Http\Controllers\Api\EbooksController::class, 'getBookById'])->name('getEBookById');
Route::get('/ebook/user/get/{user_id}', [App\Http\Controllers\Api\EbooksController::class, 'getByUserid'])->name('getEbookByUserid');
Route::post('/ebook/create/', [App\Http\Controllers\Api\EbooksController::class, 'insertebook'])->name('insertebook');
Route::post('/ebook/update/', [App\Http\Controllers\Api\EbooksController::class, 'updateebook'])->name('updateebook');
Route::post('/ebook/search/', [App\Http\Controllers\Api\EbooksController::class, 'searchebook'])->name('search-ebook');
Route::get('/ebook/delete/{id}', [App\Http\Controllers\Api\EbooksController::class, 'deleteebook'])->name('delete-ebook');
Route::get('/ebook/featured/{id}', [App\Http\Controllers\Api\EbooksController::class, 'featuredEbooks'])->name('featured-ebook');


Route::post('/addBook', [App\Http\Controllers\Api\BookController::class, 'addBook'])->name('addBook');
Route::get('/BooksBycat_id/{id}', [App\Http\Controllers\Api\BookController::class, 'BooksBycat_id'])->name('BooksBycat_id');
Route::get('/Bookbyid/{id}', [App\Http\Controllers\Api\BookController::class, 'Bookbyid'])->name('Bookbyid');
Route::get('/Booksbywriter/{id}', [App\Http\Controllers\Api\BookController::class, 'Booksbywriter'])->name('Booksbywriter');
Route::get('/BooksFeatured', [App\Http\Controllers\Api\BookController::class, 'BooksFeatured'])->name('BooksFeatured');
Route::get('/Booksbyuser/{id}', [App\Http\Controllers\Api\BookController::class, 'Booksbyuser'])->name('Booksbyuser');
Route::get('/Booksneworused/{id}', [App\Http\Controllers\Api\BookController::class, 'Booksneworused'])->name('Booksneworused');
Route::get('/Booksoffers', [App\Http\Controllers\Api\BookController::class, 'Booksoffers'])->name('Booksoffers');
Route::post('/searchbyBooks', [App\Http\Controllers\Api\BookController::class, 'searchbyBooks'])->name('searchbyBooks');

//favourite book
Route::post('/addfavBook', [App\Http\Controllers\Api\FavouriteController::class, 'addfavBook'])->name('addfavBook');
Route::post('/deletefavBook', [App\Http\Controllers\Api\FavouriteController::class, 'deletefavBook'])->name('deletefavBook');
Route::get('/getFavBook/{id}', [App\Http\Controllers\Api\FavouriteController::class, 'getFavBookByUserId'])->name('getFavBookByUserId');

//currency
Route::get('/convertcurrency/{cu}', [App\Http\Controllers\Api\CurrencyController::class, 'convertcurrency'])->name('convertcurrency');
//categories
Route::get('/all', [App\Http\Controllers\Api\CategoryController::class, 'all'])->name('all');
Route::get('/Mainpg', [App\Http\Controllers\Api\CategoryController::class, 'MainpgAPI'])->name('MainpgAPI');
Route::get('/getMainCat', [App\Http\Controllers\Api\CategoryController::class, 'getMainCatAPI'])->name('getMainCatAPI');
Route::get('/getSubCat/{id}', [App\Http\Controllers\Api\CategoryController::class, 'getSubCatAPI'])->name('getSubCatAPI');

//order
Route::post('/makeorder', [App\Http\Controllers\Api\OrderController::class, 'makeorder'])->name('makeorder');
Route::post('/makeorderDetails', [App\Http\Controllers\Api\OrderController::class, 'makeorderDetails'])->name('makeorderDetails');
Route::get('/getorderbycustID/{id}', [App\Http\Controllers\Api\OrderController::class, 'getorderbycustID'])->name('getorderbycustID');
Route::get('/getorderDetails/{id}', [App\Http\Controllers\Api\OrderController::class, 'getorderDetails'])->name('getorderDetails');

//content
Route::get('/showcontent', [App\Http\Controllers\Api\ContentController::class, 'showcontent'])->name('showcontent');

//login
Route::post('/register', [App\Http\Controllers\Api\LoginController::class, 'register'])->name('register');
Route::post('/login', [App\Http\Controllers\Api\LoginController::class, 'login'])->name('login');

//user
Route::post('/updateProfile', [App\Http\Controllers\Api\UserController::class, 'updateProfile'])->name('updateProfile');
Route::post('/user/update/fcm', [App\Http\Controllers\Api\UserController::class, 'updateFcm'])->name('updateFcm');

Route::get('/getuserbyID/{id}', [App\Http\Controllers\Api\UserController::class, 'getuserbyID'])->name('getuserbyID');
Route::get('/getAllWriters', [App\Http\Controllers\Api\UserController::class, 'getAllWritersAPI'])->name('getAllWriters');
Route::get('/getalllibraries', [App\Http\Controllers\Api\UserController::class, 'getalllibrariesAPI'])->name('getalllibraries');
Route::get('/getDarelnashr', [App\Http\Controllers\Api\UserController::class, 'getDarelnashrAPI'])->name('getDarelnashr');
//posts
Route::post('/addpost', [App\Http\Controllers\Api\PostController::class, 'addpostAPI'])->name('addpostAPI');
Route::post('/addfile', [App\Http\Controllers\Api\PostController::class, 'addfileAPI'])->name('addfileAPI');
Route::post('/addcomment', [App\Http\Controllers\Api\PostController::class, 'addcommentAPI'])->name('addcommentAPI');
Route::post('/addlikes', [App\Http\Controllers\Api\PostController::class, 'addlikesAPI'])->name('addlikesAPI');
Route::get('/getallposts/{pageNum?}', [App\Http\Controllers\Api\PostController::class, 'getallpostsAPI'])->name('getallpostsAPI');
Route::get('/getpostsbyuserID/{id}', [App\Http\Controllers\Api\PostController::class, 'getpostsbyuserIDAPI'])->name('getpostsbyuserIDAPI');
Route::get('/getpostDetails/{id}', [App\Http\Controllers\Api\PostController::class, 'getpostDetailsAPI'])->name('getpostDetailsAPI');

//city
Route::get('/getallcity', [App\Http\Controllers\Api\CityController::class, 'getallcityAPI'])->name('getallcity');
Route::get('/getcitiesbycountryid/{id}', [App\Http\Controllers\Api\CityController::class, 'getcitiesbycountryid'])->name('getcitiesbycountryid');
Route::get('/getallcountries', [App\Http\Controllers\Api\CityController::class, 'getallcountriesAPI'])->name('getallcountriesAPI');
Route::get('/getallcountries_withcurrency', [App\Http\Controllers\Api\CityController::class, 'getallcountries_withcurrencyAPI'])->name('getallcountries_withcurrencyAPI');



