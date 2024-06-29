<?php

namespace app\services;

use App\Http\Resources\UserResource;
use App\Mail\DeletAccountMail;
use App\Mail\VerificationMail;
use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Hashing\HashManager;

use function Laravel\Prompts\password;

class UserService
{

    public function register($request)
    {
        //check if email exists early
        $user = User::query()->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make(($request['password']))
        ]);

        $this->sendEmailVerify($user->email);

        $clientRole = Role::query()->where(column: 'name', operator: 'client')->first();
        $user->assignRole($clientRole);

        //assign permissions
        $permissions = $clientRole->permissions()->pluck('name')->toArray();
        $user->givePermissionTo($permissions);

        //load the user roles and permissions
        $user->load('roles', 'permissions');

        $user = User::query()->find($user['id']);
        $user = $this->appendRolesAndPermissions($user);
        $user['token'] = $user->createToken("token")->plainTextToken;

        return response()->json([
            'message' => 'blease check your email to verify',
            'token' => $user,
        ], 200);
    }

    public function login($request)
    {
        $user = User::query()->where(column: 'email', operator: $request['email'])
            ->first();


        if (!$user == null) {
            if ($user->hasVerifiedEmail()) {
                if (!Auth::attempt($request)) {
                    return response()->json([
                        'message' => 'Error in your email or password'
                    ], 401);
                } else {
                    $user = $this->appendRolesAndPermissions($user);
                    $user['token'] = $user->createToken("token")->plainTextToken;
                    return response()->json([
                        'message' => 'Welcome back ' . $user->name,
                        'user' => $user
                    ], 200);
                }
            } else {
                return response()->json([
                    'message' => 'This email not verified please register again'
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }

    public function logout()
    {
        $user = Auth::user();
        if (!$user == null) {
            Auth::user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'User logged out successfuly'

            ], 200);
        }
    }




    public function appendRolesAndPermissions($user)
    {
        $roles = [];

        foreach ($user->roles as $role) {
            $roles = $role->name;
        }

        unset($user['roles']);
        $user['roles'] = $roles;

        $permissions = [];
        foreach ($user->permissions as $permission) {
            array_push($permissions, $permission->name);
        }

        unset($user['permissions']);
        $user['permissions'] = $permissions;
        return $user;
    }



    public function sendEmailVerify($userEmail)
    {

        EmailVerification::query()->where('email', '=', $userEmail)->delete();

        $code = mt_rand(10000, 99999);
        EmailVerification::query()->create([
            'email' => $userEmail,
            'code' => $code
        ]);

        Mail::to($userEmail)
            ->send(new VerificationMail($code));
    }



    public function checkCode($code)
    {
        $user =Auth::user(); //User::query()->find($user_id);
        $currectCode = EmailVerification::query()->where('email', '=', $user->email)->first();
        if ($code == $currectCode->code) {
            $user = User::query()->where('email', '=', $user->email)->first();
            $user['email_verified_at'] = date("y-m-d", time());
            $user->save();
            return response()->json([
                'message' => 'Email verified successfully',
                'code' => $code
            ], 200);
        }

        return response()->json([
            'message' => 'Error Code'
        ], 401);
    }


    public function sendEmailVerifyToResetPassword($userEmail)
    {
        $user = User::query()->where('email', '=', $userEmail)->first();
        if ($user != null) {
            $this->sendEmailVerify($userEmail);
            return response()->json([
                'message' => 'We sent code to this email,Please check it'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Email not found'
            ], 403);
        }
    }

    public function reSetPassword($code, $newPassword)
    {
        $passwordReset = EmailVerification::query()->where('code', '=', $code)->first();
        if ($passwordReset != null) {
            $email = $passwordReset->email;
            $user = User::query()->where('email', '=', $email)->first();
            $user['password'] = bcrypt($newPassword);
            $user->save();
            return response()->json([
                'message' => 'Password updated successfully',
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'This code is not correct'
            ], 403);
        }
    }

    public function getUserInformations()
    {
        $user = Auth::user();
        return new UserResource($user);
    }

    public function deleteMyAccount()
    {
        $user = Auth::user();
        $userEmail = $user->email;
        $code = random_int(10000, 99999);
        $emailCode = EmailVerification::query()->where('email', '=', $user->email)->first();
        $emailCode->code = $code;
        $emailCode->save();
        Mail::to($userEmail)->send(new DeletAccountMail($code));
        return response()->json([
            'message' => 'We sent code to your email please check it'
        ], 200);
    }

    public function checkDeleteAccountCode($code)
    {
        $user = Auth::user();
        $emailCode = EmailVerification::query()->where('email', '=', $user->email)->first();
        if ($code == $emailCode->code) {
            $user = User::query()->find($user->id);
            Auth::user()->currentAccessToken()->delete();
            $user->delete();
            $emailCode->delete();
            return response()->json([
                'message' => 'Your account deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error code'
            ], 201);
        }
    }
}
