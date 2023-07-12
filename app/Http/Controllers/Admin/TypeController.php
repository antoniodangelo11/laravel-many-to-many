<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;


class TypeController extends Controller
{
    private $validations = [
        "name"            => "required|string|max:50",
        "description"     => "required|string|max:2000",
    ];

    private $validation_messages = [
        'required'  => 'Il campo :attribute è obbligatorio',
        'min'       => 'Il campo :attribute deve avere almeno :min caratteri',
        'max'       => 'Il campo :attribute non può superare i :max caratteri',
        'url'       => 'Il campo deve essere un url valido',
        'exists'    => 'Valore non valido'
    ];

    public function index()
    {
        $types = Type::all();

        return view('admin.types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.types.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->validations, $this->validation_messages);

        $data = $request->all();

        // salvare i dati nel db
        $newType = new Type();

        $newType->name          = $data['name'];
        $newType->description   = $data['description'];

        $newType->save();

        // rotta di tipo get
        return to_route('admin.type.show', ['type' => $newType]);
    }

    public function show(Type $type)
    {
        return view('admin.types.show', compact('type'));
    }

    public function edit(Type $type)
    {
        return view('admin.types.edit', compact('type'));
    }

    public function update(Request $request, Type $type)
    {
        // validare i dati del form
        $request->validate($this->validations, $this->validation_messages);

        $data = $request->all();

        // aggiornare i dati nel db
        $type->name         = $data['name'];
        $type->description  = $data['description'];

        $type->update();

        // rotta di tipo get
        return to_route('admin.type.show', ['type' => $type->id]);
    }

    public function destroy(Type $type)
    {

        foreach ($type->projects as $project) {
            $project->type_id = 1;
            $project->update();
        }

        $type->delete();

        return to_route('admin.type.index')->with('delete_success', $type);
    }
}
