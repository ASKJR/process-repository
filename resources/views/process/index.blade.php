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
                <h3><i class="fas fa-folder-open"></i> Processos - {{ $category->name }}</h3>
            </div>
            @if($isCommitteeMember)
                <div class="row">
                    <div class="col-md-12">
                        <div class="float-right">
                            <a href="{{ route('processes.create', $category->id ) }}" class="btn btn-sm btn-success">
                                <b>Criar processo <i class="fas fa-plus-circle"></i></b>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            <br>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="example" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Processo</th>
                                <th scope="col">Criado por</th>
                                <th scope="col">Criada em</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->processes as $process)
                                <tr>
                                    <td> {{ $process->name }} </td>
                                    <td> {{ $process->creator->name }} </td>
                                    <td> {{ $process->created_at->format('d/m/Y H:i') }} </td>
                                    <td>
                                    @component('components.modal.btn')
                                        @slot('class')
                                           btn btn-sm btn-show btnShowProcess
                                        @endslot
                                        @slot('target')
                                            #showProcess
                                        @endslot
                                        @slot('id')
                                            btnShowProcess
                                        @endslot
                                        <b data-show-id="{{ $process->id }}">Visualizar <i class="fas fa-search"></i></b>
                                    @endcomponent
                                    @if($isCommitteeMember)
                                        <a href="{{ route('processes.edit',['category' => $category->id, 'process' => $process->id]) }}" class=" btn btn-sm btn-primary"> <b>Editar <i class="fas fa-edit"></i></b></a>     
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Processo</th>
                                <th>Criado por</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit category MODAL--}}
    @component('components.modal.larger')
        @slot('id')
            showProcess
        @endslot
        @slot('title')
            Visualizar
        @endslot
        @slot('modalBodyId')
            showModalBodyId
        @endslot
    @endcomponent
@endsection

@section('own_js')
    <script>
        $(function(){
            $('#example').DataTable({
                "language": {
                    "url": ptBr
                }
            });
        });
        //Create category
        $('.btnShowProcess').on('click', function(e) {
            e.preventDefault();
            const process_id = $(this).find("b").attr('data-show-id');
            const category_id = {{ $category->id }}
            const url = `/category/${category_id}/processes/${process_id}`;
            renderHtmlInComponent(url, "showModalBodyId");
        });

    </script>
@endsection

