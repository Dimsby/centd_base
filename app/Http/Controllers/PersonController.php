<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use App\Archive\Person;

class PersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->flash();

        $persons = Person::where(function($query) use ($request) {

            if ($year = $request->input('year'))
                $query->where('origin_year', $year);
            if ($foundat = $request->input('foundat'))
                $query->whereYear('found_date', $foundat);
            if ($name = $request->input('name'))
                $query->where('first_name', 'like', $name. '%')->orWhere('last_name', 'like', $name. '%');

            if (Auth::user()->isAdmin())
            {
                if ($user = $request->input('user'))
                    $query->where('author_id', $user);

                if ($request->input('filter_is_published') != null)
                    $query->where('is_published', $request->input('filter_is_published'));
            }

        })->paginate(100);

        $viewData = ['persons' => $persons];

        if (Auth::user()->isAdmin())
        {
            $viewData['users'] = ['' => '-'] + \App\User::all()->pluck('name', 'id')->toArray();
        }

        return view('person.index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('person.form', ['nameSourceTypes' => \App\Archive\NameSource::getTypes()->toArray()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Person::$rules);
        $person = Person::create($request->except(['_token','camolink', 'memoriallink', 'source', 'sourceUploadFiles', 'sourceDeletes', 'exhumation', 'immortalization']));

        // 1-1 Информация в ЦАМО
        if (@$request->input('camolink')['available']) {
            $person->camoLink()->save(new \App\Archive\CamoLink($request->input('camolink')));
        }

        // 1-1 ОБД Мемориал
        if (@$request->input('memoriallink')['available']) {
            $person->memorialLink()->save(new \App\Archive\MemorialLink($request->input('memoriallink')));
        }

        if (@$request->input('exhumation') && array_filter($request->input('exhumation'))) {
            $person->exhumation()->save(new \App\Archive\Exhumation($request->input('exhumation')));
        }

        if (@$request->input('immortalization') && array_filter($request->input('immortalization'))) {
            $person->exhumation()->save(new \App\Archive\Immortalization($request->input('immortalization')));
        }

        // 1-много Сведения об установленном имени
        if (@$request->input('source')) {
            $sourceData = json_decode($request->input('source'), true);
            if ($sourceData)
                $person->nameSources()->createMany($sourceData);
        }

        $this->saveNameSources($request, $person);

        return response()->json( ['success'=> true, 'redirect' => route('person.index')] );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $person = Person::with(['camoLink', 'memorialLink', 'nameSources'])->find($id);
        return view('person.form', ['person' => $person, 'nameSourceTypes' => \App\Archive\NameSource::getTypes()->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(Person::$rules);

        $person = Person::find($id);
        $person->update($request->except(['_token', 'camolink', 'memoriallink', 'source', 'sourceUploadFiles', 'sourceDeletes', 'exhumation', 'immortalization']));

        if (@$request->input('camolink')['available']) {
            $data = $request->input('camolink');
            unset($data['available']);
            $person->camoLink ? $person->camoLink()->update($data) : $person->camoLink()->save(new \App\Archive\CamoLink($data));
        } else
            $person->camoLink()->delete();

        if (@$request->input('memoriallink')['available']) {
            $data = $request->input('memoriallink');
            unset($data['available']);
            $person->memorialLink ? $person->memorialLink()->update($data) : $person->memorialLink()->save(new \App\Archive\MemorialLink($data));
        } else
            $person->memorialLink()->delete();

        if (@$request->input('exhumation') && $data = array_filter($request->input('exhumation'))) {
            $data = $request->input('exhumation');
            $person->exhumation ? $person->exhumation()->update($data) : $person->exhumation()->save(new \App\Archive\Exhumation($data));
        } else
            $person->exhumation()->delete();

        if (@$request->input('immortalization') && $data = array_filter($request->input('immortalization'))) {
            $data = $request->input('immortalization');
            $person->immortalization ? $person->immortalization()->update($data) : $person->immortalization()->save(new \App\Archive\Immortalization($data));
        } else
            $person->immortalization()->delete();

        $this->saveNameSources($request, $person);

        return response()->json(['success'=> true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Person::find($id)->delete();

        return response()->json(['success'=> true]);
    }

    public function updPublished(Request $request, $id)
    {
        if (!$id)
            return response()->json(['success'=> false]);

        Person::find($id)->update(['is_published' => $request->is_published]);

        return response()->json(['success'=> true]);
    }

    public function displayImage($filename)
    {
        return \Storage::disk('uploads')->download($filename);// storage_public('files/uploads' . $filename);
    }

    private function saveNameSources(Request $request, Person $person)
    {
        $valid_extensions = array("jpg","jpeg","png","pdf");

        if (@$request->input('source') && $sourceData = json_decode($request->input('source'), true)) {
            $person->nameSources()->delete();

            $files = @$request->sourceUploadFiles;

            foreach ($sourceData as $i => $sd) {

                $sourceDataObj = new \App\Archive\NameSource($sd);
                $person->nameSources()->save($sourceDataObj);

                if (isset($files[$i])) {

                    foreach ($files[$i] as $key => $file) {

                        if(!in_array(strtolower($file->getClientOriginalExtension()), $valid_extensions))
                            continue;

                        $filename = hash('sha256', time() . $i . $key) . '.' . $file->getClientOriginalExtension();
                        if(\Storage::disk('uploads')->put($filename,  \File::get($file))) {
                            \App\Archive\PersonFile::create(['type' => 2, 'related_id' => $sourceDataObj->id, 'filename' => $filename, 'ext' => $file->getClientOriginalExtension()]);
                        }

                    }
                }

            }

            if (@$request->input('sourceDeletes') && $deletes =  json_decode($request->input('sourceDeletes'), true)) {
                foreach ($deletes as $deleteFileId) {
                    $file = \App\Archive\PersonFile::find($deleteFileId);
                    if ($file->filename) {
                        \Storage::disk('uploads')->delete($file->filename);
                    }
                    $file->delete();
                }
            }

        } else
            $person->nameSources()->delete();
    }

}
