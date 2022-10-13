<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    public function addFavorite(Request $request)
    {
        $status = false;
        $result = null;
        $favorite = new Favorite();
        DB::beginTransaction();
        try {
            $user = Auth::id();
            $favorite->user_id = $user;
            $favorite->pokemon_id = $request->pokemon;
            $favorite->save();

            $status = true;
            DB::commit();
        } catch (\Throwable $th) {
            $result = $th->getMessage();
            DB::rollBack();
        }

        $message = $status ? ["type" => "success", "content" => "Done."] : ["type" => "error", "content" => "Error."];
        $data = $status ? $favorite : $result;

        return $this->responseApi($status, $message, $data);
    }

    public function getFavorites(Request $request)
    {
       $user = Auth::id();
       $favorites = Favorite::where("user_id", $user)->get();
       return $this->responseApi(true, ["type" => "success", "content" => "Done."], $favorites);
    }
}
