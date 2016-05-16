@extends("plantillas.admin")

@section("nombre_pagina")
    @stop
@section("contenido")

    <section id="github">
        <h2 class="page-header"><a href="#github">Github</a></h2>
        <p class="lead">

        </p>
        <div id="feed"></div>

    </section><!-- /#introduction -->


    <!-- ============================================================= -->
@stop

@section("extra_js")
    <link rel="stylesheet" href="/css/github-activity.css">

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/mustache.js/0.7.2/mustache.min.js"></script>
    <script type="text/javascript" src="/js/github-activity.js"></script>
    <script type="text/javascript">
    $( document).ready(function(){
        GitHubActivity.feed({ username: "danilor", selector: "#feed", repository:"TQP" });
    });
    </script>

@stop