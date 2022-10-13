<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\RegisterUserMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * This function login the user on the system.
     * @param Request $request - data of request.
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $activeUser = User::where("status_id", $this->active_status)->where("email", $request->email)->first();

            if (isset($activeUser->id)) {
                $token = $activeUser->createToken("netgrid_test")->accessToken;
                return $this->responseApi(true, ["type" => "success", "content" => "Done."], ["token" => $token, "user" => $user]);
            } else {
                return $this->responseApi(false, ["type" => "error", "content" => "The user isn't authorized."], []);
            }
        } else {
            return $this->responseApi(false, ["type" => "error", "content" => "Error."], []);
        }
    }

    /**
     * This function register the user in the system but this user have inactive status.
     * @param RegisterRequest $request - data of request.
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $status = false;
        $result = null;
        $user = new User();
        DB::beginTransaction();
        try {
            $user->name = ucwords(strtolower($request->name));
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->address = $request->address;
            $user->complement = $request->complement;
            $user->city = $request->city;
            $user->birthday = Carbon::parse($request->birthday)->format("Y-m-d H:i:s");
            $user->status_id = $this->inactive_status;
            $user->save();

            Mail::to($request->email)->send(new RegisterUserMail($request->name, $request->email, $user->id));

            $status = true;
            DB::commit();
        } catch (\Throwable $th) {
            $result = $th->getMessage();
            DB::commit();
        }

        $type = $status ? "success" : "error";
        $message = $status ?  "Done." : "Error.";

        return $this->responseApi($status, ["type" => $type, "content" => $message], $status ? $user : $result);
    }

    /**
     * This function active the user account.
     * @param string $id - user's id account.
     * @return JsonResponse
     */
    public function activeUser(string $id): JsonResponse
    {
        $newId = base64_decode($id);
        $status = false;
        $result = null;
        $user = User::find($newId);
        DB::beginTransaction();
        try {
            $user->status_id = $this->active_status;
            $user->save();

            $status = true;
            DB::commit();
        } catch (\Throwable $th) {
            $result = $th->getMessage();
            DB::rollBack();
        }

        $message = $status ? ["type" => "success", "content" => "Done."] : ["type" => "error", "content" => "Error."];
        $data = $status ? $user : $result;

        return $this->responseApi($status, $message, $data);
    }
}
