<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{

    use AuthorizesRequests;
    
    public function index(Request $request)
    {
        return $request->user()->projects()->with('client')->get();
    }

    public function store(ProjectRequest $request)
    {
        $project = $request->user()->projects()->create($request->validated());
        return response()->json($project, 201);
    }

    public function show(Request $request, Project $project)
    {
        $this->authorize('view', $project);
        return response()->json($project->load('client'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $project->update($request->validated());
        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return response()->json(['message' => 'Project deleted']);
    }

}
