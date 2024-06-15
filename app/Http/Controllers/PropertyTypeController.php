<?php

namespace App\Http\Controllers;

use App\Models\PropertyType;
use App\Models\PropertyTypeTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PropertyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $property_types = PropertyTypeTranslation::currentLocale()->paginate(10);
        return view('adminPanel.property_types.index', compact('property_types'));
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
        DB::beginTransaction();

        try {
        $data = $request->except(['image']);
        $property_type = PropertyType::create($data);
        foreach ($request->translations['title'] as $locale => $title) {
            $property_type->property_type_translations()->create([
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
        $property_type =   PropertyType::find($id);
        return view('adminPanel.property_types.edit')->with(compact(
            'property_type'
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

            $property_type = PropertyType::findOrFail($id);
            $property_type->update($data);
            foreach ($request->translations['title'] as $locale => $title) {
                $id = $request->translations['id'][$locale] ?? '';
                $property_typeTranslation = $property_type->property_type_translations()->where('id', $id)->first();
                if (!empty($property_typeTranslation)) {
                    $property_typeTranslation->update([
                        'title' => $title,
                    ]);
                } else {
                    $property_type->property_type_translations()->create([
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
            $property_type=PropertyType::find($id);
            PropertyTypeTranslation::where('property_type_id',$id)->delete();
            $property_type->delete();
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
