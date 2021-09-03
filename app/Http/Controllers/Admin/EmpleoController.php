<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmpleoRequest;
use App\Http\Requests\StoreEmpleoRequest;
use App\Http\Requests\UpdateEmpleoRequest;
use App\Models\Empleo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmpleoController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('empleo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empleos = Empleo::all();

        return view('admin.empleos.index', compact('empleos'));
    }

    public function create()
    {
        abort_if(Gate::denies('empleo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.empleos.create');
    }

    public function store(StoreEmpleoRequest $request)
    {
        $empleo = Empleo::create($request->all());

        return redirect()->route('admin.empleos.index');
    }

    public function edit(Empleo $empleo)
    {
        abort_if(Gate::denies('empleo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.empleos.edit', compact('empleo'));
    }

    public function update(UpdateEmpleoRequest $request, Empleo $empleo)
    {
        $empleo->update($request->all());

        return redirect()->route('admin.empleos.index');
    }

    public function show(Empleo $empleo)
    {
        abort_if(Gate::denies('empleo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.empleos.show', compact('empleo'));
    }

    public function destroy(Empleo $empleo)
    {
        abort_if(Gate::denies('empleo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empleo->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmpleoRequest $request)
    {
        Empleo::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
