
@inject('users', 'App\Repositories\UserRepository')

@can('create', \App\Message::class)
    @if($advert->user->id === Auth::id())
        <div class="accordion" id="messages">
            @foreach($conversations as $userId => $conversation)
                <div class="card">
                    <div class="card-header" id="heading-{{ $userId }}">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-{{ $userId }}" aria-expanded="true" aria-controls="collapseOne">
                                Messages de {{ $users->find($userId)->name }}
                            </button>
                        </h2>
                    </div>

                    <div id="collapse-{{ $userId }}" class="collapse" aria-labelledby="heading-{{ $userId }}" data-parent="#messages">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach($conversation as $message)
                                    <li class="list-group-item @if($message->sender->id === Auth::id()) text-right @else text-left @endif"> {{ $message->content }} </li>
                                @endforeach

                                <li class="list-group-item">
                                    <form method="POST" action="{{ route('advert.message.create', $advert->id) }}">
                                        @csrf
                                        <div class="input-group">
                                            <input type="hidden" name="receiver" value="{{ $userId }}"/>
                                            <textarea id="messageContent" type="text" class="form-control" placeholder="Répondez lui donc..." name="content" required aria-label="messageContent" aria-describedby="messageContent"></textarea>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-success">Envoyer</button>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        @inject('messages', 'App\Repositories\MessageRepository')

        <div class="card">
            <div class="card-header">
                <div class="card-title">Messagerie</div>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($messages->getByAdvertAndUser($advert, Auth::user()) as $message)
                        <li class="list-group-item @if($message->sender->id === Auth::id()) text-right @else text-left @endif">{{ $message->content }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer">
                <form method="POST" action="{{ route('advert.message.create', $advert->id) }}">
                    @csrf
                    <div class="input-group">
                        <input type="hidden" name="receiver" value="{{ $advert->user->id }}"/>
                        <textarea id="messageContent" type="text" class="form-control" placeholder="Intéréssé ? Envoyez-lui donc un message !" name="content" required aria-label="messageContent" aria-describedby="messageContent"></textarea>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endcan
