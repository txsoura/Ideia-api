<?php

namespace App\Http\Controllers;

use App\Enums\EventAccess;
use App\Enums\EventRestriction;
use App\Enums\EventStatus;
use App\Enums\EventType;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request['include']) {
            return EventResource::collection(Event::with(explode(',', $request['include']))->get(), 200);
        } else {
            return EventResource::collection(Event::all(), 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'tags' => 'string',
            'start' => 'required|date|after:today',
            'access' => ['string', Rule::in(EventAccess::toArray())],
            'price' =>  'numeric|min:0',
            'type' => ['string', Rule::in(EventType::toArray())],
            'restriction' => ['string', Rule::in(EventRestriction::toArray())],
            'available' => 'date|after:now',
            'ticket' => 'numeric|min:0',
            'producer_id' =>  'required|numeric|exists:users,id',
            'address_id' =>  'required|numeric|exists:users,id',
        ]);

        $event = Event::create($request->all());
        return new EventResource($event, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Event $event)
    {
        if ($request['include']) {
            return EventResource::collection(Event::where('id', $event->id)->with(explode(',', $request['include']))->get(), 200);
        } else {
            return new EventResource($event, 200);
        }
        return new EventResource($event, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'tags' => 'string',
            'start' => 'required|date|after:today',
            'access' => ['string', Rule::in(EventAccess::toArray())],
            'price' =>  'numeric|min:0',
            'type' => ['string', Rule::in(EventType::toArray())],
            'restriction' => ['string', Rule::in(EventRestriction::toArray())],
            'ticket' => 'numeric|min:0',
        ]);

        $event->update($request->all());

        return new EventResource($event, 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => trans('message.deleted')], 204);
    }

    /**
     * Update the status to available.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function available(Event $event)
    {
        $event->status = EventStatus::AVAILABLE;
        $event->update();

        return new EventResource($event, 202);
    }

    /**
     * Update the status to ticket_out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function ticketOut(Event $event)
    {
        $event->status = EventStatus::TICKET_OUT;
        $event->update();

        return new EventResource($event, 202);
    }

    /**
     * Update the status to out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function out(Event $event)
    {
        $event->status = EventStatus::OUT;
        $event->update();

        return new EventResource($event, 202);
    }

    /**
     * Update the status to canceled.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function cancel(Event $event)
    {
        $event->status = EventStatus::CANCELED;
        $event->update();

        return new EventResource($event, 202);
    }

    /**
     * Update the status to blocked.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function block(Event $event)
    {
        $event->status = EventStatus::BLOCKED;
        $event->update();

        return new EventResource($event, 202);
    }
}
