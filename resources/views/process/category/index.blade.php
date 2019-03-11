@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <h3>Categorias de processos</h3>
            </div>
            @if($isCommitteeMember)
                <div class="row">
                    <div class="col-md-12">
                        <div class="float-right">
                            @component('components.modal.btn')
                                @slot('class')
                                    btn btn-sm btn-success
                                @endslot
                                @slot('target')
                                    #formCreateCategory
                                @endslot
                                @slot('id')
                                    btnCreateCategory
                                @endslot
                                <b>Criar categoria <i class="fas fa-plus-circle"></i></b>
                            @endcomponent
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
                                <th scope="col">Categoria</th>
                                <th scope="col">Visibilidade </th>
                                <th scope="col">Criada em</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td> {{ $category->name }} </td>
                                    @if($category->visibility == 'public')
                                        <td>
                                            <p class="btn btn-sm btn-success"><b>{{ $category->visibility_translated }} {!! $category->visibility_icon !!}</b></p>
                                        </td>
                                    @else
                                        <td>
                                            <p class="btn btn-sm btn-danger"><b>{{ $category->visibility_translated }} {!! $category->visibility_icon !!}</b></p>
                                        </td>
                                    @endif
                                    <td> {{ $category->created_at->format('d/m/Y H:i') }} </td>
                                    <td>
                                        @if($isCommitteeMember)     
                                            @component('components.btn.show')
                                                @slot('route')
                                                    {{route('categories.show',$category->id)}}
                                                @endslot
                                                Visualizar
                                            @endcomponent
                                            @component('components.modal.btn')
                                                @slot('class')
                                                    btn btn-sm btn-primary btnEditCategory
                                                @endslot
                                                @slot('target')
                                                    #formEditCategory
                                                @endslot
                                                @slot('id')
                                                    btnEditCategory
                                                @endslot
                                                <b data-edit-id="{{ $category->id }}">Editar <i class="fas fa-edit"></i></b>
                                            @endcomponent
                                        @endif
                                        <a href="{{ route ('processes.index', $category->id ) }}" class="btn btn-sm" style="background-color:#f4cc04"><b> Processos</b> <i class="fas fa-folder-open"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Visibilidade</th>
                                <th>Criada em</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Create category MODAL--}}
    @component('components.modal.larger')
        @slot('id')
            formCreateCategory
        @endslot
        @slot('title')
            Nova Categoria:
        @endslot
        @slot('modalBodyId')
            createModalBodyId
        @endslot
    @endcomponent

    {{-- Edit category MODAL--}}
    @component('components.modal.larger')
        @slot('id')
            formEditCategory
        @endslot
        @slot('title')
            Editar Categoria:
        @endslot
        @slot('modalBodyId')
            editModalBodyId
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
        $('#btnCreateCategory').on('click', function(e){
            e.preventDefault();
            renderHtmlInComponent("{{ route('categories.create') }}", "createModalBodyId");
            $(".selectpicker").selectpicker().selectpicker("render");
            categoryPermitionsActions('formCreateCategory');
            
        });

        //Edit category
        $('.btnEditCategory').on('click', function(e) {
            const category_id = $(this).find("b").attr('data-edit-id');
            const url = '{{ route("categories.edit",":id") }}'.replace(':id',category_id);
            renderHtmlInComponent(url, "editModalBodyId");
            $(".selectpicker").selectpicker().selectpicker("render");
            categoryPermitionsActions('formEditCategory');
            fillPermissionTextArea('#formEditCategory');
        });

        function categoryPermitionsActions(id)
        {
            //category permission actions
            id = '#' + id;
            $(document).on('change', id + " .form-check-input",function() {
                const divRestricted = $('.restricted-permission');
                if (this.value == 'public') {
                    divRestricted.hide();
                    $('.selectpicker').attr('required',false);

                }
                else if (this.value == 'restricted') {
                    divRestricted.show();
                    $('.selectpicker').attr('required',true);
                }
            });
            $('.selectpicker').on('change', function(e) {
                fillPermissionTextArea(id);    
            });
        }

        function fillPermissionTextArea(id)
        {
            let selected = [];
            $('.permissionList').html('');
            $.each($(id + " .selectpicker option:selected"), function(){
                selected.push($(this).text());
            });
            $('.permissionList').val(selected.join('\n'));
            selected = [];
        }
    </script>
@endsection

