<?php

namespace App\Http\Controllers;

use App\Model\Project;
use App\Traits\APIResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends BaseController
{
    use APIResponse;

    /**
     * Returns projects associated with the current user
     * @return JsonResponse
     */
    public function index(): JsonResponse
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
     * Return the project with the supplied id
     * @param int $project
     * @return JsonResponse
     */
    public function get(int $project): JsonResponse
    {
        try {
            $project = Project::findOrFail($project);
            return $this->apiResponse($project);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * Create a new project
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
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
     * Update a current project
     * @param Request $request
     * @param int $project
     * @return JsonResponse
     */
    public function update(Request $request, int $project): JsonResponse
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
     * Delete a project with the supplied id
     * @param int $project
     * @return JsonResponse
     */
    public function delete(int $project): JsonResponse
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
