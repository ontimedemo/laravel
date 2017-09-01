<?php

namespace App\Http\Controllers;

use App\Model\Team;
use App\Traits\APIResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamController extends BaseController
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
            $validator = \Validator::make($request->all(), [
               'name' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->apiError($validator->getMessageBag()->all());
            }
            $ownerId = $this->getUser()->id;
            $data = array_merge($request->all(), ['owner_id' => $ownerId]);
            $team = Team::create($data);
            $team->users()->attach($ownerId);
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
        try {
            $team = Team::findOrFail($team);
            if ($team->owner_id !== $this->getUser()->id) {
                return $this->apiError('User is not the owner of the team');
            }
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

    /**
     * @param int $team
     * @param int $user
     * @return JsonResponse
     */
    public function addUser(int $team, int $user): JsonResponse
    {
        try {
            $team = Team::findOrFail($team);
            if ($team->owner()->get('id') !== $this->getUser()->id) {
                return $this->apiError('User is not the owner of the team');
            }
            $team->users()->attach($user);
            return $this->apiResponse(['message' => 'User added to the team']);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }
}
