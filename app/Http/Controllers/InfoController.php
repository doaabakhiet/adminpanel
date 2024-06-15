<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\InfoTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infos = InfoTranslation::currentLocale()->paginate(10);
        return view('adminPanel.infos.index', compact('infos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adminPanel.infos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createSlug($type)
    {
        $slug = Str::slug($type);

        // Check for uniqueness
        $originalSlug = $slug;
        $counter = 1;
        while (Info::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['image']);
            // Generate the slug from the title
            $slug = $this->createSlug($request->type);
            $info = Info::create([
                'type' => $request->type,
                'slug' => $slug,
                'sort' => $request->sort
            ]);
            // Create the translations
            foreach ($request->translations['title'] as $locale => $title) {
                $description = $request->translations['description'][$locale] ?? '';
                $info->info_translations()->create([
                    'locale' => $locale,
                    'title' => $title,
                    'description' => $description,
                ]);
            }
            $info->addMediaFromRequest('image')->toMediaCollection('images');

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
        $info = Info::find($id);
        return view('adminPanel.infos.edit', compact('info'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['image']);

            $info = Info::findOrFail($id);
            $info->slug = '';
            $info->save();
            $slug = $this->createSlug($request->type);
            $info->update([
                'type' => $request->type,
                'slug' => $slug,
                'sort' => $request->sort
            ]);
            foreach ($request->translations['title'] as $locale => $title) {
                $id = $request->translations['id'][$locale] ?? '';
                $description = $request->translations['description'][$locale] ?? '';
                $infoTranslation = $info->info_translations()->where('id', $id)->first();
                if ($infoTranslation) {
                    $infoTranslation->update([
                        'title' => $title,
                        'description' => $description,
                    ]);
                } else {
                    $info->info_translations()->create([
                        'locale' => $locale,
                        'title' => $title,
                        'description' => $description,
                    ]);
                }
            }
            if ($request->hasFile('image')) {
                $info->clearMediaCollection('images');
                $info->addMediaFromRequest('image')->toMediaCollection('images');
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
            $info = Info::find($id);
            InfoTranslation::where('info_id', $info->id)->delete();
            $info->clearMediaCollection('images');
            $info->delete();
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
