@extends('layout')

@section('content')
<form action="GetMyArticles" method="POST">
    {{ csrf_field() }}
    <input type="hidden" value="{{$requestParam['accesstoken']}}" name="accesstoken">
    <div class="container form-group">
        <div class="row">
            <div class="col-md-6">
                <input type="text" class="form-control" name="searchWord" value="{{$requestParam['searchWord']}}" required>
            </div>
            <div class="col-md-2">
                <input type="submit" class="form-control btn-success col-md-2" value="再検索">
            </div>
            <div class="col-md-2">
                <input type="text" value="{{$requestParam['userID']}}" name="userID" class="form-control" required>
            </div>
        </div>
        <div class="row form-group">
            <label for="answer" class="form-check-label">
                <input type="radio" class="form-check-input" name="answerOrQuestion" value="isAnswer" id ="answer" checked>
                回答から探す
            </label>
            <label for="question" class="form-check-label">
                <input type="radio" class="form-check-input" name="answerOrQuestion" value="isQuestion" id="question">
                質問から探す
            </label>
        </div>
    </div>
</form>
@if(count($getArticle) > 0)
    <div class="container">
        @foreach ($getArticle as $article)
        <div class="row row-eq-height well">
           <div class="col-md-10">
                @if ($requestParam['answerOrQuestion']=='isAnswer')
                <a href="https://teratail.com/questions/{{$article['question_id']}}" target="blank">
                    <h2>{{$article['question_id']}}</h2>
                </a>
                @else
                <a href="https://teratail.com/questions/{{$article['id']}}" target="blank">
                    <h2>{{$article['title']}}</h2>
                </a>
                @endif
                {!! $article['body_str'] !!}
            </div>
        </div>
        @endforeach
    </div>
@else
<h3>検索内容に該当がありませんでした。</h3>
@endif
@stop
