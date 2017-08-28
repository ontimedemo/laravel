<?php

namespace App\Http\Controllers;

use App\Model\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Project::all());
    }

    public function get(Project $project)
    {
        return response()->json($project);
    }

    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|unique:projects'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->all()], 400);
        }
        $project = Project::create($request->all());
        return response()->json($project, 201);
    }

    public function update(Request $request, Project $project)
    {
        $project->update($request);
        return response()->json($project, 200);
    }
}
