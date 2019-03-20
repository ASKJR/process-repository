@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                @component('components.btn.go-back')
                    @slot('route')
                        {{ route('processes.index', ['category' => $process->process_category_id]) }}
                    @endslot
                    Voltar
                @endcomponent
            </div>
            <br>
            <div class="row">
                <h3><i class="fas fa-folder-open"></i> Revisões - {{ $process->name }} </h3>
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
                                    #formCreateReview
                                @endslot
                                @slot('id')
                                    btnCreateReview
                                @endslot
                                <b>Criar revisão <i class="fas fa-plus-circle"></i></b>
                            @endcomponent
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    {{-- Create category MODAL--}}
    @component('components.modal.larger')
        @slot('id')
            formCreateReview
        @endslot
        @slot('title')
            Nova Revisão:
        @endslot
        @slot('modalBodyId')
            createModalBodyId
        @endslot
    @endcomponent
@endsection

@section('own_js')
    <script>
        //Create category
        $('#btnCreateReview').on('click', function(e){
            e.preventDefault();
            renderHtmlInComponent("{{ route('reviews.create', $process->id) }}", "createModalBodyId");
            $(".selectpicker").selectpicker().selectpicker("render");
        });
    </script>
@endsection

