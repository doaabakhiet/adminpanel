<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AreaTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = AreaTranslation::currentLocale()->paginate(10);
        return view('adminPanel.areas.index', compact('areas'));
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
        $request->validate([
            'translations.title.en' => 'required|string|max:255',
            'translations.title.ar' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->all();

            $area = Area::create();
            // Create the translations
            foreach ($request->translations['title'] as $locale => $title) {
                $area->area_translations()->create([
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
        $area = Area::find($id);
        return view('adminPanel.areas.edit')->with(compact(
            'area'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // return $request->all();
        DB::beginTransaction();

        try {

            $area = Area::findOrFail($id);
            $data = $request->all();
            // $area->update($data);
            foreach ($request->translations['title'] as $locale => $title) {
                $id = $request->translations['id'][$locale] ?? '';
                $areaTranslation = $area->area_translations()->where('id', $id)->first();
                if ($areaTranslation) {
                    $areaTranslation->update([
                        'title' => $title,
                    ]);
                } else {
                    $area->area_translations()->create([
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
            $area=Area::find($id);
            AreaTranslation::where('area_id', $area->id)->delete();
            $area->delete();
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
