<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * This variable show the active status.
     * @var integer
     */
    public int $active_status = 1;

    /**
     * This variable show the inactive status.
     * @var integer
     */
    public int $inactive_status = 2;

    /**
     * This function reformat all response that we sent to end user
     * @param boolean $status - request status.
     * @param array $message - message that we sent to end user.
     * @param mixed $data - data obtained from request.
     * @return JsonResponse
     */
    public function responseApi(bool $status, array $message, mixed $data): JsonResponse
    {
        if($message["type"] === "success"){
            $message["code"] = 200;
        } else if ($message["type"] === "error") {
            $message["code"] = 500;
        } else if ($message["type"] === "warning") {
            $message["code"] = 300;
        } else {
            abort(500);
        }

        return response()
            ->json([
                "transaction" => ["status" => $status],
                "message" => $message,
                "data" => $data
            ], $message["code"]);
    }
}
