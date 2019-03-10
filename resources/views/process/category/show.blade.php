@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                @component('components.btn.go-back')
                    @slot('route')
                        {{ route('categories.index') }}
                    @endslot
                    Voltar
                @endcomponent
            </div>
            <br>
            <div class="row">
                <h3> Categoria: {{ $category->name }} </h3>
                <hr>
            </div>
             <div class="row">
                <p><b>Visibilidade:</b> {{ $category->visibility_translated }} {!! $category->visibility_icon !!} </p>
            </div>
             <div class="row">
                <p><b>Criado em:</b> {{ $category->created_at->format('d/m/Y') }}  </p>
            </div>
            <br>
            <hr>
            @if($category->visibility == 'restricted')
                <div class="row">
                    <h3>Permissões <i class="fas fa-shield-alt"></i></h3>
                </div>
                <div class="row">
                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Setores <i class="fas fa-building"></i></a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Usuários <i class="fas fa-users"></i></a>
                    </div>
                
                    <div class="tab-content" style="margin-top: auto;
margin-bottom: auto;" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list"> <b>&nbsp;{{ $groups }}</b></div>
                        <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list"> <b>&nbsp;{{ $users }}</b> </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection