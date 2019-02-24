@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <h3>Categorias</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="float-right">
                        @component('components.modal.btn')
                            @slot('class')
                                btn btn-sm btn-primary
                            @endslot
                            @slot('target')
                                #formCreateCategory
                            @endslot
                            @slot('id')
                                btnCreateCategory
                            @endslot
                            Criar categoria
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('components.modal.larger')
        @slot('id')
            formCreateCategory
        @endslot
        @slot('title')
            Nova Categoria de processo:
        @endslot
    @endcomponent
@endsection
@section('own_js')
    <script>
        $('#btnCreateCategory').click(() => {
            renderHtmlInComponent("{{ route('categories.create') }}");
            $("[name=departments]").selectpicker({
                "title": "Selecione os setores que terão acesso a essa categoria."        
            }).selectpicker("render");
            $("[name=users]").selectpicker({
                "title": "Selecione os usuários que terão acesso a essa categoria."        
            }).selectpicker("render");
        });
    </script>
@endsection

