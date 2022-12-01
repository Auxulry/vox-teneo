<?php
namespace App\Http\Controllers\API;

use App\Http\Requests\SportEventRequest;
use App\Http\Resources\SportEventResource;
use App\Models\SportEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SportEventController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->query('page') ?? 1;
        $perPage = $request->query('perPage') ?? 10;
        $organizer = $request->query('organizerId');

        $start = ($page - 1) * $perPage;

        $query = SportEvent::with('organizer');

        if ($organizer) {
            $query->where('organizer_id', $organizer);
        }

        $data = SportEventResource::collection($query->skip($start)->take($perPage)->get());

        return $this->setResponse(Response::HTTP_OK, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SportEventRequest $request)
    {
        $sportEvent = new SportEvent();
        $sportEvent->event_date = $request->eventDate;
        $sportEvent->event_type = $request->eventType;
        $sportEvent->event_name = $request->eventName;
        $sportEvent->organizer_id = $request->organizerId;
        $sportEvent->save();

        return $this->setResponse(Response::HTTP_CREATED, $sportEvent);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sportEvent = SportEvent::with('organizer')->find($id);

        if ($sportEvent) {
            return $this->setResponse(Response::HTTP_OK, new SportEventResource($sportEvent));
        }
        return $this->setResponse(Response::HTTP_NOT_FOUND, [], 'Sport Event not found.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SportEventRequest $request, $id)
    {
        $sportEvent = SportEvent::find($id);

        if ($sportEvent) {
            $sportEvent->event_date = $request->eventDate;
            $sportEvent->event_type = $request->eventType;
            $sportEvent->event_name = $request->eventName;
            $sportEvent->organizer_id = $request->organizerId;
            $sportEvent->save();

            return $this->setResponse(Response::HTTP_OK, $request->all());
        }
        return $this->setResponse(Response::HTTP_NOT_FOUND, [], 'Sport Event not found.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sportEvent = SportEvent::find($id);

        if ($sportEvent) {
            $sportEvent->delete();
            return $this->setResponse(Response::HTTP_OK, 'Sport Event has been successfully deleted');
        }
        return $this->setResponse(Response::HTTP_NOT_FOUND, [], 'Sport Event not found.');
    }
}
