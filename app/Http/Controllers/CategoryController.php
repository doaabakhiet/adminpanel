<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoryTranslation::currentLocale()->paginate(10);
        return view('adminPanel.categories.index', compact('categories'));
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
            $data=$request->all();
            $category = Category::create();
            foreach ($request->translations['title'] as $locale => $title) {
                $category->category_translations()->create([
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
        $category = Category::find($id);
        return view('adminPanel.categories.edit')->with(compact(
            'category'
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

            $category = Category::findOrFail($id);
            // $category->update($data);
            foreach ($request->translations['title'] as $locale => $title) {
                $id = $request->translations['id'][$locale] ?? '';
                $categoryTranslation = $category->category_translations()->where('id', $id)->first();
                if ($categoryTranslation) {
                    $categoryTranslation->update([
                        'title' => $title,
                    ]);
                } else {
                    $category->category_translations()->create([
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
            $category=Category::find($id);
            CategoryTranslation::where('category_id', $id)->delete();
            $category->delete();
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
