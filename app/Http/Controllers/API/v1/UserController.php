<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response(['user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details.
            Please try again']);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token]);

    }

    public function followUser(Request $request)
    {

        $this->validate($request, [
            'id_1' => 'required|numeric|exists:users,id',
            'id_2' => 'required|numeric||exists:users,id',

        ]);

        $id_1 = $request->id_1;
        $id_2 = $request->id_2;

        $user1 = User::find($id_1);
        $user2 = User::find($id_2);
        $user1->follow($user2);

        return response(['user' => $user1, 'message' => ' User followed Successful'], 200);
    }

    public function unfollowUser(Request $request)
    {

        $this->validate($request, [
            'id_1' => 'required|numeric|exists:users,id',
            'id_2' => 'required|numeric||exists:users,id',

        ]);

        $id_1 = $request->id_1;
        $id_2 = $request->id_2;

        $user1 = User::find($id_1);
        $user2 = User::find($id_2);
        $user1->unfollow($user2);

        return response(['user' => $user1, 'message' => ' User followed Successful'], 200);
    }

    public function getfollowing($id)
    {

        $user = User::find($id);

        $following = $user->followings;

        return response(['following' => $following, 'message' => ' successful'], 200);
    }

    public function getfollower($id)
    {

        $user = User::find($id);

        $followers = $user->followers;

        return response(['follower' => $followers, 'message' => ' successful'], 200);
    }


}
