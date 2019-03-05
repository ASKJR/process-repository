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
            <br>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="example" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Categoria</th>
                                <th scope="col">Visibilidade </th>
                                <th scope="col">Criada em</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $categorie)
                                <tr>
                                    <td> {{ $categorie->name }} </td>
                                    @if($categorie->visibility == 'public')
                                        <td>
                                            <p class="btn btn-sm btn-success">{{ $categorie->visibility_translated }} {!! $categorie->visibility_icon !!}</p>
                                        </td>
                                    @else
                                        <td>
                                            <p class="btn btn-sm btn-danger">{{ $categorie->visibility_translated }} {!! $categorie->visibility_icon !!}</p>
                                        </td>
                                    @endif
                                    <td> {{ $categorie->created_at->format('d/m/Y H:i') }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Visibilidade</th>
                                <th>Criada em</th>
                            </tr>
                        </tfoot>
                    </table>
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
        $(function(){
            $('#example').DataTable({
                "language": {
                    "url": ptBr
                }
            });
        });
        $('#btnCreateCategory').click(() => {
            
            renderHtmlInComponent("{{ route('categories.create') }}");
            $(".selectpicker").selectpicker().selectpicker("render");

            //category permission actions
            $('input[type=radio][name=visibility]').on('change',function() {
                const divRestricted = $('#restricted-permission');
                if (this.value == 'public') {
                    divRestricted.hide();
                    $('#selectPermission').attr('required',false);

                }
                else if (this.value == 'restricted') {
                    divRestricted.show();
                    $('#selectPermission').attr('required',true);
                }
            });
            $('#selectPermission').on('change', function(e) {
                var selected = [];
                $.each($(".selectpicker option:selected"), function(){
                    selected.push($(this).text());
                });
                $('#permissionList').val(selected.join('\n'));
            });
        });
    </script>
@endsection

