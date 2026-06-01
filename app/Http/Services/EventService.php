<?php

namespace App\Http\Services;
use App\Models\Event;

class EventService
{
    public function index(){
        $events = Event::with('category')->get();
        return $events;
    }

    public function show($id){
        $event = Event::where('id', $id)->first();
        if(!$event){
            return null;
        }
        return $event;
    }

    public function store($data){
        $event = Event::create($data);
        return $event;
    }

    public function update($id, $data){
        $event = $this->show($id);
        $event->update($data);
        return $event;
    }

    public function destroy($id){
        $event = $this->show($id);
        if(!$event){
            return null;
        }
        $event->delete();
        return $event;
    }

}