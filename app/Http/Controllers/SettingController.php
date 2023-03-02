<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    //

    public function index()
    {
        $settings = Setting::orderBy('id')->paginate(5);
        return view('settings.index', compact('settings'));
    }

    public function edit(Setting $setting)
    {
        $setting = Setting::where('id', $setting->id)->get;
        return view('settings.edit', compact("setting"));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'value' => 'required',
        ]);

        $setting = Setting::where('name', $request->name)->first();
        if (!$setting) {
            $setting = new Setting();
        }
        $setting->name = $request->name;
        $setting->value = $request->value;
        $setting->save();

        if ($setting) {
            notify()->success($request->name . ', Setting created successfully.');
        } else {
            notify()->error($request->name . ', Setting created failed.');
        }
        return redirect()->back();
    }

    public function update(Setting $setting, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'value' => 'required',
        ]);

        $setting->update($request->only('name', 'value'));

        return redirect()->route('settings.index')
            ->with('success','Setting updated successfully');
    }
}
