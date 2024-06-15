<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use App\Models\ObjectiveTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objectives= ObjectiveTranslation::currentLocale()->paginate(10);
        return view('adminPanel.objectives.index', compact('objectives'));
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
              $objective = Objective::create();
              foreach ($request->translations['title'] as $locale => $title) {
                  $objective->objective_translations()->create([
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
        $objective = Objective::find($id);
        return view('adminPanel.objectives.edit')->with(compact(
            'objective'
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

            $objective = Objective::findOrFail($id);
            // $objective->update($data);
            foreach ($request->translations['title'] as $locale => $title) {
                $id = $request->translations['id'][$locale] ?? '';
                $objectiveTranslation = $objective->objective_translations()->where('id', $id)->first();
                if (!empty($objectiveTranslation)) {
                    $objectiveTranslation->update([
                        'title' => $title,
                    ]);
                } else {
                    $objective->objective_translations()->create([
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
            $objective=Objective::find($id);
            ObjectiveTranslation::where('objective_id', $id)->delete();
            $objective->delete();
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
