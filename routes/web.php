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

Route::get( 'tools/search', 'ToolController@list');
Route::post('tools/search', 'ToolController@search');

Route::get('/home', 'HomeController@index')->name('home');


//Route::resource('users', 'UserController');
Route::resource('tools', 'ToolController')->middleware('verified');

Route::resource('orders', 'OrderController');
Route::resource('categories', 'CategoryController');
Route::resource('category_tool', 'Category_toolController');
Route::resource('drivers', 'DriverController');
Route::resource('registerchoices', 'RegisterChoiceController');
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

//Export PDF bon de commande
Route::get('/download_pdf', 'PaymentController@export')->name('payments.export');
