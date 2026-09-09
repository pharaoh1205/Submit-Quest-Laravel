@extends('layouts.app')

@section('content')
<div class="editor-page">
    <div class="container page">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-xs-12">
                <!-- 1. action, method を指定 -->
                <form action="{{ isset($article) ? route('articles.update', $article->id) : route('articles.store') }}" method="POST">
                    @csrf

                    <!-- 編集時（$articleが存在するとき）だけ PUT メソッドを発行 -->
                    @if(isset($article))
                    @method('PUT')
                    @endif


                    <fieldset>
                        <!-- タイトル -->
                        <fieldset class="form-group">
                            <input type="text" name="title" class="form-control form-control-lg" placeholder="Article Title" value="{{ old('title', $article->title ?? '') }}">
                        </fieldset>

                        <!-- 概要 -->
                        <fieldset class="form-group">
                            <input type="text" name="description" class="form-control" placeholder="What's this article about?" value="{{ old('description', $article->description ?? '') }}">
                        </fieldset>

                        <!-- 本文 ※本文以外はinputだが本文はtextarea-->
                        <fieldset class="form-group">
                            <textarea name="body" class="form-control" rows="8" placeholder="Write your article (in markdown)">{{ old('body', $article->body ?? '') }}</textarea>
                        </fieldset>

                        <!-- タグ -->
                        <fieldset class="form-group">
                            <input type="text" name="tags" class="form-control" placeholder="Enter tags" value="{{ old('tags', $article->tags ?? '') }}">
                        </fieldset>

                        <!-- 7. type="submit" に変更 -->
                        <button class="btn btn-lg pull-xs-right btn-primary" type="submit">
                            Publish Article
                        </button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection