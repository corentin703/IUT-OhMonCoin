<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
// TODO: Résoudre ce problème !
//        $this->middleware('auth:api');
    }
    public function index()
    {
        return User::all();
    }

    public function show(User $article)
    {
        return $article;
    }

    public function store(Request $request)
    {
        $article = User::create($request->all());

        return response()->json($article, 201);
    }

    public function update(UpdateUser $request, User $user)
    {
        dd(Auth::check(), $user->id);
        if (Auth::check() && Auth::id() === $user->id)
        {
            $user->fill($request->all())
                ->save();
        }

        return response()->json(null, 204);
    }

    public function updatePassword(Request $request, User $user)
    {
        $validation = Validator::make($request->all(), [
            'oldPassword' => ['required', 'password:api'],
            'password' => ['required', 'confirmed', 'min:6', 'max:100'],
        ]);

        if (Auth::check() && (Auth::user()->id === $user->id))
        {
            $user->password = Hash::make($validation['password']);
            $user->save();
        }

        dd("OK");

        return response()->json(null, 204);
    }

    public function destroy(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'password' => ['required', 'password:api'],
        ])->validate();

        $user->delete();

        return response()->json(null, 204);
    }



//    public function index()
//    {
//        return view('user', [
//            'user' => Auth::user(),
//        ]);
//    }
//
//    /**
//     * Returns a list of undeleted users
//     *
//     * @return JsonResponse
//     */
//    public function fetch() : JsonResponse
//    {
//        $users = User::all();
//
//        return new JsonResponse($users);
//    }
//
////    cf. RegisterController (Laravel's auth system)
////    public function create()
////    {
////
////    }
//
//    public function update(UpdateUser $request)
//    {
//        dd("OK");
//        if (Auth::check() && Auth::id() == $request->id)
//        {
//            User::find($request->input('id'))
//                ->fill($request->all())
//                ->save();
//        }
//    }
//
//    public function updatePassword(Request $request)
//    {
//        $validation = Validator::make($request->all(), [
//            'oldPassword' => ['required', 'password:api'],
//            'password' => ['required', 'confirmed', 'min:6', 'max:100'],
//        ]);
//
//        if (Auth::check() && (Auth::user()->id === $request->input('id')))
//        {
//            $user = Auth::user();
//            $user->password = Hash::make($validation['password']);
//            $user->save();
//        }
//    }
//
//    public function delete(Request $request)
//    {
//        $validation = Validator::make($request->all(), [
//            'id' => ['required', 'unique:users,id,' . $request->input('id')],
////            'password' => ['required', 'password:api'],
//        ]);
//
//        User::find($validation['id'])
//            ->delete();
//    }
}
