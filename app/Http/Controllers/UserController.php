<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use App\User;



class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $users= User::paginate(15);

        return view('user.index', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate(User::$rules);

        $data = [
            'user_type' => $request->input('is_admin')?1:0,
            'password' => Hash::make($request->input('password'))
        ];

        $user = User::create(array_merge($request->except(['password']), $data));

        return redirect()->route('user.index')->with('success', 'Пользователь добавлен');
    }

    public function update(Request $request, $id)
    {
        User::find($id)->update(['user_type' => $request->input('is_admin')?1:0]);

        return response()->json(['success'=> true]);
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return response()->json(['success'=> true]);
    }
}
