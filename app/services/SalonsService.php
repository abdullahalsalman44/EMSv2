<?php

namespace app\Services;

use App\Models\Salon;
use App\Http\Resources\SalonResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SalonsService
{

    public function getSalons()
    {
        $salons = Salon::all();
        if ($salons->count() == 0)
            return response()->json([
                'message' => 'There are no salons in the system currentrly'
            ], 203);
        return response()->json([
            'salons' => SalonResource::collection(Salon::all())
        ], 200);
    }

    public function getSalon($id)
    {
        $salon = Salon::find($id);
        if ($salon == null)
            return response()->json([
                'message' => 'The salon was not found'
            ], 404);

        $user = Auth::user();
        if ($user->hasRole('admin')) {
            if ($salon->admin_email != $user->email) {
                return response()->json([
                    'message' => 'You dont have permissions to show this salon'
                ], 401);
            } else {
                return response()->json([
                    'salon' => new SalonResource($salon)
                ], 401);
            }
        } else
            return response()->json([
                'salon' => new SalonResource($salon)
            ]);
    }

    public function storSalon($salon)
    {
        $adminEmail = $salon['admin_email'];
        $admin = User::query()->where('email', '=', $adminEmail)->first();
        if (!$admin->hasRole('admin')) {
            return response()->json([
                'message' => 'This user cannot own a salon in the system because he is not an admin',
                'user' => $admin
            ], 203);
        }
        $salon = Salon::create($salon);
        return response()->json([
            'message' => 'The salon has been added to the system successfully',
            'salon' => $salon
        ], 200);
    }

    public function updateSalon($data, $id)
    {
        $salon = Salon::query()->find($id);

        if ($salon == null) {
            return response()->json([
                'message' => 'Salon not found'
            ], 404);
        }
        $salon->update([
            'name' => $data['name'] ?? $salon['name'],
            'capacity' => $data['capacity'] ?? $salon['capacity'],
            'pricefortable' => $data['pricefortable'] ?? $salon['pricefortable'],
            'Adress' => $data['Adress'] ?? $salon['Adress'],
            'start'=>$data['start'] ?? $salon['start'],
            'end'=>$data['end'] ?? $salon['end']
        ]);

        return response()->json([
            'message' => 'Salon informations updated successfully'
        ], 200);
    }

    public function deletSalon($id)
    {
        $salon = Salon::query()->find($id);

        if ($salon == null) {
            return response()->json([
                'message' => 'Salon not found'
            ], 404);
        }

        $adminEmail = $salon->admin_email;
        $salon->delete();

        $checker = Salon::query()->where('admin_email', '=', $adminEmail)->exists();
        if ($checker == false) {
            $admin = User::query()->where('email', '=', $adminEmail)->first();
            $admin->delete();
        }

        return response()->json([
            'message' => 'Salon deleted successfully'
        ], 200);
    }

    public function getsalonusingprovince($Adress)
    {
        $salons = Salon::where('Adress', '=', $Adress)->get();
        if ($salons->count() == 0)
            return response()->json([
                'message' => 'We do not have salons available in this governorate'
            ], 203);
        else
            return response()->json([
                'salons' => SalonResource::collection($salons)
            ], 200);
    }

    public function addImageToSalon($salon_id, $path)
    {
    }

    public function srearchSalon($salonName)
    {

        $salon = Salon::query()->where('name', 'like', $salonName . '%')->get();
        if ($salon->count() == 0) {
            return response()->json([
                'message' => 'No results found'
            ], 401);
        }
        return response()->json([
            'salon' => SalonResource::collection($salon)
        ], 200);
    }
}
