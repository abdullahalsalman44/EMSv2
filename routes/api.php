<?php

use App\Models\User;
use App\Models\Salon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Query\Builder;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FoodController;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\DressController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\DressImageController;
use App\Http\Controllers\FatoorahController;
use App\Http\Controllers\FavorateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SalonEventsController;
use App\Http\Controllers\SalonImagesController;
use App\Http\Controllers\SalonEventFoodsController;
use App\Models\Discount;
use App\Models\Dress;
use App\Models\favoratable;
use App\Models\Reservation;
use App\Models\salon_event_food;
use PhpParser\Node\Stmt\Echo_;
use PhpParser\Node\Stmt\Return_;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

$user = Auth::user();


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/**
 * fatoorah
 */
Route::get('call_back', [FatoorahController::class, 'paymentCallback']);

//////////////super admin requests
Route::post('stordressimage/{id}', [DressImageController::class, 'store']);
Route::delete('deleteDressImage/{id}', [DressImageController::class, 'destroy']);


//////////////Authentication
Route::post('register', [AuthController::class, 'register'])->middleware(['checkEmailIfExsist']);
Route::post('login', [AuthController::class, 'login']);

Route::post('checkcode', [AuthController::class, 'checkVerifyCode'])->middleware(['auth:sanctum']);
Route::post('forgetPassword', [AuthController::class, 'forgetPassword']);
Route::post('updatepassword', [AuthController::class, 'reSetPassword']);


Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    /**Discounts */
    Route::post('addDiscount', [DiscountController::class, 'addDiscount'])->middleware('can:create_discount');
    Route::post('updateDiscount', [DiscountController::class, 'updateDiscount'])->middleware('can:update_discount');
    Route::delete('deleteDiscount/{id}', [DiscountController::class, 'deleteDiscount'])->middleware('can:delete_discount');
    Route::get('showDiscounts',[DiscountController::class,'showDiscounts'])->middleware('can:show_discounts');

    /**Reports */
    Route::post('addReport', [ReportController::class, 'addReport'])->middleware('can:add_report');
    Route::get('showReports',[ReportController::class,'showReports'])->middleware('can:show_report');
    Route::get('showReportNumber',[ReportController::class,'showReportsNumber'])->middleware('can:show_report_number');

    /** Favorates */
    Route::post('addToFavorate', [FavorateController::class, 'addToFavorates'])->middleware('can:favorates_services');
    Route::get('getFavorateSalons', [FavorateController::class, 'getSalons'])->middleware('can:favorates_services');
    Route::get('getFavorateDresses', [FavorateController::class, 'getDresses'])->middleware('can:favorates_services');
    Route::post('deleteFromFavorate', [FavorateController::class, 'deleteFromFavorate'])->middleware('can:favorates_services');
    /**reservations */
    Route::post('newReservation/{id}', [ReservationController::class, 'store'])->middleware(['can:add_reservation', 'reservation_roles']);
    Route::post('getReservations/{id}', [ReservationController::class, 'index'])->middleware(['can:get_all_reservations']);
    Route::get('getClientReservations', [ReservationController::class, 'getClientReservations'])->middleware(['can:get_client_reservations']);
    Route::post('getBill', [ReservationController::class, 'getBill'])->middleware(['can:get_bill']);
    Route::post('updateReservation/{id}', [ReservationController::class, 'update'])->middleware(['can:update_reservation']);
    Route::delete('deleteReservation/{id}', [ReservationController::class, 'destroy'])->middleware(['can:delete_reservation']);

    /////User informations
    Route::get('getUserInformations', [AuthController::class, 'getUserInformations'])->middleware(['can:user_informations']);
    Route::post('deleteUser', [AuthController::class, 'deleteUserAccount'])->middleware(['can:delete_user_account']);
    Route::post('checkDeleteCode', [AuthController::class, 'checkDeleteCode'])->middleware(['can:delete_user_account']);

    ///salon image
    Route::post('storeimagetosalon/{id}', [SalonImagesController::class, 'store'])->middleware(['can:store_image_salon']);
    Route::delete('deletimagefromesalon/{id}', [SalonImagesController::class, 'destroy'])->middleware(['can:delete_image_salon']);

    ///salon
    Route::get('showSalon/{id}', [SalonController::class, 'show'])->middleware(['can:salon_show']);
    Route::post('getsalonusingprovince', [SalonController::class, 'getsalonusingprovince'])->middleware(['can:getsalonusingprovince']);
    Route::get('getallsalons', [SalonController::class, 'index'])->middleware(['can:salon_index']);
    Route::post('updateSalon/{id}', [SalonController::class, 'update'])->middleware(['can:update_salon']);
    Route::post('seachSalon', [SalonController::class, 'searchSalon'])->middleware(['can:search_salon']);

    ///////foods
    Route::post('index', [FoodController::class, 'index'])->middleware(['can:food_index']);
    Route::post('storefood', [FoodController::class, 'store'])->middleware(['can:storFood']);
    Route::post('updatefood/{id}', [FoodController::class, 'update'])->middleware(['can:update_food']);
    Route::delete('deletefood/{id}', [FoodController::class, 'destroy'])->middleware(['can:food_delete']);


    ///////Events
    Route::post('addevent/{id}', [SalonEventsController::class, 'store'])->middleware(['can:store_event']);
    Route::get('getevents/{id}', [SalonEventsController::class, 'index'])->middleware(['verified', 'can:index_event']);
    Route::delete('deletevent/{id}', [SalonEventsController::class, 'destroy'])->middleware(['can:delete_event']);


    ///////Salon events food
    Route::post('addfoodtoevent/{id}', [SalonEventFoodsController::class, 'store'])->middleware(['can:salon_event_store']);
    Route::post('getfoodthisevent', [SalonEventFoodsController::class, 'index'])->middleware(['can:salon_event_food_index']);


    /////logout
    Route::post('user/logout', [AuthController::class, 'logout'])->middleware(['can:client_logout']);
    Route::post('admin/logout', [AuthController::class, 'logout'])->middleware(['can:admin_logout']);

    ///////////////Super admin
    Route::post('createSalon', [SalonController::class, 'store'])->middleware(['can:salon_create']);
    Route::delete('deleteSalon/{id}', [SalonController::class, 'destroy'])->middleware(['can:salon_delete']);
    //////////////Super admin //////////Dresss
    Route::post('storeDress', [DressController::class, 'store'])->middleware(['can:dress_create']);
    Route::get('getDresses', [DressController::class, 'index'])->middleware(['can:dress_index']);
    Route::delete('deleteDress/{id}', [DressController::class, 'destroy'])->middleware(['can:dress_delete']);
    Route::post('updateDress/{id}', [DressController::class, 'update'])->middleware(['can:dress_update']);
    Route::post('storeDressImage/{id}', [DressImageController::class, 'store'])->middleware(['can:create_image_dress']);
    Route::delete('deleteDressImage/{id}', [DressImageController::class, 'destroy'])->middleware(['can:delete_image_dress']);
});



Route::post('seed', function () {

    $userPermissions = [
        'getsalonusingprovince', 'salon_index', 'salon_show', 'food_index',
        'client_logout', 'index_event',
        'salon_event_food_index',
        'user_informations', 'delete_user_account',
        'search_salon',
        'dress_index', 'dress_show',
        'add_reservation', 'get_bill', 'update_reservation', 'delete_reservation', 'get_all_reservations', 'get_client_reservations',
        'favorates_services',
        'show_discounts',
        'add_report','show_report'
    ];

    $adminPermissions = [
        'admin_logout',
        'store_event', 'index_event', 'delete_event',
        'salon_event_store', 'salon_show',
        'salon_event_food_index',
        'store_image_salon', 'delete_image_salon',
        'user_informations', 'update_salon',
        'get_bill', 'get_all_reservations',
        'create_discount', 'delete_discount', 'update_discount', 'show_discounts'
    ];

    $superAdminPermissions = [
        'storFood', 'food_index', 'food_delete', 'update_food',
        'salon_create', 'salon_delete', 'salon_index', 'salon_show',
        'dress_create', 'dress_delete', 'dress_update', 'dress_show', 'dress_index',
        'create_image_dress', 'delete_image_dress',
        'show_report','show_report_number'
    ];


    foreach ($userPermissions as $permission) {
        Permission::findOrCreate($permission, guardName: 'web');
    }


    foreach ($adminPermissions as $permission) {
        Permission::findOrCreate($permission, guardName: 'web');
    }

    foreach ($superAdminPermissions as $permission) {
        Permission::findOrCreate($permission, guardName: 'web');
    }

    $admin = Role::query()->where('name', 'admin')->first()->syncPermissions($adminPermissions);
    $client = Role::query()->where('name', 'client')->first()->syncPermissions($userPermissions);
    $super = Role::query()->where('name', 'superAdmin')->first()->syncPermissions($superAdminPermissions);

    $users = User::all();
    foreach ($users as $user) {
        if ($user->hasRole('admin'))
            $user->givePermissionTo($adminPermissions);

        if ($user->hasRole('client'))
            $user->givePermissionTo($userPermissions);

        if ($user->hasRole('superAdmin'))
            $user->givePermissionTo($superAdminPermissions);
    }

    $user = User::query()->where('email', 'abd@gmail.com')->first();
    return response()->json([
        'permssions' => $user->permissions
    ]);
});



Route::post('createadmin', function () {
    $user = User::query()->create([
        'name' => 'abdo',
        'email' => 'abdo@gmail.com',
        'password' => Hash::make('password'),
    ]);
    $user['email_verified_at'] = date("y-m-d", time());
    $user->save();
    $adminRole = Role::query()->where('name', 'admin')->first();
    $user->assignRole($adminRole);
    $permissions = $adminRole->permissions()->pluck('name')->toArray();
    $user->givePermissionTo($permissions);
    $user = User::query()->find($user->id);
    $user['token'] = $user->createToken('token')->plainTextToken;
    return response()->json([
        'user' => $user,
        'role' => $user->roles,
        'permissions' => $user->permissions,
        'token'=>$user['token']
    ]);
});


Route::get('permissions', function () {
    $admin = User::query()->where('name', '=', 'abdullah')->first();
    $client = User::query()->where('name', '=', 'ali')->first();
    return [
        'client' => $client->permissions,
        'admin' => $admin->permissions
    ];
});
