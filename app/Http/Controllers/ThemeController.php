<?php

namespace App\Http\Controllers;

use App\Theme;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\ThemeRequest;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $themes = Theme::all();

        return view('admin.themes.index', compact('themes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $theme = new Theme;

        return view('admin.themes.create', compact('theme'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThemeRequest $request)
    {
        $theme = Theme::create($request->all());
        $this->slug($theme);


        return redirect('themes')->with('message', 'Theme ajoutée avec succès !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404, 'Sorry');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $theme = Theme::find($id);

        return view('admin.themes.edit', compact('theme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ThemeRequest $request, $id)
    {
        $theme = Theme::findOrFail($id);
        $theme->update($request->all());
        $this->slug($theme);

        return redirect('themes')->with('message', 'Theme modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $theme = Theme::findOrFail($id);

        // $title = $Theme->Theme;
        $theme->delete();

        return back()/*->with(['message' => sprintf('La Theme %s à été supprimée !', $title)])*/
            ;
    }

    private function slug(Theme $theme)
    {
        $theme->slug = str_slug($theme->name, '-');
        $theme->save();
    }

}
