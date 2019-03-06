<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">{{ $title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        <div class="modal-body" id="{{ $modalBodyId }}">
            {{ $slot }}
        </div>
        </div>
    </div>
</div>