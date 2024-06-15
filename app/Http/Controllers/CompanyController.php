<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = CompanyTranslation::currentLocale()->paginate(10);
        return view('adminPanel.companies.index', compact('companies'));
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
        $company = Company::create($data);
        // Create the translations
        foreach ($request->translations['title'] as $locale => $title) {
            $description = $request->translations['description'][$locale] ?? '';
            CompanyTranslation::create([
                'company_id' => $company->id,
                'locale' => $locale,
                'title' => $title,
                'description' => $description,
            ]);
        }
        if ($request->hasFile('image')) {
            $company->addMediaFromRequest('image')->toMediaCollection('images');
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
        $company = Company::find($id);
        return view('adminPanel.companies.edit')->with(compact(
            'company'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

            $company = Company::findOrFail($id);
            $company->update($data);
            foreach ($request->translations['title'] as $locale => $title) {
                $id = $request->translations['id'][$locale] ?? '';
                $description = $request->translations['description'][$locale] ?? '';
                $companyTranslation = $company->company_translations()->where('id', $id)->first();
                if ($companyTranslation) {
                    $companyTranslation->update([
                        'title' => $title,
                        'description' => $description,
                    ]);
                } else {
                    $company->company_translations()->create([
                        'locale' => $locale,
                        'title' => $title,
                        'description' => $description,
                    ]);
                }
            }
            if ($request->hasFile('image')) {
                $company->clearMediaCollection('images');
                $company->addMediaFromRequest('image')->toMediaCollection('images');
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
            $company=Company::find($id);
            CompanyTranslation::where('company_id', $id)->delete();
            $company->clearMediaCollection('images');
            $company->delete();
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
