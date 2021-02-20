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

use App\Model\DailyCost;
use App\Model\FixedCost;
use App\Model\User;

Route::get('/', function () {
    return redirect()->route('get_dashboard');
    // return redirect()->route('get_monthly_cost_view',['month'=>date('m'), 'year'=> date('Y')]);
})->middleware('auth');

Route::get('/log', 'Controller@getLogin')->name('login');
Route::post('/login', 'Controller@login')->name('post_login');
Route::get('/logout', 'Controller@logout')->name('logout');

Route::prefix('admin')->middleware('auth')->group(function () {

    // DASHBOARD

    Route::get('/dashboard', 'AdminController@getDashboard')->name('get_dashboard');
    Route::post('/morning-coffee', 'AdminController@saveMorningCoffee')->name('save_morning_coffee');



    Route::get('fixedCostView', 'AdminController@getFixedCostView')->name('get_fixed_cost_view');
    Route::get('dailyCostView', 'AdminController@getDailyCostView')->name('get_daily_cost_view');
    Route::get('personalDailyCost', 'AdminController@personalDailyCost')->name('get_personal_daily_cost_view');
    Route::post('filterDailyCost', 'AdminController@filterDailyCost')->name('filter_daily_cost');

    Route::get('addDailyCost/{together}', 'AdminController@getAddDailyCostView')->name('get_add_daily_cost_view');
    Route::post('addDailyCost', 'AdminController@addDailyCost')->name('post_add_daily_cost');

    Route::get('addFixedCost', 'AdminController@getAddFixedCostView')->name('get_add_fixed_cost_view');
    Route::post('addFixedCost', 'AdminController@AddFixedCost')->name('add_fixed_cost');

    Route::get('editDailyCost/{id}/{together}', 'AdminController@getEditDailyCostView')->name('get_edit_daily_cost_view');
    Route::post('editDailyCost/{id}', 'AdminController@editDailyCost')->name('post_edit_daily_cost');

    Route::get('deleteDailyCost/{id}', 'AdminController@deleteDailyCost')->name('get_delete_daily_cost');

    Route::get('monthlyCostView/{month}/{year}', 'AdminController@getMonthlyCostView')->name('get_monthly_cost_view');
    Route::post('filterMonthlyCost', 'AdminController@filterMonthlyCost')->name('filter_monthly_cost');

    Route::get('sendMailNotify-{month}-{id}', 'AdminController@sendMail')->name('send_mail');

    Route::get('installment-list', 'AdminController@getInstallmentList')->name('get_installment_list');
    Route::get('add-installment', 'AdminController@getAddInstallmentList')->name('add_installment_page');
    Route::post('add-installment', 'AdminController@AddInstallmentList')->name('add_installment');

    Route::get('installment-detail{id}', 'AdminController@InstallmentDetail')->name('installment_details');
    Route::get('checkout-installment-{id}-{detail}', 'AdminController@CheckOutInstallment')->name('checkout_installment');

    Route::post('ajax-installment-detail', 'AdminController@AjaxInstallmentDetail')->name('ajax-installment_details');

    Route::get('statistical-{month}-{year}', 'AdminController@statistical')->name('statistical');
    Route::post('statistical-filter', 'AdminController@filterStatistical')->name('filter_statiscal');

    Route::get('statistical-compare', 'AdminController@statisticalCompare')->name('statistical-compare');
    Route::post('statistical-compare-filter', 'AdminController@filterCompareStatistical')->name('filter_statiscal_compare');

    Route::get('notify-storage-management', 'AdminController@NoftifyAndStorageManagement')->name('notify_storage_management');
    Route::get('clean-storage-{id}', 'AdminController@CleanStorage')->name('clean_storage');

    Route::get('balance-view', 'AdminController@getBalanceList')->name('balance_list');
    Route::post('add-balance', 'AdminController@addBalance')->name('add_balance');

    Route::get('cost-calculation', 'AdminController@getCostCalculation')->name('cost_calculation');
    Route::post('calculate-cost', 'AdminController@calculateCost')->name('calculate_cost');

    Route::get('account-manager', 'AdminController@getAccountList')->name('account_list');
    Route::post('account-manager/add', 'AdminController@addAccount')->name('add_account');
    Route::post('account-manager/edit', 'AdminController@editAccount')->name('edit_account');
    Route::get('account-manager/delete/{id}', 'AdminController@deleteAccount')->name('delete_account');
});

Route::get('/test', function () {
    // $user = User::find(1);
    // $user = new User;
    // $user->name = "Nguyễn Thành Long";
    // $user->email = "nguyenthanhlong031120@gmail.com";
    // $user->avatar = "long.jpg";
    // $user->password = bcrypt("000000");
    // $user->save();
    // Mail::to('kiet1022@gmail.com')->send(new MailNotify());
    // session()->forget('coffee');
    // return bcrypt('000000');
    return $details = DailyCost::with('details')->where('id', '=', 442)->get();
});

// Route::post('test-ocr', function (Request $re) {
//     if ($re->hasFile('image')) {
//         $file = $re->file('image');
//         $duoi = $file->getClientOriginalExtension();
//         $name = $file->getClientOriginalName();
//         $img = str_random(4) . "_" . $name;
//         // while (file_exists("img/".$oldDaily->image)) {
//         //     if ($oldDaily->image != null) {
//         //         unlink("img/".$oldDaily->image);
//         //     }
//         // }
//         return $img;
//     }
// })->name('test_ocr');
