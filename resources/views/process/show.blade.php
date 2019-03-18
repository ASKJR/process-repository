<div class="text-center">
    <img src="{{ $imgSrc }}" class="rounded mx-auto d-block" alt="200x200" with="200" height="200">
</div>
<div class="container">
    <p> <b> Categoria: </b> {{ $category->name }} </p>
    <p> <b> Visibilidade: </b> {{ $category->visibility_translated }} {!! $category->visibility_icon !!}</p>
    <p> <b> Processo: </b> {{ $process->name }} </p>
    <p> <b> Criado por: </b> {{ $process->creator->name }} </p>
    <p> <b> Criado em: </b> {{ $process->created_at->format('d/m/Y H:i') }} </p>
    <div class="form-group">
        <label for=""> <b>Descrição:</b></label>
        <textarea class="form-control" disabled name="" id="" rows="3">{{ $process->description }}</textarea>
    </div>
</div>