@extends('model_conversations.model_conversations_menu')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/model_conversations/playlist.css')}}">
@endsection
@section('section')
    <main class="main_part">
        <div class="playlist">
            <div class="playlist-header">
                <h3>{{$playlist->first()->playlist_name}}</h3>
                <hr>
            </div>
            <div class="playlist-control">
                Panel kontrolny
                <hr>
            </div>
            <div class="playlist-body">
                <table class="table table-stripped">
                    <thead>
                    <tr>
                        <th>Odtwarzanie</th>
                        <th>Nazwa</th>
                        <th>Prezent</th>
                        <th>Trener</th>
                        <th>Klient</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($playlist as $item)
                    <tr>
                        <td>Tu player</td>
                        <td>{{$item->conv_name}}</td>
                        <td>{{$item->gift}}</td>
                        <td>{{$item->trainer}}</td>
                        <td>{{$item->client}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </main>
@endsection


@section('script')
    <script>
        //In this script we define global variables and php variables
        let PLAYLIST = {
            DOMElements: {
                categoriesBox: document.querySelector('.categories-box')
            },
            globalVariables: {
                playlist: @json($playlist),
                url: `{{asset('storage/')}}`
            }
        };
    </script>

@endsection