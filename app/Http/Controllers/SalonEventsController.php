<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SalonEventsServices;

class SalonEventsController extends Controller
{

    public $saloneventsservice;

    public function __construct(SalonEventsServices $saloneventsservice) {
        $this->saloneventsservice=$saloneventsservice;
    }
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        return $this->saloneventsservice->getAllEvents($id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $salon_id,Request $request)
    {
     return  $this->saloneventsservice->addEvent($request->event_id,$salon_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $salon_event_id)
    {
        return  $this->saloneventsservice->deleteEvent($salon_event_id);
    }
}
