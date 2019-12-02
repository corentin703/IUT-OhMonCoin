{{--Footer (NavBar)--}}

<nav class="navbar navbar-dark bg-dark justify-content-center footer">
    <form method="GET" action="{{ route('advert.index.search') }}" class="w-25">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Rechercher</span>
            </div>
            <input id="search" type="text" class="form-control" placeholder="Une annonce..." name="search" min="3" required aria-label="search" aria-describedby="search">
            <div class="input-group-append">
                <button class="btn btn-light" type="submit">Go !</button>
            </div>
        </div>
    </form>
</nav>
