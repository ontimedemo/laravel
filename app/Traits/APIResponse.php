<?php
/**
 * Created by PhpStorm.
 * User: sean
 * Date: 8/27/17
 * Time: 10:44 PM
 */

namespace App\Traits;


trait APIResponse
{
    //Response codes, work around for not having const in traits
    public static $OK = 200;
    public static $CREATED = 201;
    public static $ACCEPTED = 202;
    public static $NOCONTENT = 204;
    public static $UNAUTHORIZED = 401;
    public static $FORBIDDEN = 403;
    public static $NOTFOUND = 404;

    /**
     * @param $data
     * @param int $code
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiResponse($data, int $code = 200, string $status = 'success')
    {
        $response = [
            'datetime' => (new \DateTime())->format('c'),
            'status' => $status,
            'code' => $code
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }
        return response()->json($response, $code);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiError(string $message)
    {
        return $this->apiResponse(['message' => $message], self::$NOTFOUND, 'error');
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiCreated($data)
    {
        return $this->apiResponse($data, self::$CREATED);
    }
}