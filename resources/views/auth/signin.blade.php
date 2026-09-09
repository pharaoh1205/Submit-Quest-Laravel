@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="container page">
        <div class="row">
            <div class="col-md-6 offset-md-3 col-xs-12">
                <h1 class="text-xs-center">Sign in</h1>
                <p class="text-xs-center">
                    <a href="/signup">Need an account?</a>
                </p>

                <!-- エラーメッセージの表示 -->
                @if ($errors->any())
                    <ul class="error-messages">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <!-- 送り先(/signin)と送り方(POST)を指定 -->
                <form action="/signin" method="POST">
                    @csrf
                    <fieldset class="form-group">
                        <input class="form-control form-control-lg" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    </fieldset>
                    <fieldset class="form-group">
                        <input class="form-control form-control-lg" type="password" name="password" placeholder="Password" required>
                    </fieldset>
                    
                    <button type="submit" class="btn btn-lg btn-primary pull-xs-right">Sign in</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection