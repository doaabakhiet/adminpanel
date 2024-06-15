<?php

namespace App\Http\Controllers;

use App\Models\AreaTranslation;
use App\Models\City;
use App\Models\CityTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\returnSelf;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = CityTranslation::currentLocale()->paginate(10);
        $areas = AreaTranslation::currentLocale()->pluck('title', 'area_id');
        return view('adminPanel.cities.index', compact('cities', 'areas'));
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
        $request->validate([
            'translations.title.en' => 'required|string|max:255',
            'translations.title.ar' => 'required|string|max:255',
            // 'image' => 'required|image',
            'area_id' => 'required',
        ]);

        DB::beginTransaction();

        try {
        $data = $request->except(['image']);
        $city = City::create($data);
        // Create the translations
        foreach ($request->translations['title'] as $locale => $title) {
           
            CityTranslation::create([
                'city_id' => $city->id,
                'locale' => $locale,
                'title' => $title,
            ]);
        }
        if ($request->hasFile('image')) {
            $city->addMediaFromRequest('image')->toMediaCollection('images');
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
        $city = City::find($id);
        $areas = AreaTranslation::currentLocale()->pluck('title', 'area_id');

        return view('adminPanel.cities.edit')->with(compact(
            'city','areas'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['image']);

            $city = City::findOrFail($id);
            $city->update($data);
            foreach ($request->translations['title'] as $locale => $title) {
                $id = $request->translations['id'][$locale] ?? '';
                $description = $request->translations['description'][$locale] ?? '';
                $cityTranslation = $city->city_translations()->where('id', $id)->first();
                if ($cityTranslation) {
                    $cityTranslation->update([
                        'title' => $title,
                    ]);
                } else {
                    $city->city_translations()->create([
                        'locale' => $locale,
                        'title' => $title,
                    ]);
                }
            }
            if ($request->hasFile('image')) {
                $city->clearMediaCollection('images');
                $city->addMediaFromRequest('image')->toMediaCollection('images');
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
    public function destroy(string $id)
    {
        try {
            $city=City::find($id);
            CityTranslation::where('city_id', $id)->delete();
            $city->clearMediaCollection('images');
            $city->delete();
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
