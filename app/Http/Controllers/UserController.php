<?php
/**
 * Created by PhpStorm.
 * User: sean
 * Date: 8/28/17
 * Time: 3:54 PM
 */

namespace App\Http\Controllers;

use App\Model\User;
use App\Traits\APIResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    use APIResponse;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentUser(): JsonResponse
    {
        try {
            $user = $this->getUser();
            return $this->apiResponse(array_merge($user->toArray(), ['teams' => $user->teams()->get()]));
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * @param int $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $user): JsonResponse
    {
        try {
            $user = User::findOrFail($user);
            return $this->apiResponse($user->makeHidden(['date_updated']));
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $validator = \Validator::make($request->all(), [
           'email' => 'required|unique:users|email',
           'firebase_uid' => 'required|unique:users'
        ]);

        if ($validator->fails()) {
            return $this->apiError($validator->getMessageBag()->all());
        }

        try {
            $user = User::create($request->all());
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
        return $this->apiCreated($user);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCurrentUser(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $user->update($request->all());
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
        return $this->apiResponse($user);
    }
}
