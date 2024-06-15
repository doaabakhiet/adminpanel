<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdAttribute;
use App\Models\AdTranslation;
use App\Models\AttributeTranslation;
use App\Models\CategoryTranslation;
use App\Models\CityTranslation;
use App\Models\CompanyTranslation;
use App\Models\Neighborhood;
use App\Models\NeighborhoodTranslation;
use App\Models\PropertyTypeTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = AdTranslation::currentLocale()->paginate(10);
        return view('adminPanel.ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = CityTranslation::currentLocale()->pluck('title', 'city_id');
        $neighborhoods = NeighborhoodTranslation::currentLocale()->pluck('title', 'neighborhood_id');
        $attributes = AttributeTranslation::currentLocale()->pluck('title', 'attribute_id');
        $property_types = PropertyTypeTranslation::currentLocale()->pluck('title', 'property_type_id');
        $companies = CompanyTranslation::currentLocale()->pluck('title', 'company_id');
        $categories = CategoryTranslation::currentLocale()->pluck('title', 'category_id');
        $attributesData = AttributeTranslation::currentLocale()->get();
        return view('adminPanel.ads.create', compact(
            'cities',
            'neighborhoods',
            'attributes',
            'attributesData',
            'property_types',
            'companies',
            'categories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        DB::beginTransaction();

        try {
            $data = $request->except(['images', 'min_image', 'attributes']);
            $data['slug'] = Str::slug($request->translations['title']['ar']);
            // return  $data['slug'];
            $ad = Ad::create($data);
            foreach ($request->translations['title'] as $locale => $title) {
                $description = $request->translations['description'][$locale] ?? '';
                $ad->ad_translations()->create([
                    'locale' => $locale,
                    'title' => $title,
                    'description' => $description,
                ]);
            }
            if ($request->hasFile('min_image')) {
                $ad->addMediaFromRequest('min_image')->toMediaCollection('min_image');
            }
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $ad->addMedia($image)->toMediaCollection('images');
                }
            }
            if ($request->has('attributes')) {
                foreach ($request->get('attributes') as $attribute => $value) {
                    if ($value != null) {
                        $ad->attributes()->attach($attribute, ['value' => $value]);
                    }
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

        $ad = Ad::find($id);
        // return in_array(4, $ad->attributes->pluck('pivot.attribute_id')->toArray());
        $cities = CityTranslation::currentLocale()->pluck('title', 'city_id');
        $neighborhoods = NeighborhoodTranslation::currentLocale()->pluck('title', 'neighborhood_id');
        $attributes = AttributeTranslation::currentLocale()->pluck('title', 'attribute_id');
        $property_types = PropertyTypeTranslation::currentLocale()->pluck('title', 'property_type_id');
        $companies = CompanyTranslation::currentLocale()->pluck('title', 'company_id');
        $categories = CategoryTranslation::currentLocale()->pluck('title', 'category_id');
        $attributesData = AttributeTranslation::currentLocale()->get();
        return view('adminPanel.ads.edit', compact(
            'ad',
            'cities',
            'neighborhoods',
            'attributes',
            'attributesData',
            'property_types',
            'companies',
            'categories'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // return $request->get('attributes');
        DB::beginTransaction();

        try {
            $data = $request->except(['images', 'min_image', 'attributes']);
            $data['slug'] = Str::slug($request->translations['title']['ar']);
            // return  $data['slug'];
            $ad = Ad::find($id);
            $ad->update($data);
            foreach ($request->translations['title'] as $locale => $title) {
                $id = $request->translations['id'][$locale] ?? '';
                $description = $request->translations['description'][$locale] ?? '';
                $adTranslation = $ad->ad_translations()->where('id', $id)->first();
                if ($adTranslation) {
                    $adTranslation->update([
                        'title' => $title,
                        'description' => $description,
                    ]);
                } else {
                    $ad->ad_translations()->create([
                        'locale' => $locale,
                        'title' => $title,
                        'description' => $description,
                    ]);
                }
            }
            if ($request->hasFile('min_image')) {
                $ad->clearMediaCollection('min_image');
                $ad->addMediaFromRequest('min_image')->toMediaCollection('min_image');
            }
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $ad->clearMediaCollection('images');
                    $ad->addMedia($image)->toMediaCollection('images');
                }
            }
            if ($request->has('attributes')) {
                $attributes = $request->get('attributes');
        
             
                $syncData = [];
                foreach ($attributes as $attributeId => $value) {
                    if ($value !== null) {
                        $syncData[$attributeId] = ['value' => $value];
                    }
                }
        
                $ad->attributes()->sync($syncData);
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
            $ad = Ad::find($id);
            AdTranslation::where('ad_id', $id)->delete();
            AdAttribute::where('attribute_id', $id)->delete();
            $ad->clearMediaCollection('images');
            $ad->clearMediaCollection('min_images');
            $ad->delete();
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
