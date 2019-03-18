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
                <h3><i class="fas fa-edit"></i> Editar processo:</h3>
            </div>
        </div>
        <form action="{{ route('processes.update', ['category' => $category->id, 'process' => $process->id]) }}" method="POST"  enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="selectCategoryLbl">Selecione a categoria*:</label>
                <select class="form-control" id="selectCategory" name="category" required>
                    @foreach($categories as $c)
                        <option value="{{$c->id}}" @if($c->id == $category->id) selected @endif> {{ $c->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nameLbl">Nome:</label>
                <input type="text" class="form-control" name="name" aria-describedby="emailHelp" placeholder="Nome do processo" value="{{ $process->name }}" required>
            </div>
            <div class="form-group">
                <label for="">Descrição:</label>
                <textarea class="form-control" name="description" id="" rows="3" placeholder="Descreva o processo e seu principal objetivo" required >{{ $process->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="nameLbl">Capa:</label>
                <input type="file" name="cover" class="file">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-paperclip"></i></span>
                    </div>
                    <input type="text" class="form-control" id="editCover" placeholder="Upload da capa do processo" aria-label="Upload File" aria-describedby="basic-addon1"value="capa.png" required>
                    <div class="input-group-append">
                        <button class="browse input-group-text searchFile" id="basic-addon2"><i class="fas fa-search"></i>  </button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Salvar alterações</button>
        </form>
    </div>
@endsection

@section('own_js')
 <script>
    $(function(){
        $('.browse').on('click', function(){
            $('#editCover').val('');
        });

        $('#selectCategory').on('change', () => {
            Swal.fire({
                title: 'Cuidado! Você tem certeza dessa ação?',
                text: "Alterar a categoria de um processo, pode modificar todas as permissões de acesso.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, alterar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                    'Alteração confirmada!',
                    'Não se esqueça de cliclar em Salvar alterações para finalizar.',
                    'success'
                    )
                }
                else {
                    $("#selectCategory option[value='{{$category->id}}']").prop('selected', true);
                }
            })
        });
    });

 </script>
@endsection