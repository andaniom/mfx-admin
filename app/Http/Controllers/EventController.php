<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use function Sodium\add;

class EventController extends Controller
{

    public function index()
    {
        $events = DB::table('event')->paginate(5);
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
        error_log('Some message here.');
//        $this->validate($request, [
//            'photo' => 'required|image|mimes:png,jpg,jpeg',
//            'name' => 'required',
//            'date' => 'required',
//            'description' => 'required',
//            'contentTiny' => 'required',
//        ]);
        error_log('validated');

        $paths = [];
        //upload image
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $path = $file->storeAs('public/events', $file->hashName());
                error_log($path);
                $paths[] = $path;
            }
        } else {
            error_log('no file');
        }
        error_log('upload image');
//        $image = $request->file('photo');
//        $image->storeAs('public/events', $image->hashName());

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
        $event = DB::table('event')->where('id', '=', $key)->first();
        return view('event.event-detail', ['event' => $event]);
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
