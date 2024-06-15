<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use App\Models\Setting;
use App\Models\System;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        // try {
        Setting::updateOrCreate(['key' => 'header_title_ar'], ['value' => $request->header_title_ar]);
        Setting::updateOrCreate(['key' => 'header_title_en'], ['value' => $request->header_title_en]);
        Setting::updateOrCreate(['key' => 'header_des_ar'], ['value' => $request->header_des_ar]);
        Setting::updateOrCreate(['key' => 'header_des_en'], ['value' => $request->header_des_en]);
        Setting::updateOrCreate(['key' => 'address_ar'], ['value' => $request->address_ar]);
        Setting::updateOrCreate(['key' => 'address_en'], ['value' => $request->address_en]);
        Setting::updateOrCreate(['key' => 'business_days_ar'], ['value' => $request->business_days_ar]);
        Setting::updateOrCreate(['key' => 'business_days_en'], ['value' => $request->business_days_en]);
        Setting::updateOrCreate(['key' => 'footer_title_ar'], ['value' => $request->footer_title_ar]);
        Setting::updateOrCreate(['key' => 'footer_title_en'], ['value' => $request->footer_title_en]);
        Setting::updateOrCreate(['key' => 'footer_des_ar'], ['value' => $request->footer_des_ar]);
        Setting::updateOrCreate(['key' => 'footer_des_en'], ['value' => $request->footer_des_en]);
        Setting::updateOrCreate(['key' => 'phone'], ['value' => $request->phone]);
        Setting::updateOrCreate(['key' => 'phone2'], ['value' => $request->phone2]);
        Setting::updateOrCreate(['key' => 'email'], ['value' => $request->email]);
        Setting::updateOrCreate(['key' => 'home_about_us_ar'], ['value' => $request->home_about_us_ar]);
        Setting::updateOrCreate(['key' => 'home_about_us_en'], ['value' => $request->home_about_us_en]);
        Setting::updateOrCreate(['key' => 'watsapp'], ['value' => $request->watsapp]);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filePath =  time() . '_' . $file->getClientOriginalName();
            $filePathDB =  'settings/'.time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('settings', $filePath, 'public');
            Setting::updateOrCreate(['key' => 'logo'], ['value' => $filePathDB]);
        }
        if ($request->hasFile('home_page_image')) {
            $file = $request->file('home_page_image');
            $filePath =  time() . '_' . $file->getClientOriginalName();
            $filePathDB =  'settings/'.time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('settings', $filePath, 'public');
            Setting::updateOrCreate(['key' => 'home_page_image'], ['value' => $filePathDB]);
        }
        if ($request->hasFile('home_about_us_image')) {
            $file = $request->file('home_about_us_image');
            $filePath =  time() . '_' . $file->getClientOriginalName();
            $filePathDB =  'settings/'.time() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('settings', $filePath, 'public');
            Setting::updateOrCreate(['key' => 'home_about_us_image'], ['value' => $filePathDB]);
        }
        // return $request->icons;
        $iconIds = [];
        foreach ($request->icons as $icon) {
            if (!empty($icon['id'])) {
                $existingIcon = Icon::find($icon['id']);
                if ($existingIcon) {
                    $existingIcon->update([
                        'title' => $icon['title'],
                        'link' => $icon['url'],
                    ]);
                    $iconIds[] = $existingIcon->id;
                }
            } else {
                // return 44;
                $newIcon = Icon::create([
                    'title' => $icon['title'],
                    'link' => $icon['url'],
                ]);
                $iconIds[] = $newIcon->id;
            }
        }
        Icon::whereNotIn('id', $iconIds)->delete();
        // Setting::updateOrCreate(
        //     ['key' => 'language'],
        //     ['value' => $request->language]
        // );

        // Artisan::call("optimize:clear");
        $output = [
            'success' => true,
            'msg' => __('lang.success')
        ];
        // } catch (\Exception $e) {
        //     Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
        //     $output = [
        //         'success' => false,
        //         'msg' => __('lang.something_went_wrong')
        //     ];
        // }

        return redirect()->back()->with('status', $output);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
