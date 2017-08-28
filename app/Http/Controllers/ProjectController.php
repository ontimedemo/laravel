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
        return $this->apiResponse($project);
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
            return $this->apiError($validator->getMessageBag()->all());
        }

        try {
            $project = Project::create($request->all());
        } catch(\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
        return $this->apiCreated($project);
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Project $project)
    {
        try {
            $project->update($request->all());
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
        return $this->apiResponse($project);
    }

    /**
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Project $project)
    {
        try {
            $project->delete();
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
        return $this->apiDelete('Project deleted');
    }
}
