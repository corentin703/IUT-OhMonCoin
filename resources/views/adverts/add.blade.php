
@inject('categories', 'App\Repositories\CategoryRepository')

<div id="btnDock" class="btn-group dropup dock_group">
    <div>
        <button id="btnAddAdvert" class="btn btn-success" onclick="$('#addAdvert').modal()">Ajouter une annonce</button>
    </div>
</div>

<div class="modal fade" id="addAdvert" tabindex="-1" role="dialog" aria-labelledby="addAdvert" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{ route('adverts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouvelle annonce</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="title" class="col-md-2 col-form-label text-md-right">Titre</label>

                        <div class="col-md-9">
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="off" minlength="8" autofocus>

                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="category" class="col-md-2 col-form-label text-md-right">Catégorie</label>

                        <div class="col-md-9">
                            <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" required autocomplete="off">
                                @foreach($categories->all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="content" class="col-md-2 col-form-label text-md-right">Contenu</label>

                        <div class="col-md-9">
                            <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content" required minlength="20" autocomplete="off"></textarea>

                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pictures" class="col-md-2 col-form-label text-md-right">Images</label>

                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input id="pictures" type="file" class="custom-file-input @error('pictures') is-invalid @enderror" name="pictures[]" autocomplete="off" multiple data-buttonText="Parcourir">
                                    <label class="custom-file-label" for="pictures" aria-describedby="pictures">Parcourir</label>
                                </div>
                            </div>

                            @error('pictures')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Poster</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal" data-target="#addAdvert">Fermer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
