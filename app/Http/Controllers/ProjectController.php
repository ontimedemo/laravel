<?php

namespace App\Http\Controllers;

use App\Model\Project;
use App\Traits\APIResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use APIResponse;
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->apiResponse(Project::all());
    }

    /**
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Project $project)
    {
        return response()->json($project);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|unique:projects'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->all()], 400);
        }
        $project = Project::create($request->all());
        return response()->json($project, APIResponse::$CREATED);
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Project $project)
    {
        $project->update($request);
        return response()->json($project, 200);
    }

    /**
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Project $project)
    {
        $project->delete();
        return response()->json('deleted', 200);
    }
}
