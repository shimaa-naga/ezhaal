
<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ _i('Edit role') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('master.roles.update', 1) }}" method='post' id='edit-form'>
                    @csrf
                    <input type="hidden" name='id' id='modal-id'>
                    <div class="form-group ">
                        <div class="row">
                            <label for="exampleInputEmail1">{{ _i('Name') }}</label>
                        <input type="text" class="form-control modal-name" name='name'>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label for="exampleInputEmail1">{{ _i('Permissions') }}</label>
                        <select name="permissions[]" class='js-example-tags permissions form-control' multiple>
                            @foreach( $permissions AS $permission )
                                <option value="{{ $permission->name }}">{{ $permission->title }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light" form='edit-form'>
                    {{ _i('Save') }}
                </button>
            </div>
        </div>
    </div>
</div>
