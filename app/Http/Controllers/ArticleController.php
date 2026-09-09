<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ArticleController extends Controller
{
    public function create()
    {
        return view('editor');
    }


    //「フォームから届いたデータをチェックし、問題なければDBに保存して、最後にホーム画面に戻す」
    //❶Request = use Illuminate\Http\Request;のこと
    public function store(Request $request)
    {

        // バリデーション(送信されてきたデータが「正しく入力されているかチェックする仕組み」)
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'body'        => 'required|string',
            'tags'        => 'nullable|string',
            // もしくはフォームのname属性に合わせて調整
        ]);

        //❷Model
        // DBに保存=Article（モデル）を使ってデータベースの articles テーブルに保存
        //create＝「新規データを作成してデータベースに保存する」という命令
        Article::create([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'body'        => $validated['body'],
            'tags'        => $validated['tags'] ?? '',
            'user_id' => Auth::id(), // ←★ここを追加！ログイン中のユーザーIDを保存
        ]);

        // HOME画面へリダイレクト
        return redirect('/');
    }

    //ホーム画面に記事を表示
    // public function index()
    // {
    //     // 作成日時順（新しい順、または古い順）で全件取得
    //     // 上書き保存された最新データを含めて全件取得
    //     $articles = Article::latest()->get();
    //     return view('home', compact('articles'));
    // }


    // 受け取った $id を使ってデータベースから検索
    // public function show($id)
    // {
    //     // 該当するIDの記事を1件だけ取得（存在しない場合は404エラー）
    //     $article = Article::findOrFail($id);

    //     // 取得した1件のデータを article.blade.php に送る
    //     return view('article', compact('article'));
    // }

    public function edit($id)
    {

        // 該当するIDの記事を取得（無ければ404）
        $article = Article::findOrFail($id);

        // ★著者本人でない場合は 403 エラーを返す
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        // editor.blade.php に $article のデータを持たせて開く
        return view('editor', compact('article'));
        //「どこに（どの画面に）、何を（どのデータを持って）返すか」
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'title'       => 'required|max:255',
            'description' => 'required',
            'body'        => 'required',
            'tags'        => 'nullable',
        ]);

        $article = Article::findOrFail($id);

        // ★著者本人でない場合は 403 エラーを返す
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $article->update($validated);

        return redirect()->route('home');
    }

    public function destroy($id)
    {
        // ★著者本人でない場合は 403 エラーを返す

        $article = Article::findOrFail($id);

        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $article->delete();
        return redirect()->route('home');
    }

    // Home 画面：記事一覧表示
    public function index()
    {
        // 著者情報（user）を一緒に取得し、作成日時の降順でペジネーション（5件ずつ）取得
        $articles = Article::with('user')->latest()->paginate(5);

        return view('home', compact('articles'));
    }

    // Article 画面：記事詳細表示
    public function show($id)
    {
        // 指定された ID の記事を著者情報と一緒に取得（存在しなければ 404 エラー）
        $article = Article::with('user')->findOrFail($id);

        return view('article', compact('article'));
    }
}
