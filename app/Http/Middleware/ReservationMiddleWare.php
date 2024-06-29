<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Food;
use App\Models\Dress;
use App\Models\Salon;
use App\Models\BookingDate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\returnSelf;
use Symfony\Component\HttpFoundation\Response;

class ReservationMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (strtotime($request->timeInformations['end']) - strtotime($request->timeInformations['start']) <= 3600)
            return response()->json([
                'message' => 'Un accepted time'
            ]);

        $salon = Salon::query()->find($request->route('id'));

        if (!Carbon::parse($request->timeInformations['start'])->isBetween($salon->start, $salon->end) || !Carbon::parse($request->timeInformations['end'])->isBetween($salon->start, $salon->end))
            return response()->json([
                'message' => 'salon open at ' . $salon->start
            ]);

        if (!$salon->isAvailable($request->timeInformations['day'], $request->timeInformations['start'], $request->timeInformations['end'])) {
            return response()->json([
                'message' => 'This time not available at date ' . $request->timeInformations['day']
            ]);
        }

        if (isset($request->foods)) {
            foreach ($request->foods as $food) {
                $food = Food::GetUsingId($food['food_id']);
                if ($food->count() <= 0) {
                    return response()->json([
                        'message' => 'Food not found'
                    ], 404);
                }
            }
        }

        if (isset($request->dresses)) {
            foreach ($request->dresses as $dress) {
                $dressinsystem = Dress::Id($dress['dress_id']);
                if ($dressinsystem->count() <= 0)
                    return response()->json([
                        'message' => 'Dress not found'
                    ], 203);

                if ($dress['number'] > $dressinsystem['number']) {
                    return response()->json([
                        'message' => 'This amount of clothing is not available'
                    ], 203);
                }
            }
        }

        return $next($request);
    }
}
