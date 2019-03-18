@extends('layouts.app')
@section('content')
    <div class="container">
       <div class="row">
            @component('components.btn.go-back')
                @slot('route')
                    {{ route('processes.index', $category->id) }}
                @endslot
                Voltar
            @endcomponent
        </div>
        <br>
        <div class="col-md-12">
            <div class="row">
                <h3><i class="fas fa-plus-circle" style="color:#49a360"></i> Novo Processo:</h3>
            </div>
        </div>
        <form action="{{ route('processes.store', $category->id) }}" method="POST"  enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nameLbl">Categoria:</label>
                <input class="form-control" type="text" placeholder="{{ $category->name }}" readonly>
            </div>
            <div class="form-group">
                <label for="nameLbl">Nome:</label>
                <input type="text" class="form-control" name="name" aria-describedby="emailHelp" placeholder="Nome do processo" required>
            </div>
            <div class="form-group">
                <label for="">Descrição:</label>
                <textarea class="form-control" name="description" id="" rows="3" placeholder="Descreva o processo e seu principal objetivo" required></textarea>
            </div>
            <div class="form-group">
                <label for="nameLbl">Capa:</label>
                <input type="file" name="cover" class="file">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-paperclip"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Upload File" aria-label="Upload File" aria-describedby="basic-addon1" required>
                    <div class="input-group-append">
                        <button class="browse input-group-text searchFile" id="basic-addon2"><i class="fas fa-search"></i>  </button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Criar processo</button>
        </form>
    </div>
@endsection