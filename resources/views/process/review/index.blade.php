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
            @foreach($process->reviews as $review)
                <li @if($loop->index%2 == 0) class="timeline-inverted" @endif>
                    <div class="timeline-badge"><a href="#" class="btn btn-sm btn-primary">{{ $review->created_at->format('d/m/Y') }}</a></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                        <h4 class="timeline-title">Relato da revisão</h4>
                         <p><small class="text-muted"><i class="fas fa-user"></i> By {{ $review->creator->name }}</small></p>
                        </div>
                        <div class="timeline-body">
                            <p> {{ $review->comments }} </p>
                            <hr>
                            <p><b>Dono do processo:</b> {{ $review->owner->name }}</p>
                            <p><b>Data limite para revisão:</b> {{ $review->review_due_date->format('d/m/Y H:i:s') }}</p>
                            <p><b>Arquivo: </b><a href="{{ route('reviews.download', ['process' => $process->id, 'review' => $review->id] ) }}">Download</a></p>
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

