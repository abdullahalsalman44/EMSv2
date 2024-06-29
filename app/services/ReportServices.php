<?php

namespace app\services;

use App\Events\NewReportEvent;
use App\Http\Resources\ReportResource;
use App\Models\notification;
use App\Models\Report;
use App\Models\Reservation;
use App\Models\Salon;
use Illuminate\Support\Facades\Auth;

class ReportServices
{
    public function addReport($report)
    {
        $user = Auth::user();



        /**Check if the reservation belongs to the user */
        $reservation = Reservation::id($report['reservation_id']);
        if ($reservation->user_id != $user->id) {
            return response()->json([
                'message' => 'Sorry, you do not have a reservation with this number'
            ], 403);
        }

        /**Check if the report already exists */
        if (Report::query()->where('user_id', $user->id)->where('reservation_id', $report['reservation_id'])->where('reson', $report['reson'])->exists()) {
            return response()->json([
                'message' => 'Yoy have reported this previously'
            ], 403);
        }

        /**Create a new report */
        $newReport = Report::query()->create([
            'user_id' => $user->id,
            'salon_id' => $reservation->salon_id,
            'reservation_id' => $report['reservation_id'],
            'reson' => $report['reson']
        ]);


        /**Send notifications to the super admin */
        $salon = Salon::query()->find($newReport->salon_id);
        event(new NewReportEvent($user->name, $salon->name, $newReport->id));

        return response()->json([
            'message' => 'Report added successfully',
            'report' => $report
        ], 200);
    }

    public function showReports()
    {
        $user = Auth::user();

        /**check if the user is client or super admin */
        if ($user->hasRole('client'))
            $reports = $user->reports;
        else {
            $reports = Report::all();
        }

        /**check if report is empty */
        if ($reports->count() == 0)
            return response()->json([
                'message' => 'There is no reports',
            ], 403);

        /**successfully */
        return response()->json([
            'message' => 'There is the reports',
            'report' => ReportResource::collection($reports)
        ], 200);
    }

    public function numberOfReports()
    {
        $numOfRep = [];

        /**get all salons */
        $salons = Salon::all();

        /**Going through all the halls and counting the number of reports */
        foreach ($salons as $salon) {
            $reports = $salon->reports;
            if ($reports ->count()!=0)
                array_push($numOfRep, [
                    'salon_name' => $salon->name,
                    'admin_email' => $salon->admin_email,
                    'number_of_reports' => $reports->count()
                ]);
        }

        /**check if there is no reports */
        if (!$numOfRep)
            return response()->json([
                'message' => 'There is no reports'
            ], 403);

            /**success */
        return response()->json([
            'message' => 'There is salon reports number',
            'salon_reports_number' => $numOfRep
        ]);
    }
}
