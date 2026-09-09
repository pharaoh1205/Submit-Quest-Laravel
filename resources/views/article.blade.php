@extends('layouts.app')
<!-- テンプレのappと連携 -->

@section('content')
<!-- この中のデータを親ファイルのメインエリアにハメ込む -->
<div class="article-page">
    <div class="banner">
        <div class="container">
            <!-- 変更点①：静的タイトルを動的タイトルに変更 -->
            <h1>{{ $article->title }}</h1>

            <div class="article-meta">
                <!-- 変更点②：著者名と投稿日時のエリアを動的データで復元 -->
                <div class="info">
                    <a href="" class="author">{{ $article->user->name }}</a>
                    <span class="date">{{ $article->created_at->format('M j, Y') }}</span>
                </div>

                @if(Auth::check() && Auth::id() === $article->user_id)
                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ion-edit"></i> Edit Article
                </a>

                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('本当に削除しますか？')">
                        <i class="ion-trash-a"></i> Delete Article
                    </button>
                </form>
                @endif

            </div>
        </div>
    </div>

    <div class="container page">
        <div class="row article-content">
            <div class="col-md-12">
                <!-- 変更点③：本文エリア内の重複見出し（h1）を削除 -->
                <p class="description">{{ $article->description }}</p>
                @if($article->tags)
                <ul class="tag-list" style="list-style: none; padding-left: 0;">
                    <li class="tag-default tag-pill tag-outline" style="display: inline-block; border: 1px solid #ccc; border-radius: 10px; padding: 2px 10px; font-size: 0.8rem;">
                        {{ $article->tags }}
                    </li>
                </ul>
                @endif
                <hr>
                <div>
                    {!! nl2br(e($article->body)) !!}
                </div>
            </div>
        </div>

        <!-- ※ 注意事項に基づき <hr /> より下のコード（コメント機能等）はカット -->
    </div>
</div>
@endsection