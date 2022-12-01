<?php
namespace App\Http\Controllers\API;

use App\Http\Requests\OrganizerRequest;
use App\Http\Resources\OrganizerResource;
use App\Models\Organizer;
use App\Models\SportEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrganizerController extends ApiController
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
        $start = ($page - 1) * $perPage;

        $query = Organizer::query();

        $data = OrganizerResource::collection($query->skip($start)->take($perPage)->get());

        return $this->setResponse(Response::HTTP_OK, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizerRequest $request)
    {
        $organizer = new Organizer();

        $fileName = time() . '.' . $request->imageLocation->extension();

        $request->imageLocation->move(public_path('uploads'), $fileName);

        $organizer->organizer_name = $request->organizerName;
        $organizer->image_location = 'public/uploads/' . $fileName;

        $organizer->save();

        return $this->setResponse(Response::HTTP_CREATED, $organizer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organizer = Organizer::find($id);

        if ($organizer) {
            return $this->setResponse(Response::HTTP_OK, $organizer);
        }

        return $this->setResponse(Response::HTTP_NOT_FOUND, [], 'Organizer not found.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrganizerRequest $request, $id)
    {
        $organizer = Organizer::find($id);

        if ($organizer) {
            $fileName = time() . '.' . $request->imageLocation->extension();

            $request->imageLocation->move(public_path('uploads'), $fileName);

            $organizer->organizer_name = $request->organizerName;
            $organizer->image_location = 'public/uploads/' . $fileName;
            $organizer->save();
            return $this->setResponse(Response::HTTP_OK, $request->all());
        }
        return $this->setResponse(Response::HTTP_NOT_FOUND, [], 'Organizer not found.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organizer = Organizer::find($id);

        if ($organizer) {
            $hasOwnSportEvent = SportEvent::where('organizer_id', $organizer->id)->first();

            if (!$hasOwnSportEvent) {
                $organizer->delete();

                return $this->setResponse(Response::HTTP_OK, []);
            }

            return $this->setResponse(Response::HTTP_CONFLICT, [], 'Cannot delete organizer because it is used by sport event');
        }

        return $this->setResponse(Response::HTTP_NOT_FOUND, [], 'Organizer not found.');
    }
}
