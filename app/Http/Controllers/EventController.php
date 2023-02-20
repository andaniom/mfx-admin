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
        return view('events.index', ['events' => $events]);
    }

    public function create()
    {
        return view('events.form');
    }

    public function edit(Event $event)
    {
        $event = $event;
        return view('events.form', compact('event'));
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'files' => 'required',
            'name' => 'required',
            'date' => 'required',
            'description' => 'required',
            'contentTiny' => 'required',
        ]);

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
            notify()->success($request->name . ', Event created successfully.');
            return redirect()->route('events.index');
        } else {
            notify()->error($request->name . ', Event created failed.');
            return redirect()->route('events.index');
        }
    }

    public function show(Request $request, $key)
    {
        $event = Event::find($key);
        $photos = explode(", ", $event->photo);
        $event->photo = $photos;
        return view('events.show', ['event' => $event]);
    }

    public function destroy($key)
    {
        $event = Event::find($key);
        $event->delete();
        if ($event) {
            return redirect()->route('events.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            return redirect()->route('events.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }

    public function update(Request $request, Event $event)
    {
        $this->validate($request, [
            'files' => 'required',
            'name' => 'required',
            'date' => 'required',
            'description' => 'required',
            'contentTiny' => 'required',
        ]);

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

        $event->photo = implode(', ', $paths);
        $event->name = $request->name;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->content = $content;
        $event->save();

        if ($event) {
            notify()->success($request->name . ', Event created successfully.');
            return redirect()->route('events.index');
        } else {
            notify()->error($request->name . ', Event created failed.');
            return redirect()->route('events.index');
        }
    }
}
