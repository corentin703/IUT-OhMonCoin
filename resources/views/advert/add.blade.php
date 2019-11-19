
<div id="btnDock" class="btn-group dropup dock_group">
    <div>
        <button id="btnAddAdvert" class="btn btn-primary" onclick="$('#addAdvert').modal()">Ajouter une annonce</button>
    </div>
</div>

<div class="modal fade" id="addAdvert" tabindex="-1" role="dialog" aria-labelledby="addAdvert" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{ route('advert.store') }}" enctype="multipart/form-data">
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
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="off" autofocus>

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
                            <input id="category" type="text" class="form-control @error('category') is-invalid @enderror" name="category" required autocomplete="off">

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
                            <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content" required autocomplete="off"></textarea>

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
{{--                            <input type="hidden" name="MAX_FILE_SIZE" value="5242880"/> --}}{{-- 5Mb max --}}
                            <input id="pictures" type="file" class="form-control @error('pictures') is-invalid @enderror" name="pictures[]" required autocomplete="off" multiple>

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
