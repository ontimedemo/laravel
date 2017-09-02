<?php

namespace App\Http\Controllers;

use App\Model\TimeLog;
use App\Model\Task;
use App\Traits\APIResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TimelogController extends BaseController
{
    use APIResponse;

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $logs = Task::with('logs')->get();
            return $this->apiResponse($logs);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * @param int $task
     * @return JsonResponse
     */
    public function checkin(int $task): JsonResponse
    {
        try {
            Task::findOrFail($task); //Check to make sure the task exists
            $data = [
                'user_id' => $this->getUser()->id,
                'start' => (new \DateTime)->format('m/d/Y h:ia'),
                'task_id' => $task
            ];
            $log = TimeLog::create($data);
            return $this->apiCreated($log);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * @param int $log
     * @return JsonResponse
     */
    public function checkout(int $log)
    {
        try {
            $log = TimeLog::findOrFail($log);
            $log->end = (new \DateTime)->format('m/d/Y h:ia');
            $log->update();
            return $this->apiResponse($log);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }
}
