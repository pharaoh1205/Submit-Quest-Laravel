@extends('layouts.app')

@section('content')
<div class="home-page">
    <div class="banner">
        <div class="container">
            <h1 class="logo-font">conduit</h1>
            <p>A place to share your knowledge.</p>
        </div>
    </div>

    <div class="container page">
        <div class="row">
            <div class="col-md-9">
                <div class="feed-toggle">
                    <ul class="nav nav-pills outline-active">
                        <li class="nav-item">
                            <a class="nav-link active" href="">Global Feed</a>
                        </li>
                    </ul>
                </div>

                <!-- 記事カード一覧プレビュー（例） -->
                @foreach ($articles as $article)
                <div class="article-preview">
                    <div class="article-meta">
                        <!-- 著者情報 -->
                        <div class="info">
                            <a href="" class="author">writer : {{ $article->user->name ?? 'guest' }}</a>
                            <span class="date">{{ $article->created_at->format('M j, Y') }}</span>
                        </div>
                    </div>

                    <!-- 記事タイトルと説明 -->
                    <a href="{{ route('articles.show', $article->id) }}" class="preview-link">
                        <h1>{{ $article->title }}</h1>
                        <p>{{ $article->description }}</p>
                        <span>Read more...</span>
                    </a>
                </div>
                @endforeach

                <!-- ページネーションリンク -->
                <div class="d-flex justify-content-center">
                    {{ $articles->links() }}
                </div>
            </div>



            <!-- サイドバー Tag -->
            <div class="col-md-3">
                <div class="sidebar">
                    <p>Popular Tags</p>
                    <div class="tag-list">
                        <a href="" class="tag-pill tag-default">programming</a>
                        <a href="" class="tag-pill tag-default">javascript</a>
                        <a href="" class="tag-pill tag-default">laravel</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-xs-center" style="margin-top: 2rem; margin-bottom: 2rem;">
            <a href="{{ route('articles.create') }}" class="btn btn-outline-primary">
                Create
            </a>
        </div>
    </div>

</div>
@endsection