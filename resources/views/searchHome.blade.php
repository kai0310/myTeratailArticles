@extends('layout')

@section('content')
    <div class="vertical-center">
        <div class="container text-center">
            <h1>検索情報入力</h1>
            <form action="GetMyArticles" method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-9 col-md-offset-2 form-group">
                        <input class="form-control" type="text" name="searchWord" placeholder="検索キーワードを入力" required value="{{ old('searchWord') }}">
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
                <div class="row form-group">
                    <div class="col-md-offset-3 col-md-7">
                        <input type="submit" class="form-control btn-success" name="searchBtn" value="検索">   
                    </div>
                </div>
                <div class="row form-group">
                    <label for="saveCookie" class="form-check-label">
                        <input type="checkbox" checked name="saveCookie" id="saveCookie" value="saveCookie" class="form-check-input">
                        アクセストークンとユーザーIDを保存する</label>              
                </div>
                <div class="row form-group">
                    <div class="col-md-offset-3 col-md-2 text-right text-muted">
                        <label>アクセストークン</label>
                    </div>                    
                    <div class="col-md-3">
                        <input type="text" name="accesstoken" class="form-control" value="{{$accesstoken}}"
                               placeholder="アクセストークンを入力して下さい" required>                                                       
                    </div>                    
                </div>
                <div class="row form-group">
                    <div class="col-md-offset-3 col-md-2 text-right text-muted">
                        <label>ユーザーID</label>
                    </div>                    
                    <div class="col-md-3">
                        <input type="text" name="userID" class="form-control" 
                               placeholder="ユーザーIDを入力して下さい" required value="{{$userID}}">                                                        
                    </div>                    
                </div>                
            </form>
        </div>     
    </div>  
@stop
