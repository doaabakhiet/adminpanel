<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = ServiceTranslation::currentLocale()->paginate(10);
        return view('adminPanel.services.index', compact('services'));
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
        $validator = validator($request->all(), [
            'translations' => 'required|array',
            'translations.title' => 'required|string|max:200',
            'translations.description' => 'required|string',
            'image' => 'required|image',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->except(['image']);
            $service = Service::create($data);
            // Create the translations
            foreach ($request->translations['title'] as $locale => $title) {
                $description = $request->translations['description'][$locale] ?? '';
                $service->service_translations()->create([
                    'locale' => $locale,
                    'title' => $title,
                    'description' => $description,
                ]);
            }
            $service->addMediaFromRequest('image')->toMediaCollection('images');

            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            DB::rollback();
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return redirect()->back()->with('status', $output);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::find($id);
        return view('adminPanel.services.edit')->with(compact(
            'service'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        // return $request->file('image');
        // $validator = validator($request->all(), [
        //     'ar' => 'required|array',
        //     'ar.title' => 'required|string|max:200',
        //     'ar.description' => 'required|string',
        //     'image' => 'nullable|image',

        // ]);
        DB::beginTransaction();

        try {
            $data = $request->except(['image']);

            $service = Service::findOrFail($service->id);
            $service->update($data);
            foreach ($request->translations['title'] as $locale => $title) {
                $id = $request->translations['id'][$locale] ?? '';
                $description = $request->translations['description'][$locale] ?? '';
                $serviceTranslation = $service->service_translations()->where('id', $id)->first();
                if ($serviceTranslation) {
                    $serviceTranslation->update([
                        'title' => $title,
                        'description' => $description,
                    ]);
                } else {
                    $service->service_translations()->create([
                        'locale' => $locale,
                        'title' => $title,
                        'description' => $description,
                    ]);
                }
            }
            if ($request->hasFile('image')) {
                $service->clearMediaCollection('images');
                $service->addMediaFromRequest('image')->toMediaCollection('images');
            }

            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            DB::rollback();
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return redirect()->back()->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        try {
            ServiceTranslation::where('service_id', $service->id)->delete();
            $service->clearMediaCollection('images');
            $service->delete();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return redirect()->back()->with('status', $output);
    }
}
