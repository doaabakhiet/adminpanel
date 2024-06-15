<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Neighborhood;
use App\Models\NeighborhoodTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NeighborhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $neighborhoods = NeighborhoodTranslation::currentLocale()->paginate(10);
        $cities = CityTranslation::currentLocale()->pluck('title', 'city_id');
        return view('adminPanel.neighborhoods.index', compact('neighborhoods','cities'));
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
        ]);

        DB::beginTransaction();

        try {
            $data = $request->all();
            $neighborhood = Neighborhood::create([
                'city_id'=>$request->city_id
            ]);
            foreach ($request->translations['title'] as $locale => $title) {
                $neighborhood->neighborhood_translations()->create([
                    'locale' => $locale,
                    'title' => $title,
                ]);
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
        $neighborhood = Neighborhood::find($id);
        $cities = CityTranslation::currentLocale()->pluck('title', 'city_id');
        return view('adminPanel.neighborhoods.edit')->with(compact(
            'neighborhood','cities'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();

            $neighborhood = Neighborhood::findOrFail($id);
            $neighborhood->update([
                'city_id'=>$request->city_id
            ]);
            foreach ($request->translations['title'] as $locale => $title) {
                $id = $request->translations['id'][$locale] ?? '';
                $neighborhoodTranslation = $neighborhood->neighborhood_translations()->where('id', $id)->first();
                if (!empty($neighborhoodTranslation)) {
                    $neighborhoodTranslation->update([
                        'title' => $title,
                    ]);
                } else {
                    $neighborhood->neighborhood_translations()->create([
                        'locale' => $locale,
                        'title' => $title,
                    ]);
                }
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
            $neighborhood=Neighborhood::find($id);
            NeighborhoodTranslation::where('neighborhood_id', $id)->delete();
            $neighborhood->delete();
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
