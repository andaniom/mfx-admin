<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{

    public function index()
    {
        $events = DB::table('event')->paginate(10);
        return view('events', ['events' => $events]);
    }

    public function create()
    {
        return view('event-create');
    }

    public function store(Request $request)
    {
        error_log('Some message here.');
        $this->validate($request, [
            'photo' => 'required|image|mimes:png,jpg,jpeg',
            'name' => 'required',
            'date' => 'required',
            'description' => 'required',
            'contentTiny' => 'required',
        ]);

        //upload image
        $image = $request->file('photo');
        $image->storeAs('public/events', $image->hashName());

        $content = $request->contentTiny;

        $event = Event::create([
            'photo' => $image->hashName(),
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
        $event = DB::table('event')->where('id', '=', $key)->first();
        return view('event-detail', ['event' => $event]);
    }

    public function delete($key)
    {
        $event = DB::table('event')->delete($key);
        if ($event) {
            return redirect()->route('events.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            return redirect()->route('events.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
}
