{{--Footer (NavBar)--}}

@inject('categories', 'App\Repositories\CategoryRepository')

<nav class="navbar navbar-dark bg-dark justify-content-center">
    <form method="GET" action="{{ route('adverts.index') }}" class="w-50">
        <div class="input-group row">
            <div class="input-group-prepend">
                <span class="input-group-text">Rechercher dans</span>
            </div>
            <select id="category" class="form-control col-4" name="category" required autocomplete="off">
                <option value="0" @if(!isset($categorySearched)) selected @endif>toute categorie</option>
                @foreach($categories->all() as $category)
                    <option value="{{ $category->id }}" @if(isset($categorySearched) && $categorySearched->id == $category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
            <input id="search" type="text" class="form-control col-5" placeholder="Une annonce..." name="string" min="3" value="@isset($stringSearched) {{ $stringSearched }} @endisset" required aria-label="search" aria-describedby="search">
            <div class="input-group-append">
                <button class="btn btn-light" type="submit">Go !</button>
            </div>
        </div>
    </form>
</nav>
