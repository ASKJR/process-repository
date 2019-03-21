<form method="POST" action="{{ route('reviews.store', $process->id) }}" enctype="multipart/form-data">
    @csrf 
    <div class="form-group">
        <label for="lblProcessOwner"><b>Dono do processo:</b></label>
        <select class="selectpicker form-control" name="owner_id" data-live-search="true" 
        title="Selecione o do processo" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="lblReviewDueDate"><b>Data da revisão:</b></label>
        <input class="form-control" data-provide="datepicker" name="review_due_date" data-date-format="dd/mm/yyyy"  name="review_due_date"placeholder="Data da revisão" required>
    </div>
    <div class="form-group">
        <label for="nameLbl"><b>Upload de arquivo:</b></label>
        <input type="file" name="processFile" class="file">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-paperclip"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Upload File" aria-label="Upload File" aria-describedby="basic-addon1" required>
            <div class="input-group-append">
                <button class="browse input-group-text searchFile" id="basic-addon2"><i class="fas fa-search"></i>  </button>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="commentLbl"> <b>Comentário:</b></label>
        <textarea class="form-control" name="comments" id="" rows="3" required></textarea>
    </div>
    <hr>
    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Criar revisão</button>
</form>