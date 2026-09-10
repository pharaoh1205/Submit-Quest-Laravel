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
