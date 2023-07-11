<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{

    private $validations = [
        "title"            => "required|string|max:50",
        "creation_date"    => "required|date",
        "last_update"      => "required|date",
        "author"           => "required|string|max:30",
        "collaborators"    => "nullable|string|max:150",
        "description"      => "nullable|string|max:2000",
        "languages"        => "required|string|max:50",
        "link_github"      => "required|string|url|max:150",
        "type_id"          => "required|integer|exists:types,id",
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
        $projects = Project::paginate(4);

        return view('admin.projects.index', compact('projects'));
    }


    public function create()
    {
        $types = Type::All();
        return view('admin.projects.create', compact('types'));
    }


    public function store(Request $request)
    {
        $request->validate($this->validations, $this->validation_messages);

        $data = $request->all();

        // salvare i dati nel db
        $newProject = new Project();
        
        $newProject->title         = $data['title'];
        $newProject->creation_date = $data['creation_date'];
        $newProject->last_update   = $data['last_update'];
        $newProject->author        = $data['author'];
        $newProject->collaborators = $data['collaborators'];
        $newProject->description   = $data['description'];
        $newProject->languages     = $data['languages'];
        $newProject->link_github   = $data['link_github'];
        $newProject->type_id       = $data['type_id'];

        $newProject->save();

        // rotta di tipo get
        return to_route('admin.project.show', ['project' => $newProject]);
    }


    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }


    public function edit(Project $project)
    {
        $types = Type::All();
        return view('admin.projects.edit', compact('project', 'types'));
    }


    public function update(Request $request, Project $project)
    {
        // validare i dati del form
        $request->validate($this->validations, $this->validation_messages);

        $data = $request->all();

        // aggiornare i dati nel db
        $project->title         = $data['title'];
        $project->creation_date = $data['creation_date'];
        $project->last_update   = $data['last_update'];
        $project->author        = $data['author'];
        $project->collaborators = $data['collaborators'];
        $project->description   = $data['description'];
        $project->languages     = $data['languages'];
        $project->link_github   = $data['link_github'];
        $project->type_id       = $data['type_id'];
        
        $project->update();

        // rotta di tipo get
        return to_route('admin.project.show', ['project' => $project->id]);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.project.index')->with('delete_success', $project);
    }

    public function restore($id)
    {
        Project::withTrashed()->where('id', $id)->restore();

        $project = Project::find($id);

        return to_route('admin.project.trashed')->with('restore_success', $project);
    }

    public function trashed()
    {
        $trashedProjects = Project::onlyTrashed()->paginate(5);

        return view('admin.projects.trashed', compact('trashedProjects'));
    }

    public function harddelete($id)
    {
        $project = Project::withTrashed()->find($id);
        $project->forceDelete();

        return to_route('admin.project.trashed')->with('delete_success', $project);
    }
}
