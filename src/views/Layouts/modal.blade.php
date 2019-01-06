<!-- Button trigger modal -->
<button type="button" class="{{ $btnClass ?? 'btn btn-primary' }}" data-toggle="modal" data-target="#{{ $id ?? 'myModal' }}">
    {{ $button ?? 'Demo modal' }}
</button>

<!-- Modal -->
<div class="modal fade" id="{{ $id ?? 'myModal' }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ $title ?? 'Modal title' }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {{ $content ?? 'Are you sure?' }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                @if($action)
                    <form action="{{ $action }}" method="{{ $method != 'GET' ? 'POST' : "GET" }}" class="{{ $formClass ?? 'left' }}">
                        @if(isset($method) && $method != 'GET')
                            {{ $method == 'DELETE' ? method_field('DELETE') : '' }}
                            {{ csrf_field() }}
                        @endif
                        <button type="submit" class="btn btn-primary">{{ $confirm ?? 'Save changes' }}</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

