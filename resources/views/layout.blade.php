<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>teratail記事検索</title>
        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./css/tether.min.css">
        <link rel="stylesheet" type="text/css" href="./css/app.css">
        <link href="http://kevinburke.bitbucket.org/markdowncss/markdown.css" rel="stylesheet">
    </head>
    <body >
        <div class="bs-docs-section clearfix">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bs-component">
                        <nav class="navbar navbar-dark bg-primary">
                            <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive2" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
                            <div class="container collapse navbar-toggleable-md" id="navbarResponsive2">
                                <a class="navbar-brand" href="./">teratail過去記事検索</a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
        <script type="text/javascript" src="./js/jquery-3.2.1.min.js"></script>    
        <script type="text/javascript" src="./js/tether.min.js"></script>
        <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    </body>
    <footer class="footer navbar-absolute-bottom">
        <div class="container">
            <div class="mx-auto text-center" style="width: 200px">
                <a href="https://teratail.com/" target="blank"><h3>本家サイトへ</h3></a>                  
            </div>
        </div>
    </footer>
</html>