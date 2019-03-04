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
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">name</th>
                            <th scope="col">created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $categorie)
                                <tr>
                                    <th scope="row">{{ $categorie->id }}</th>
                                    <td>{{ $categorie->name }}</td>
                                    <td>{{ $categorie->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
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

