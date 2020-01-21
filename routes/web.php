<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@welcome')->name('welcome');


Auth::routes(['verify' => true]);

Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get( 'tools/search', 'ToolController@search');
Route::post('tools/search', 'ToolController@search');


Route::get('/home', 'HomeController@index')->name('home');


//Route::resource('users', 'UserController');
Route::resource('tools', 'ToolController')->middleware('verified');

Route::resource('orders', 'OrderController');
Route::resource('categories', 'CategoryController');
Route::resource('category_tool', 'Category_toolController');
Route::resource('drivers', 'DriverController');
Route::resource('register_choice', 'Register_choiceController');
Route::resource('payments', 'PaymentController');

Route::resource('formulaire', 'FormulaireController');

Route::get('infos', function()
{
    return view('infos');
});

// Messagerie
Route::post('/comments/{tool}', 'CommentController@store')->name('comments.store');
Route::post('/tools/message', 'CommentController@index')->name('comments.show');
Route::post('/commentReply/{comment}', 'CommentController@storeCommentReply')->name('comments.storeReply');
Route::get('showFromNotification/{tool}/{notification}', 'ToolController@showFromNotification')->name('tools.showFromNotification');


// Administrateur
Route::group(['middleware' => ['auth','admin']], function () {

    Route::get('/dashboard', 'Admin\DashboardController@data');
    Route::get('/user-register', 'Admin\DashboardController@registered');
    Route::get('/post-register', 'Admin\DashboardController@posted');
    Route::get('/user-edit/{id}', 'Admin\DashboardController@registeredit');
    Route::put('/user-register-update/{id}', 'Admin\DashboardController@registerupdate');
    Route::get('/post-edit/{id}', 'Admin\DashboardController@postedit');
    Route::put('/post-register-update/{id}', 'Admin\DashboardController@postupdate');
    Route::delete('/user-delete/{id}', 'Admin\DashboardController@registerdelete' );
    Route::delete('/post-delete/{id}', 'Admin\DashboardController@postdelete');
});

//Drivers

Route::group(['middleware' => ['auth','driver']], function () {
  Route::get('/courses', 'DriverController@index')->name('courses');
});

// profil utilisateur

Route::get('/profile', 'ProfileController@myprofile');
Route::get('/profile-edit/{id}', 'ProfileController@profiledit');
Route::put('/profile-update/{id}', 'ProfileController@profileupdate');
Route::delete('/profile-delete/{id}', 'ProfileController@profiledelete');

Route::get('/mypost-edit/{id}', 'ProfileController@mypostedit');
Route::put('/mypost-update/{id}', 'ProfileController@mypostupdate');




//Export PDF bon de commande
Route::get('/download_pdf', 'PaymentController@export')->name('payments.export');

//  Map Coordonnée

Route::get('/map/{order}', 'DriverController@order');

// Pdf Download
Route::get('/download_pdf', 'PaymentController@export')->name('payments.export');

//Cloudinary
Route::post('/upload/images', [
  'uses'   =>  'ImageUploadController@uploadImages',
  'as'     =>  'uploadImage'
]);

