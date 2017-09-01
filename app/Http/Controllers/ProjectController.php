<?php

namespace App\Http\Controllers;

use App\Model\Project;
use App\Traits\APIResponse;
use Illuminate\Http\Request;

class ProjectController extends BaseController
{
    use APIResponse;
    //TODO: Add in proper security once projects are tied to users
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $projects = Project::whereIn('team_id', $this->getUserTeams()->pluck('teams.id'))
                ->orWhere('user_id', '=', $this->getUser()->id)->get();
            return $this->apiResponse($projects);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * @param int $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $project)
    {
        try {
            $project = Project::findOrFail($project);
            return $this->apiResponse($project);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
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
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
        return $this->apiCreated($project);
    }

    /**
     * @param Request $request
     * @param int $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $project)
    {
        try {
            $project = Project::findOrFail($project);
            $project->update($request->all());
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
        return $this->apiResponse($project);
    }

    /**
     * @param int $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $project)
    {
        try {
            $project = Project::findOrFail($project);
            $project->delete();
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
        return $this->apiDelete('Project deleted');
    }
}
