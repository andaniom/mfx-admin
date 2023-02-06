<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{

    public function index()
    {
        $events = Event::paginate(5);
        foreach ($events as $event) {
            $photos = explode(", ", $event->photo);
            $event->photo = $photos;
        }
        return view('event.events', ['events' => $events]);
    }

    public function create()
    {
        return view('event.event-create');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request)
    {
//        $this->validate($request, [
//            'photo' => 'required|image|mimes:png,jpg,jpeg',
//            'name' => 'required',
//            'date' => 'required',
//            'description' => 'required',
//            'contentTiny' => 'required',
//        ]);

        $paths = [];
        //upload image
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $file->storeAs('public/events', $file->hashName());
                $paths[] = $file->hashName();
            }
        }

        $content = $request->contentTiny;

        $event = Event::create([
            'photo' => implode(', ', $paths),
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'content' => $content
        ]);

        if ($event) {
            return redirect()->route('events.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('events.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function detail(Request $request, $key)
    {
        $event = Event::find($key);
        $photos = explode(", ", $event->photo);
        $event->photo = $photos;
        return view('event.event-detail', ['event' => $event]);
    }

    public function delete($key)
    {
        $event = Event::find($key);
        $event->delete();
        if ($event) {
            return redirect()->route('events.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            return redirect()->route('events.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
}
