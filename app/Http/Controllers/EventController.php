<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditEventRequest;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Http\Services\EventService;
use App\Http\Services\MediaService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventService;
    protected $mediaService;
    public function __construct(EventService $eventService, MediaService $mediaService)
    {
        $this->eventService = $eventService;
        $this->mediaService = $mediaService;
    }
    
    private function getEvent($id){
        $event = $this->eventService->show($id);
        if(!$event){
            return response()->json([
                "success" => false,
                "message" => "Event not found"
            ],404);
        }
        return $event;
    }

    public function index(){
        $events = $this->eventService->index();
        return response()->json([
            "success" => true,
            "data" => EventResource::collection($events)    
        ]);
    }
    public function show($id){
        $event = $this->getEvent($id);

        return response()->json([
            "success" => true,
            "data" => new EventResource($event)
        ]);
        
    }

    public function store(EventRequest $request){
        $event = $this->eventService->store($request->validated());
        if($request->hasFile('images')) {
            foreach($request->file('images') as $file){
                $this->mediaService->CreateMedia($event, $file, 'events');
            }
        }
        return response()->json([
            "success" => true,
            "data" => "Event created successfully"    
        ],201);
    }

    public function update(EditEventRequest $request, $id){
        $event = $this->getEvent($id);
        $this->eventService->update($event->id, $request->validated());
        if($request->hasFile('images')) {
            $this->mediaService->deleteMedia($event, 'events');
            foreach($request->file('images') as $file){
                $this->mediaService->editMedia($event, $file, 'events');
            }
        }
        return response()->json([
            "success" => true,
            "data" => "Event updated successfully"   
        ]);
    }

    public function destroy($id){
        $event = $this->getEvent($id);
        $this->eventService->destroy($event->id);
        $this->mediaService->deleteMedia($event, 'events');
        if(!$event){
            return response()->json([
                "success" => false,
                "message" => "Event not found"
            ],404);
        }
        return response()->json([
            "success" => true,
            "message" => "Event deleted successfully"  
        ]);
    }
}
