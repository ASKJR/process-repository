<form method="POST" action="{{ route('categories.store') }}">
    @csrf 
    <div class="form-group">
        <label for="lblCategoryName"><b>Nome da categoria:</b></label>
        <input class="form-control" type="text" name="name"placeholder="Ex. Processos ADX" required>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="visibility" id="exampleRadios1" value="public" checked>
        <label class="form-check-label" for="exampleRadios1">
            <b>Público <i class="fas fa-lock-open" style="color:#495FCB"></i></b>
        </label>
    </div>
    <span style="font-size: 0.8rem">
        <span style="color:#FF0000"><b>*</b></span> Qualquer usuário terá acesso aos processos dessa categoria.
    </span>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="visibility" id="exampleRadios2" value="restricted">
        <label class="form-check-label" for="exampleRadios2">
            <b>Privado <i class="fas fa-lock" style="color:#FF0000"></i></b>
        </label>
    </div>
    <span style="font-size: 0.8rem">
        <span style="color:#FF0000"><b>*</b></span> Somente os setores ou usuários especificados terão acesso aos processos dessa categoria.
    </span>
    <div class="restricted-permission" style="display: none;">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lblDepartmentsUsers"><b>Selecione um setor, ou usuário para liberar o acesso:</b></label>
                    <select id="selectPermission" class="form-control selectpicker" name="permissions[]" data-live-search="true"  
                        title="Selecione os setores que terão acesso a essa categoria."
                        multiple>
                        @foreach($groups as $group)
                            <option value="groupId_{{ $group->id }}" style="font-weight:bold">{{ $group->name }}</option>
                            @foreach($group->users as $user)
                                <option value="userId_{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lblPermissionList"><b>Lista de permissões:</b></label>
                    <textarea class="form-control permissionList" disabled  rows="8" required></textarea>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Criar categoria</button>
</form>