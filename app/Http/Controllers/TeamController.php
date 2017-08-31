<?php

namespace App\Http\Controllers;

use App\Model\Team;
use App\Traits\APIResponse;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    use APIResponse;

    /**
     * @param int $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $team)
    {
        try {
            $team = Team::findOrFail($team);
            return $this->apiResponse($team);
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
        try {
            $team = Team::create($request->all());
            return $this->apiResponse($team);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * @param int $team
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $team, Request $request)
    {
        //Todo: Make sure that the user is the owner
        try {
            $team = Team::findOrFail($team);
            $team->update($request->all());
            return $this->apiResponse($team);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * @param int $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $team)
    {
        try {
            $team = Team::findOrFail($team);
            $team->delete();
            return $this->apiDelete('Team deleted');
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }
}
