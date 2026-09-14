【Laravel提出クエスト】ConduitのLaravel実装

⚬	フレームワーク実践学習の一環として、RealWorldプロジェクトのブログプラットフォーム「Conduit」の開発に取り組みました。Laravelを活用し、ユーザー認証・認可機能を含む基本的なCRUD機能を実装しました。

実装した要件は以下です。


▪️記事メイン（ステップ２）<br>
・Home 画面の記事が表示されている下に「Create」ボタンを配置する。ボタンを押下したときに Create 画面に遷移する<br>
・Create 画面で項目(タイトル, サブタイトル, 記事内容, タグ)を入力して「Publish Article」を押下したときに、DB に保存されて HOME 画面の3つ目の記事として表示される。(以降, Create するたびに4つ目、5つ目として表示される)<br>
・Home 画面の記事をクリックすると、その記事の Article 画面に遷移する<br>
・Article 画面で「Edit Article」ボタンを押下すると、Edit 画面に遷移する。また、各項目には記事作成時に保存されている情報を DB から取得し表示されている状態にする<br>
・Edit 画面で項目を編集して「Publish Article」を押下したときに、DB に保存され、HOME 画面の記事も更新される<br>
・「Delete Article」ボタンを押下したときに DB から記事が削除され、HOME 画面からも削除される<br>

▪️認証メイン（ステップ４）<br>
・Authentication(Sign In)画面でメールアドレスとパスワードを入力して「Sign In」ボタンを押下したときに、ログイン処理が実行される<br>
・Authentication(Sign Up)画面でメールアドレスとパスワードを入力して「Sign Up」ボタンを押下したときに、ユーザー登録処理が実行される<br>
・ログイン処理、ユーザー登録処理が成功した場合は、HOME画面に遷移する<br>
・Home 画面、Article 画面でログイン情報を利用して、記事に著者が表示されるようにしてください<br>
・Article 画面でログイン情報を利用して、認証機能を実装してください。著者のみ「Edit Article」ボタンを表示するようにして著者だけが記事を編集できるようにしてください<br>
・Article 画面でログイン情報を利用して、認証機能を実装してください。著者のみ「Delete Article」ボタンを表示するようにして著者だけが記事を削除できるようにしてください<br>
・Home 画面に表示される記事の最大数を5件にして、ページネーションを実装し、ページネーションをクリックすると次の5件が表示されるようにしてください<br>

 ●Laravelプロジェクトの作成と移動

 <details>
<summary>❶Laravel プロジェクトを作成</summary>

※以前のプロジェクトが残っていたら、そのプロジェクトのターミナルで`ctrl + C`

```jsx
# プロジェクト作成
composer create-project laravel/laravel apprentice-submitQ-laravel-step3-4

# ディレクトリ移動
cd apprentice-submitQ-laravel-step3-4

# 開発サーバー起動
php artisan serve
```

</details>


<details>
<summary>❷CSS（CDN）の準備(上記4つのページに CSS を適用)</summary>

`resources/views/layouts/app.blade.php` を作成します。

各ページの HTML 内（`<head>` タグの中）にその `<link ...>` タグを記述することで、Conduit 専用のスタイル（CSS）が自動で適用されます。
**共通レイアウト（`layouts/app.blade.php`）** を作成してそこに貼るのが一番効率的

</details>


<details>
<summary>❸各画面の Blade ファイル作成(balde ファイルとして、Home, Create, Edit Article, ArticleのHTMLを作成)</summary>

```jsx
recouses>viewsに

home.blade.php
editor.blade.php
article.blade.php
```

RealWorld公式ドキュメント（gothinkster/realworld-starter-kit などのテンプレートHTML）を参考に、指定された条件を反映しながらビューを作成します。

</details>


<details>
<summary>❹ルーティングの設定 (routes/web.php)
web.php にルーティングを設定し、各ページにアクセスできるようにする</summary>

ここに隠したい文章や詳細を入力します。
Markdownの書き方もそのまま使えます！

</details>


<details>
<summary>❺動作確認</summary>

ターミナルで `php artisan serve` を実行した状態で、ブラウザから各URLにアクセスして表示とデザインを確認

- **Home:** `http://127.0.0.1:8000/`
- **Create:** `http://127.0.0.1:8000/editor`
- **Edit:** `http://127.0.0.1:8000/editor/sample-article`
- **Article:** `http://127.0.0.1:8000/article/sample-article`

</details>

▪️それぞれの機能に対してのアプローチ
<details>
<summary>①Home 画面の記事が表示されている下に「Create」ボタンを配置する。ボタンを押下したときに Create 画面に遷移する</summary>

#### 1. ルーティングの追加 (`routes/web.php`)

`routes/web.php` を開き、Create画面を表示するためのルートを追加します。

```
use App\Http\Controllers\ArticleController;

// Create画面（新規作成フォーム）を表示するルート
Route::get('/editor', [ArticleController::class, 'create'])->name('articles.create');
```

#### 2. コントローラーに `create` メソッドを追加 (`ArticleController.php`)

`app/Http/Controllers/ArticleController.php` を開き、以下の記述を追加します。

```
// Create画面を表示する
public function create(){
    return view('editor');
}

//Laravelに対して「resources/views/ フォルダの中にある editor.blade.php というファイルを使って画面を表示してね！」と命令
```

#### 3. Home画面に Create ボタンを追加 (`home.blade.php`)

`resources/views/home.blade.php` を開き、記事一覧が並んでいるコードの直下に「Create」ボタンを配置します。

```
<!-- 記事一覧の直下に追加 -->
<div class="text-xs-center" style="margin-top: 2rem; margin-bottom: 2rem;">
    <a href="{{ route('articles.create') }}" class="btn btn-outline-primary">
        Create
    </a>
</div>
```

```jsx
1.ルーティングの追加(routes/web.php)
●宣言
use App\Http\Controllers\ArticleController;

●Create画面（新規作成フォーム）を表示するルート
Route::get('/editor', [ArticleController::class, 'create'])->name('articles.create');

2. コントローラーに create メソッドを追加 (ArticleController.php)
● Create画面を表示する
 public function create(){ 
 return view('editor');
 }

3. Home画面に Create ボタンを追加 (home.blade.php)
<!-- 記事一覧の直下に追加 --> 
<div class="text-xs-center" style="margin-top: 2rem; margin-bottom: 2rem;"> 
　 <a href="{{ route('articles.create') }}" class="btn btn-outline-primary"> 
　　 Create 
　 </a> 
</div>
```

### 動作確認

1. `⌘ + S` で変更したファイルをすべて保存します。
2. ブラウザで Home画面 (`http://127.0.0.1:8000`) を開き、更新 (`⌘ + Shift + R`) します。
3. 記事一覧の下に「Create」ボタンが表示されているか確認します。
4. ボタンを押して、Create画面 (`/editor`) に遷移すれば **① は完了** です！

</details>

##▪️記事メイン（ステップ２）のバトンリレー
<details>
<summary>②Create 画面で項目(タイトル, サブタイトル, 記事内容, タグ)を入力して「Publish Article」を押下したときに
DB に保存されて HOME 画面の3つ目の記事として表示される。(以降, Create するたびに4つ目、5つ目として表示される)</summary>

### **「Publish Article」ボタンを押してから画面に表示されるまでのバトンリレー**

1. **送信（ブラウザ ➔ サーバー）**
ユーザーが入力して「Publish Article」を押すと、`<form action="/editor" method="POST">` によって、入力データ（タイトル等）と暗号キー（`@csrf`）が裏側で届けられます。
2. **受け取り（web.php）**`Route::post('/editor', ...)` が「`/editor` へのPOST送信が来た！」と検知し、`ArticleController` の `store()` メソッドにバトンを渡します。
3. **チェック（store: バリデーション）**`$request->validate(...)` が動き、入力漏れや文字数オーバーがないか「セキュリティチェック」を行います。
4. **保存（store: DB保存）**
チェックをパスしたら、`Article::create(...)` が動いてデータベース（`articles` テーブル）に3件目のデータ（または4件目、5件目）を書き込みます。
5. **転送指示（store: リダイレクト）**
保存完了後、`return redirect('/');` がブラウザに対して「処理が終わったからトップページ（`/`）へ移動して！」と命令を送ります。
6. **再アクセス（web.php）**
ブラウザが自動で `/`（HOME）を開こうとすると、`Route::get('/', ...)` が「`/` へのアクセスだな！」と受け止めます。
7. **全件取得（index）**`ArticleController` の `index()` メソッドが呼ばれ、`Article::all()` を実行して**今さっき保存されたデータを含む全件**をDBから引っ張り出します。
8. **一覧描画（home.blade.php）**`index()` から記事の束を受け取った `home.blade.php` が、`@foreach` でループ処理を行い、増えた3件目（4件目、5件目…）の記事カードを順番に画面に並べて表示します。

</details>

<details>
<summary>③Home 画面の記事をクリックすると、その記事の Article 画面に遷移する</summary>

**記事のタイトル（またはカード）をクリックしてから詳細画面が表示されるまでのバトンリレー**

1. **クリック（ブラウザ）**
ユーザーが HOME 画面で読みたい記事（例: IDが `3` の記事）のリンクをクリックすると、`<a href="/articles/3">` が発動します。
2. **受け取り（web.php）**`Route::get('/articles/{id}', ...)`（または `Route::get('/articles/{article}', ...)`）が「`/articles/3` への閲覧リクエストが来た！」と検知し、`ArticleController` の `show()` メソッドに ID `3` を持たせてバトンを渡します。
3. **該当データの取得（show）**`show()` メソッドが受け取った ID `3` を使って、`Article::findOrFail(3)`（またはルートモデルバインディング）を実行し、**データベースから「3番目の記事データだけ」をピンポイントで検索・取得**します。
4. **詳細画面の表示（article.blade.php）**`show()` メソッドが取得した 1 件分の記事データを `article.blade.php`（詳細画面用の Blade ファイル）に送ります。画面側では `$article->title` や `$article->body` を使って、該当記事の全内容をくっきり表示します。

</details>

<details>
<summary>④Article 画面で「Edit Article」ボタンを押すと、Edit 画面に遷移する。また、各項目には記事作成時に保存されている情報を DB から取得し表示されている状態にする</summary>

**「Edit Article」ボタンを押してから編集画面が開くまでのバトンリレー**

1. **ボタン押下（ブラウザ）**
ユーザーが Article 画面（詳細画面）で「Edit Article」ボタンをクリックすると、`<a href="/articles/3/edit">` が発動します。
2. **受け取り（web.php）**`Route::get('/articles/{id}/edit', ...)` が「`/articles/3/edit` への編集画面リクエストだ！」と検知し、`ArticleController` の `edit()` メソッドに ID `3` を持たせてバトンを渡します。
3. **編集対象の取得（edit）**`edit()` メソッドが受け取った ID `3` を使い、`Article::findOrFail(3)` を実行して**データベースから編集したい記事データを1件ピンポイントで取得**します。
4. **フォームへの値のセット＆画面表示（editor.blade.php / edit.blade.php）**`edit()` メソッドが取得したデータを編集用ビューに渡します。HTML側の `<input value="{{ $article->title }}">` や `<textarea>{{ $article->body }}</textarea>` に既存データがあらかじめ埋め込まれた状態で、編集画面が表示されます。

</details>


<details>
<summary>⑤Edit 画面で項目を編集して「Publish Article」を押したときに、DB に保存され、HOME 画面の記事も更新される</summary>

**「Publish Article」ボタンを押して更新保存され、HOME 画面で変更が反映されるまでのバトンリレー**

1. **更新送信（ブラウザ ➔ サーバー）**
ユーザーが編集画面で内容を書き換えて「Publish Article」を押すと、`<form action="/articles/3" method="POST">` によって、入力データ・暗号キー（`@csrf`）・そして更新命令を示す `{@method('PUT')}`（または `@method('PATCH')`）が送信されます。
2. **受け取り（web.php）**`Route::put('/articles/{id}', ...)` が「`/articles/3` への更新（PUT）リクエストが来た！」と検知し、`ArticleController` の `update()` メソッドに ID `3` と入力データを渡します。
3. **該当データの取得と書き換え（update）**`update()` メソッドが `Article::findOrFail(3)` で対象のデータを呼び出し、`$article->update($validated)` を実行して**データベース内の該当レコードを新しい内容に上書き保存**します。
4. **転送指示（update: リダイレクト）**
保存完了後、`return redirect('/');`（または詳細画面への `return redirect('/articles/3');`）が実行され、ブラウザに「処理が終わったからトップページへ行け！」と命じます。
5. **再取得＆更新後の表示（index ➔ home.blade.php）**
ブラウザが HOME 画面（`/`）を開くと、`ArticleController` の `index()` が呼ばれて `Article::all()` を実行し、**今更新された最新のデータを含む全記事**を取得して `home.blade.php` を描画・表示します。

</details>


<details>
<summary>⑥「Delete Article」ボタンを押したときに DB から記事が削除され、HOME 画面からも削除される</summary>

**「Delete Article」ボタンを押して削除され、HOME 画面から消えるまでのバトンリレー**

1. **削除送信（ブラウザ ➔ サーバー）**
ユーザーが Article 画面（詳細画面）で「Delete Article」を押すと、`<form action="/articles/3" method="POST">` によって、暗号キー（`@csrf`）と削除命令を示す `{@method('DELETE')}` が送信されます。
2. **受け取り（web.php）**`Route::delete('/articles/{id}', ...)` が「`/articles/3` への削除（DELETE）リクエストが来た！」と検知し、`ArticleController` の `destroy()` メソッドに ID `3` を持たせてバトンを渡します。
3. **該当データの削除（destroy）**`destroy()` メソッドが `Article::findOrFail(3)` で対象のデータを呼び出し、`$article->delete()` を実行して**データベースから該当レコードを消去**します。
4. **転送指示（destroy: リダイレクト）**
削除完了後、`return redirect('/');` が実行され、ブラウザに対して「削除が終わったからトップページ（`/`）へ移動して！」と命令を送ります。
5. **再取得＆画面描画（index ➔ home.blade.php）**
ブラウザが HOME 画面を開くと、`ArticleController` の `index()` が呼ばれて `Article::all()` を実行します。**削除された記事を除いたデータのみ**が取得され、`home.blade.php` で消去後の記事一覧が表示されます。

</details>



▪️認証メイン（ステップ４）のバトンリレー
<details>
<summary>❶Authentication(Sign In)画面でメールアドレスとパスワードを入力して「Sign In」ボタンを押したときに、ログイン処理が実行される</summary>

ログイン機能（Sign In）の処理の流れ（バトンリレー）

**リクエスト受信からDB照合・ログイン完了までのバトンリレー**

- **ブラウザ（ユーザー操作）**
    - メールアドレスとパスワードを入力して「Sign In」ボタンを押す。
    - `POST /signin` へフォームデータを送信（リクエスト）する
    →簡単に言うと「入力したメールアドレスとパスワードを箱に詰めて、`/signin` という専用の宛先に送る動作」
    ↓
- **ルーティング (`routes/web.php`)**
    - `POST /signin` のリクエストを受け取り、担当するコントローラーのメソッド（例: `AuthController@signin`）へ処理をバトンタッチする。
    ↓
- **コントローラー (`AuthController`)**
    - **入力値バリデーション:** 送信されたデータ（メールアドレスの形式か、空欄でないか等）をチェックする。不備があればエラーメッセージとともに元の画面へリダイレクトする。
    - **認証処理:** `Auth::attempt(['email' => $email, 'password' => $password])` を実行し、モデル（DB）へ照合処理を依頼する。
    ↓
- **モデル / データベース (`User` / `users` テーブル)**
    - 入力されたメールアドレスのユーザーを検索する。
    - 登録されているハッシュ化パスワードと入力パスワードを照合・検証し、結果をコントローラーへ返却する。
    ↓
- **コントローラー (`AuthController`)**
    - **照合成功:** セッションを再生成（`request()->session()->regenerate()`）してログイン状態にし、Home画面（`/`）へリダイレクトする。
    - **照合失敗:** ログイン失敗の旨（例: "That email is already taken" 等のメッセージ）を保持して、元のSign In画面へ戻す。
    ↓
- **ビュー (`signin.blade.php` または `home.blade.php`)**
    - レスポンスを受けて、ログイン完了後のHome画面（またはエラー表示付きのSign In画面）をユーザーのブラウザに描画する。

</details>


<details>
<summary>❷Authentication(Sign Up)画面でメールアドレスとパスワードを入力して「Sign Up」ボタンを押したときに、ユーザー登録処理が実行される</summary>

**Authentication(Sign Up)画面でメールアドレスとパスワードを入力して「Sign Up」ボタンを押したときに、ユーザー登録処理が実行される**
リクエスト受信からDB保存・自動ログイン完了までのバトンリレー

**ブラウザ（ユーザー操作）**
ユーザー名・メールアドレス・パスワードを入力して「Sign Up」ボタンを押す。
POST /signup へフォームデータを送信（リクエスト）する。
→簡単に言うと「入力した登録情報を箱に詰めて、/signup という専用の宛先に送る動作」

↓

**ルーティング (`routes/web.php`)**
POST /signup のリクエストを受け取り、担当するコントローラーのメソッド（例: `AuthController@signup`）へ処理をバトンタッチする。

↓

**コントローラー (`AuthController`)**

- **入力値バリデーション:** 送信されたデータ（メールの重複チェック `unique:users` やパスワードの文字数など）を検証する。不備があればエラーメッセージとともに元の Sign Up 画面へ戻す。
- **パスワードの暗号化:** 送信されたパスワードを `Hash::make()` でハッシュ化する。

↓

**モデル / データベース (`User` / `users` テーブル)**
コントローラーからの指示を受けて、`User::create([...])` を実行し、`users` テーブルへ新しいユーザーレコードを挿入・保存する。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
以降は不要　以下加えたら「登録後に自動でログイン状態にする（パターン1）」

**コントローラー (`AuthController`)**

- **自動ログイン処理:** 作成した新規ユーザー情報を使って `Auth::login($user)` を実行し、その場でログイン状態にする。
- **セッション再生成:** `request()->session()->regenerate()` を実行して安全なセッションを発行する。
- **リダイレクト:** 登録＆ログイン完了後、Home画面（`/`）へリダイレクトする。

↓

**ビュー (`home.blade.php` または `signup.blade.php`)**
レスポンスを受けて、新規登録＆ログイン完了後のHome画面（またはバリデーションエラー表示付きの Sign Up 画面）をユーザーのブラウザに描画する。
</details>

<details>
<summary>❸ログイン処理、ユーザー登録処理が成功した場合は、HOME画面に遷移する</summary>
※❶Authentication(Sign In)画面でメールアドレスとパスワードを入力して「Sign In」ボタンを押したときに、ログイン処理が実行されるで既に実装できている

</details>

<details>
<summary>❺Article 画面でログイン情報を利用して、認証機能を実装してください。著者のみ「Edit Article」ボタンを表示するようにして著者だけが記事を編集できるようにしてください</summary>

**ブラウザ（ユーザー操作）**
ユーザーが記事詳細ページ（例: `/article/1`）にアクセス（GET リクエスト）する。

↓

**ルーティング (`routes/web.php`)**
GET リクエストを受け取り、`ArticleController@show` へ処理をバトンタッチする。

↓

**コントローラー (`ArticleController`)**

- **データ取得:** 指定された記事データと、それに紐づく著者情報（`User`）を DB から取得する。
- **ビューへ渡し:** 取得した記事（`$article`）を Article 画面の Blade（例: `article.blade.php`）へ渡す。

↓

**ビュー (`article.blade.php`)**

- **条件分岐（`@can` または `@if`）:** ログイン中のユーザー（`Auth::user()`）と記事の著者（`$article->user_id`）が一致するかチェックする。
    - **一致する場合（著者本人）:** 「Edit Article」ボタンを描画して表示する。
    - **不一致・未ログインの場合:** ボタンを描画しない（非表示にする）。

↓

**ブラウザ（ユーザー画面表示）**
著者本人の場合は「Edit Article」ボタンが見え、第三者の場合はボタンが表示されない記事画面が描画される。

↓

**編集実行時（セキュリティ検証バトン）**
もし第三者が直接 URL（例: `/article/1/edit`）を入力してアクセスを試みた場合：

- **コントローラー (`ArticleController@edit`):** 処理の冒頭で `if ($article->user_id !== Auth::id())` を判定。
- **アクセス拒否:** 著者でない場合は `abort(403)`（権限エラー）を返し、編集画面の表示および更新処理を完全にブロックする。

</details>


<details>
<summary>❻Article 画面でログイン情報を利用して、認証機能を実装してください。著者のみ「Delete Article」ボタンを表示するようにして著者だけが記事を削除できるようにしてください→❺と同時に実装</summary>

**ブラウザ（ユーザー操作）**

- **画面表示:** ユーザーが記事詳細ページ（例: `/article/1`）にアクセスする。
- **ボタン押下:** 著者本人のみが見える「Delete Article」ボタンをクリックし、削除フォームを送信（POST /article/1 + `_method=DELETE`）する。

↓

**ルーティング (`routes/web.php`)**`Route::delete('/article/{id}', [ArticleController::class, 'destroy'])` などのルーティングが削除リクエスト（DELETE）を受け取り、`ArticleController@destroy` へ処理をバトンタッチする。

↓

**ビュー (`article.blade.php`)**

- **条件分岐 (`@if` または `@can`):** ログイン中のユーザー（`Auth::id()`）と記事の著者 ID（`$article->user_id`）が一致するかチェックする。
    - **一致する場合（著者本人）:** 「Delete Article」フォーム＆ボタンを描画する。
    - **不一致・未ログインの場合:** ボタンを描画しない（非表示にする）。

↓

**コントローラー (`ArticleController@destroy`)**

1. **セキュリティ検証（権限チェック）:**
リクエストを送ってきたユーザーが著者本人か判定（`if ($article->user_id !== Auth::id())`）する。著者でない場合は `abort(403)` で処理を強制中断し、不正アクセスを遮断する。
2. **データ削除:** 著者本人であることが確認できたら、`$article->delete()` を実行してデータベースから記事レコードを削除する。
3. **リダイレクト:** 削除完了後、Home画面（`/`）へリダイレクト（`return redirect('/')`）する。

↓

**ブラウザ（ユーザー画面表示）**
Home画面へ遷移し、削除された記事が一覧から消えている状態が描画されて完了。

</details>

<details>
<summary>❼Home 画面に表示される記事の最大数を5件にして、ページネーションを実装し、ページネーションをクリックすると次の5件が表示されるようにしてください→実装自体は❹で完了</summary>

**Home 画面に表示される記事の最大数を5件にしてページネーションを実装する**
リクエスト受信から件数制御・ページネーション描画完了までのバトンリレー

**ブラウザ（ユーザー操作）**
ユーザーが Home 画面（`/`）や、ページ番号付き URL（例: `/?page=2`）へアクセス（GET リクエスト）する。

↓

**ルーティング (`routes/web.php`)**
GET リクエストを受け取り、`ArticleController@index` へ処理をバトンタッチする。

↓

**コントローラー (`ArticleController@index`)**

- **データ取得 (ページネーション適用):**
全件取得（`get()`）ではなく、`paginate(5)` を使用してデータを取得する。
`$articles = Article::with('user')->latest()->paginate(5);`
※ Laravel が URL の `?page=X` パラメータを自動で読み取り、該当する 5 件だけを DB から取得してくれます。
- **ビューへ渡し:** ページネーション情報が含まれた `$articles` を Home 画面の Blade へ渡す。

↓

**モデル / データベース (`Article` / `users` テーブル)**`LIMIT 5 OFFSET X` の SQL が自動発行され、指定されたページの 5 件分の記事データと、全体の件数（総ページ数の計算用）を取得してコントローラーへ返す。

↓

**ビュー (`home.blade.php`)**

- **記事一覧の描画:** 渡された 5 件分の記事データを `@foreach ($articles as $article)` でループ表示する。
- **ページ番号リンクの描画:** テンプレート内の静的な `<ul class="pagination">...</ul>` 部分を **`{{ $articles->links() }}`** に置き換える。これにより、次ページや前ページへのリンク HTML が自動生成される。

↓

**ブラウザ（ユーザー画面表示）**
最大 5 件の記事と、ページ切り替えボタン（1, 2, ... や Next）が表示された画面が描画される。ユーザーが「2」などをクリックすると、`/?page=2` のリクエストが飛び、次の 5 件が表示される。

</details>
