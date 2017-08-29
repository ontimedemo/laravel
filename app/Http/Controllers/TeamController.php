<?php

namespace App\Http\Controllers;

use App\Model\Team;
use App\Traits\APIResponse;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    use APIResponse;

    /**
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Team $team)
    {
        try {
            $owner = $team->owner();
            $team = $team->makeHidden('owner_id')->toArray();
            $team['owner'] = $owner->get();
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
     * @param Team $team
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Team $team, Request $request)
    {
        //Todo: Make sure that the user is the owner
        try {
            $team->update($request->all());
            return $this->apiResponse($team);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(team $team)
    {
        try {
            $team->delete();
            return $this->apiDelete('Team deleted');
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }
}