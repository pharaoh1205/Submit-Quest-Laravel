<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 画面表示
    public function showSignin()
    {
        return view('auth.signin');
        //auth フォルダの中にある signin.blade.php という画面ファイルを指している
    }

    // ログイン処理
    public function signin(Request $request)
    {
        // ① バリデーション（入力チェック）
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ② 照合処理（DBと照合してログイン）
        if (Auth::attempt($credentials)) {
            // セッション再生成（セキュリティ対策）
            $request->session()->regenerate();

            // ③ 照合成功：HOME画面へリダイレクト
            return redirect()->intended('/');
        }

        // ④ 照合失敗：元の画面にエラーを返却
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showSignup(){
        return view('auth.signup');
    }

    public function signup(Request $request){
        // ① バリデーション（重複チェック・パスワード文字数など）
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // ② DB保存（パスワードは Hash::make で暗号化） 
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // ③ 自動ログイン
        Auth::login($user);

        // ④ セッション固定攻撃対策（セッション再生成）
        $request->session()->regenerate();

        // ⑤ HOME画面へリダイレクト
        return redirect('/');
    }
}

