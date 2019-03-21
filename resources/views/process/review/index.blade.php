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
        <ul class="timeline">
            {{-- <li class="timeline-inverted">
            <div class="timeline-panel">
                <div class="timeline-heading">
                <h4 class="timeline-title">Mussum ipsum cacilds</h4>
                </div>
                <div class="timeline-body">
                <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
                </div>
            </div>
            </li> --}}
            @foreach($process->reviews as $review)
                <li @if($loop->index%2 == 0) class="timeline-inverted" @endif>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                        <h4 class="timeline-title">Mussum ipsum cacilds</h4>
                        </div>
                        <div class="timeline-body">
                        <p>{{ $review->comments }}</p>
                        </div>
                    </div>
                </li>
            @endforeach
    </ul>
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

