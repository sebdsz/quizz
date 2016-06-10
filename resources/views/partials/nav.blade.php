<nav class="navbar navbar-default">
    <div class="container">
        <ul class="nav navbar-nav">
            <li><a href="{{ action('FrontController@index') }}">Quizz</a></li>
            <li><a href="{{ action('QuestionController@index') }}">Questions</a></li>
            <li><a href="{{ action('ThemeController@index') }}">Thèmes</a></li>
            <li><a href="{{ action('ResultController@index') }}">Résultats</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="{{ url('/logout') }}">Se déconnecter</a></li>
        </ul>
        <p class="navbar-text">Coucou {{ Auth::user()->first_name }} prêt(e) pour réviser ?</p>
    </div>
</nav>