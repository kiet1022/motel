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

Use App\Model\DailyCost;
Use App\Model\FixedCost;
Use App\Model\User;

Route::get('/', function(){
    return redirect()->route('get_monthly_cost_view',['month'=>date('m'), 'year'=> date('Y')]);
})->middleware('auth');

Route::get('/log', 'Controller@getLogin')->name('login');
Route::post('/login', 'Controller@login')->name('post_login');
Route::get('/logout', 'Controller@logout')->name('logout');

Route::prefix('admin')->middleware('auth')->group(function(){
    Route::get('fixedCostView', 'AdminController@getFixedCostView')->name('get_fixed_cost_view');
    Route::get('dailyCostView', 'AdminController@getDailyCostView')->name('get_daily_cost_view');
    Route::get('personalDailyCost','AdminController@personalDailyCost')->name('get_personal_daily_cost_view');
    Route::post('filterDailyCost','AdminController@filterDailyCost')->name('filter_daily_cost');

    Route::get('addDailyCost/{together}','AdminController@getAddDailyCostView')->name('get_add_daily_cost_view');
    Route::post('addDailyCost','AdminController@addDailyCost')->name('post_add_daily_cost');

    Route::get('editDailyCost/{id}/{together}','AdminController@getEditDailyCostView')->name('get_edit_daily_cost_view');
    Route::post('editDailyCost/{id}','AdminController@editDailyCost')->name('post_edit_daily_cost');

    Route::get('deleteDailyCost/{id}','AdminController@deleteDailyCost')->name('get_delete_daily_cost');

    Route::get('monthlyCostView/{month}/{year}','AdminController@getMonthlyCostView')->name('get_monthly_cost_view');
    Route::post('filterMonthlyCost','AdminController@filterMonthlyCost')->name('filter_monthly_cost');

    Route::get('sendMailNotify','AdminController@sendMail')->name('send_mail');
});

Route::get('/test', function () {
    // $user = User::find(1);
    // $user = new User;
    // $user->name = "Trần Hoàng Thạch";
    // $user->email = "thach123@gmail.com";
    // $user->password = bcrypt("000000");
    // $user->save();
    Mail::to('kiet1022@gmail.com')->send(new MailNotify());
});