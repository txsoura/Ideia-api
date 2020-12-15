<?php

namespace App\Http\Controllers;

use App\Enums\TicketStatus;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request['include']) {
            return TicketResource::collection(Ticket::with(explode(',', $request['include']))->get(), 200);
        } else {
            return TicketResource::collection(Ticket::all(), 200);
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
            'status' => ['string', Rule::in(TicketStatus::toArray())],
            'price' => 'required|numeric',
            'event_id' =>  'required|numeric|exists:events,id',
            'customer_id' =>  'required|numeric|exists:users,id',
        ]);

        $ticket = Ticket::create($request->all());
        return new TicketResource($ticket, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Ticket $ticket)
    {
        if ($request['include']) {
            return TicketResource::collection(Ticket::where('id', $ticket->id)->with(explode(',', $request['include']))->get(), 200);
        } else {
            return new TicketResource($ticket, 200);
        }
        return new TicketResource($ticket, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'customer_id' =>  'required|numeric|exists:users,id',
        ]);

        $ticket->update($request->all());

        return new TicketResource($ticket, 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(['message' => trans('message.deleted')], 204);
    }

    /**
     * Update the status to approved.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function approve(Ticket $ticket)
    {
        $ticket->status = TicketStatus::APPROVED;
        $ticket->update();

        return new TicketResource($ticket, 202);
    }

    /**
     * Update the status to canceled.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function cancel(Ticket $ticket)
    {
        $ticket->status = TicketStatus::CANCELED;
        $ticket->update();

        return new TicketResource($ticket, 202);
    }
}
