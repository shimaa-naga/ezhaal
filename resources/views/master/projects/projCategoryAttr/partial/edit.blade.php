<div id="smallModal" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">{{ _i('Edit') }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="cat_attr{{ $attr }}/save">
                @csrf

                <div class="modal-body">

                    <div class="form-group">
                        <label for="edit_title" class="form-control-label">{{ _i('Title') }}:</label>
                        <input type="text" required="" name="edit_title" class="form-control" id="edit_title">
                    </div>
                    <div class="form-group">
                        <label for="placeholder" class="form-control-label">{{ _i('Place holder') }}</label>
                        <input name="edit_placeholder" type="text" class="form-control" id="edit_placeholder" placeholder="Enter placeholder">
                    </div>
                    <div class="form-group">

                        @include("master.projects.projCategoryAttr.partial.icons")
                     </div>
                    <div class="form-group" style="display: none" id="div_opt">
                        <label for="edit_opt" class="form-control-label">{{ _i('Options') }}:</label>
                        <textarea name="edit_opt" class="form-control" id="edit_opt"></textarea>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" name="edit_required" id="edit_required">
                        <label class="form-check-label" for="edit_required">{{ _i('Required') }}</label>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" name="edit_private" id="edit_private" class="form-check-input"
                            onchange="chkedit_private()">
                        <label class="form-check-label" for="edit_private">{{ _i('Private') }}</label>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" name="edit_front" id="edit_front" class="form-check-input">
                        <label class="form-check-label" for="edit_front">
                            {{ _i('Display at front') }}
                        </label>
                    </div>

                </div><!-- modal-body -->
                <div class="modal-footer">
                    <input type="hidden" name="lang_id" id="lang_id" value="">

                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="data_id" id="data_id" value="">

                    <button type="submit" class="btn btn-primary">{{ _i('Save changes') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('Close') }}</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->
