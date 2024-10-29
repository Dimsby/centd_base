<?php

namespace App\Http\Controllers;

use App\Archive\Person;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->flash();

        $persons = Person::where(function($query) use ($request) {
            if ($year = $request->input('year'))
                $query->where('origin_year', $year);

            if ($foundat = $request->input('foundat'))
                $query->whereYear('found_date', $foundat);

            if ($name = $request->input('name'))
                $query->where('first_name', 'like', $name. '%');

            if ($surname = $request->input('surname'))
                $query->where('last_name', 'like', $surname. '%');

            $query->where('is_published', 1);

        })->simplePaginate(20);

        $viewData = ['persons' => $persons];

        return view('home', $viewData);
    }

    public function search($id)
    {
        $person = Person::with(['camoLink', 'memorialLink', 'nameSources', 'immortalization'])->find($id);
        if ($person) {
            $nameSources = $person->nameSources()->with('files')->get();
            return view('publicsearch.person', ['person' => $person, 'nameSources' => $nameSources]);
        } else
            abort(404);
    }

    public function file($id)
    {
        $file = \App\Archive\PersonFile::find($id);
        if (!$file)
            abort(404);

        $filePath = public_path().'/files/uploads/'.$file->filename;
        if (!is_file($filePath))
            abort(404);

        return response()->file(public_path().'/files/uploads/'.$file->filename);
    }
}
