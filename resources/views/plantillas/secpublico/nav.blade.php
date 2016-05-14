<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse.collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><span>{{config('app.nombre_app')}}</span></a>
        </div>
        <div class="navbar-collapse collapse">
            <div class="menu">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="/">{{"Inicio"}}</a></li> <!-- class="active" -->
                    <li role="presentation"><a href="services.html">{{"Productos"}}</a></li>
                    <li role="presentation"><a href="blog.html">{{"Donde estamos"}}</a></li>
                    <li role="presentation"><a href="portfolio.html">{{"Acerca de"}}</a></li>
                    <li role="presentation"><a href="contact.html">{{"Contacto"}}</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>