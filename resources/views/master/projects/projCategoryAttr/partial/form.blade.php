<div id="render" class="form-horizontal">

    @if ($items != null)
        @foreach ($items as $item)

            @php
                $trans = $item->trans(App::getLocale());
            @endphp
            <div class="form-group myrow">
                <div class="row ">
                    <label class="col-sm-2 ">
                        @if ($item->required == 1) <span class="text-danger">*</span>
                        @endif
                        @if ($item->show_public == 1) <i class="fa fa-eye"></i>
                        @endif
                        @if ($item->front == 1) <i class="fa fa-globe"></i>
                        @endif
                        {{ $trans == null ? '' : $trans->title }}
                    </label>
                    <div class=" {{ $item->type == 'range' ? 'form-group col-sm-3' : 'col-sm-7' }}">
                        @if ($item->type == 'select')
                            <select class="form-control">
                                @if ($trans != null)
                                    @foreach ($trans->options as $child)
                                        <option>{{ $child }}</option>
                                    @endforeach
                                @endif
                            </select>
                        @elseif($item->type=="multi-select")
                            <select class="form-control" multiple="">
                                @if ($trans != null)
                                    @foreach ($trans->options as $child)
                                        <option>{{ $child }}</option>
                                    @endforeach
                                @endif
                            </select>
                        @elseif($item->type=="radio" || $item->type=="checkbox")
                            @if ($trans != null && is_array($trans->options))
                                @foreach ($trans->options as $child)
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-{{($item->type=="radio")? "radio" : "check"}}">
                                            <input type="{{ $item->type }}" class="custom-control-input">
                                            <span class="custom-control-label">{{ $child }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        @elseif($item->type=="image" )
                            <input type="file" accept="image/gif, image/jpeg" />
                            @elseif($item->type=="textarea" )
                            <textarea class="form-control"></textarea>
                        @elseif($item->type=="money" )
                            <input type="number" class="form-control" />
                        @elseif($item->type=="range" )
                            <input type="text" class="form-control" />

                        @elseif($item->type=="doc" )
                            <input type="file" accept="application/pdf,application/msword,
                            application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                        @else
                            <input type="{{ $item->type }}" class="form-control">
                        @endif
                    </div>
                    @if ($item->type == 'range')
                        <div class="form-group col-sm-1">/
                        </div>
                        <div class="form-group col-sm-3">
                            <input type="text" class="form-control" />
                        </div>
                    @endif
                    @include('master.projects.projCategoryAttr.partial.options',["id"=>$item->id])

                </div>
            </div>
        @endforeach
    @endif
</div>
