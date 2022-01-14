@extends('master.layout.index' ,['title' => $category ." "._i('Attributes')])

@section('content')
    @php
    $type = '?';
    $btn = 'info';
    if (request()->query('type') != null) {
        $type = '?type=service';
        $btn = 'warning';
    }
    @endphp
    <!--breadcrumbs start -->
    <div class="page-header">
        @if (isset($attr) && $attr == 2)
            <h4 class="page-title">
                <a class="btn btn-{{ $btn }} text-white" href="cat_attr{{ $type }}">{{ $category }}
                    {{ _i('Attributes') }}</a>
                {{ $category }} {{ _i('Attributes2') }}
            </h4>
        @else
            <h4 class="page-title">{{ $category }} {{ _i('Attributes') }}
                <a class="btn btn-{{ $btn }} text-white" href="cat_attr2{{ $type }}">{{ $category }}
                    {{ _i('Attributes2') }}</a>
            </h4>
        @endif
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i>
                    {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item "><a
                    href="{{ url('master/project/category') }}">{{ _i('Projects Categories') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category }} {{ _i('Attributes') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->
    <div class="row">
        <div class="col-md-3">
            <div class="expanel expanel-default">
                <div class="expanel-heading"> {{ _i('Create Form') }}</div>
                <div class="expanel-body">
                    <form data-parsley-validate="" enctype="multipart/form-data" id="frm">
                        <div class="form-group">
                            <label>{{ _i('Language') }}</label>
                            {!! Form::select('lang', \App\Language::all()->pluck('title', 'id'), [], ['class' => 'form-control', 'id' => 'lang']) !!}
                        </div>
                        <div class="form-group">
                            <label for="title">{{ _i('Title') }}</label>
                            <input name="title" type="text" required class="form-control" id="title"
                                placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label for="placeholder">{{ _i('Place holder') }}</label>
                            <input name="placeholder" type="text" class="form-control" id="placeholder"
                                placeholder="Enter placeholder">
                        </div>
                        <div class="form-group">
                            <label for="selType">{{ _i('Type') }}</label>
                            <select id="selType" class="form-control" required name="selType">
                                <option>---</option>
                                <option value="text">{{ _i('Text') }}</option>
                                <option value="textarea">{{ _i('Multiline Text') }}</option>

                                <option value="radio">{{ _i('Radio') }}</option>
                                <option value="checkbox">{{ _i('Checkbox') }}</option>
                                <option value="select">{{ _i('Select Box') }}</option>
                                <option value="number">{{ _i('Number') }}</option>
                                <option value="multi-select">{{ _i('MultiSelect Box') }}</option>
                                <option value="doc">{{ _i('Document') }}</option>
                                <option value="image">{{ _i('Image') }}</option>
                                <option value="date">{{ _i('Date') }}</option>
                                <option value="url">{{ _i('URL') }}</option>
                                <option value="gps">{{ _i('Location') }}</option>
                                <option value="money">{{ _i('Money') }}</option>
                                <option value="range">{{ _i('Range') }}</option>


                            </select>
                        </div>
                        <div class="form-group">

                            @include("master.projects.projCategoryAttr.partial.icons")
                        </div>


                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="required" id="required">
                            <span class="custom-control-label">{{ _i('Required') }}</span>
                        </label>


                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" name="private" id="private" class="custom-control-input"
                                onchange="chkprivate()">
                            <label class="custom-control-label" for="private">{{ _i('Private') }}</label>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" name="front" id="front" class="custom-control-input">
                            <label class="custom-control-label" for="front">{{ _i('Hide from front attributes') }}</label>
                        </label>
                    </form>

                    <div class="inbox-body">
                        <button class="btn btn-compose" onclick="Add()">
                            {{ _i('Add') }}
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="expanel expanel-default">
                <div class="expanel-heading">
                    <h3 class="expanel-title">{{ _i('Preview') }}</h3>
                </div>
                <div class="expanel-body">
                    @include("master.projects.projCategoryAttr.partial.form")
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ _i('Options') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">

                        <div class="form-group row">
                            <label class="col-lg-2 control-label">{{ _i('Options') }}</label>
                            <div class="col-lg-10">
                                <textarea name="" id="txtOptions" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">

                                <button type="button" class="btn btn-send"
                                    onclick="setOptions()">{{ _i('OK') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    @include("master.projects.projCategoryAttr.partial.edit")
@endsection
@push('css')
    {{-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" /> --}}
    <style>
        select {
            font-family: fontAwesome
        }

    </style>
@endpush

@push('js')
    <script type="text/javascript">
        function chkedit_private() {
            if ($("#edit_private").is(":checked")) {
                $("#edit_front").prop("checked", false).attr("disabled", "disabled");
            } else
                $("#edit_front").removeAttr("disabled");
        }

        function ajaxGetData(lang, id) {
            $.ajax({
                url: "cat_attr{{ $attr }}/" + id + "{{ $type }}" + "&lang=" + lang,
                method: "GET",
                success: function(response) {
                    var item = response.item;
                    var details = response.details;
                    $("#edit_title").val("");
                    if (details != null) {
                        $("#edit_title").val(details.title);
                        $("#edit_placeholder").val(details.placeholder);

                        $("#data_id").val(details.id);
                    }
                    $("#id").val(item.id);
                    $("#smallModal").modal("show");
                    $("#edit_required").prop("checked", (item.required == 1));
                    $("#edit_private").prop("checked", (item.show_public != 1));
                    $("#edit_front").prop("checked", (item.front == 1));
                    //alert($(obj).data("lang_id"));
                    $("#lang_id").val(lang);
                    $("#smallModal").find("#icon").val(item.icon)
                    if (item.type == "text" || item.type == "number") {
                        $("#div_opt").hide();
                    } else {
                        if (details != null && details.options != null) {
                            var o = (details.options.join("\n"));
                            $("#edit_opt").text(o);
                        }
                        $("#div_opt").show();
                    }

                },
                error: function(jqXHR, exception) {

                    new Noty({
                        type: 'error',
                        layout: 'center',
                        text: "Error occured",
                        //timeout: 2000,
                        killer: false
                    }).show();
                },
            });



        }
    </script>
@endpush

@push('js')

    <script>
        options =
            `<div class="col-sm-3"> <button title=""  data-original-title="down" class="btn btn-sm tooltips btn-primary" type="button" onclick="down(this)"><i class="fa fa-sort-down"></i></button> <button title=""  type="button" data-original-title="up" class="btn btn-sm tooltips btn-primary" onclick="up(this)"><i class="fa fa-sort-up"></i></button> <button title="" type="button" data-original-title="Trash" class="btn btn-sm del tooltips btn-danger" onclick="deleteMe(this)"><i class="fa fa-trash-o"></i></button>  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        {{ _i('More') }}<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" x-placement="bottom-start">
        <li><a class='dyn' href="#" data-lang="{{ \App\Help\Utility::getLang() }}">{{ _i('Edit') }}</a></li>
        @foreach (\App\Language::where('code', '!=', App::getLocale())->get() as $lang)
            <li><a class='dyn' href="#" data-lang='{{ $lang->id }}'>{{ $lang->title }}</a></li>
        @endforeach

    </ul></div>`;
        var type = "",
            title = "",
            required = false;
        var text = "";

        function bind() {
            $("a.dyn").click(function() {
                //Do stuff when clicked
                getId(this, $(this).data("lang"));
            });
        }

        function getId(obj, lang) {
            var row = $(obj).closest("div.myrow");
            //  alert(row);
            id = ($(row).find(".del").data("id"));
            ajaxGetData(lang, id);
        }

        function setOptions() {
            var lines = $("#txtOptions").val().split('\n');
            var child = "";

            if (type == "select") {
                $.each(lines, function(i, item) {
                    child += `<option>${item}</option>`
                })
                $("#render").append(
                    `<div class="form-group myrow"><div class="row"><label class="col-sm-2 col-form-label">${text}</label><div class="col-sm-7"><select class="form-control" >${child} </select></div>${options}</div></div>`
                );
            } else if (type == "multi-select") {
                $.each(lines, function(i, item) {
                    child += `<option>${item}</option>`
                })
                $("#render").append(
                    `<div class="form-group myrow"><div class="row"><label class="col-sm-2 col-form-label">${text}</label><div class="col-sm-7"><select multiple='' class="form-control" >${child} </select></div>${options}</div></div>`
                );
            } else if (type == "checkbox" || type == "radio") {
                _class = (type=="radio")? "radio": "check";
                $.each(lines, function(i, item) {
                    child +=
                        `
                        <div class="custom-controls-stacked">
                                        <label class="custom-control custom-${_class}">
                                            <input type="${type}" class="custom-control-input">
                                            <span class="custom-control-label">${item}</span>
                                        </label>
                                    </div>
                        `
                });
                $("#render").append(
                    `<div class="form-group myrow"><div class="row"><label class="col-sm-2 col-form-label">${text}</label>
                                                                            <div class="col-sm-7">${child}</div>${options}</div></div>`
                );
            }
            ajaxAdd(title, type, required, lines);

            $('#myModal').modal("hide");

        }

        function Add() {
            bol = $("#frm").parsley().validate();
            if (!bol) return;
            type = $("#selType").val();
            title = $("#title").val();
            required = $("#required").is(":checked");
            text = title;
            if (required) {
                text = "<span class='text-danger'> *</span> " + title;
            }
            if (!$("#private").is(":checked")) {
                text = "<i class='fa fa-eye'></i> " + text;
            }
            switch (type) {
                // case "text":
                //     $("#render").append(
                //         `<div class="form-group myrow"><div class="row"><label class="col-sm-2 col-form-label">${text}</label><div class="col-sm-7"><input type="text" class="form-control" ></div>${options}</div></div>`
                //     );
                //     ajaxAdd(title, type, required, []);
                //     break;
                // case "number":
                //     $("#render").append(
                //         `<div class="form-group myrow"><div class="row"><label class="col-sm-2 col-form-label">${text}</label><div class="col-sm-7"><input type="number" class="form-control" ></div>${options}</div></div>`
                //     );
                //     ajaxAdd(title, type, required, []);
                //     break;
                case "select":
                    $('#myModal').modal({
                        show: true
                    });

                    break;
                case "multi-select":
                    $('#myModal').modal({
                        show: true
                    });

                    break;
                case "checkbox":
                    $('#myModal').modal({
                        show: true
                    });
                    break;
                case "radio":
                    $('#myModal').modal({
                        show: true
                    });
                    break;
                case "image":
                    $("#render").append(
                        `<div class="form-group myrow"><div class="row"><label class="col-sm-2 col-form-label">${text}</label><div class="col-sm-7"><input type="file" class="form-control"  accept="image/gif, image/jpeg"></div>${options}</div></div>`
                    );
                    ajaxAdd(title, type, required, []);
                    break;
                case "doc":
                    $("#render").append(
                        `<div class="form-group myrow"><div class="row"><label class="col-sm-2 col-form-label">${text}</label><div class="col-sm-7"><input type="file" class="form-control" accept="application/pdf,application/msword,
                            application/vnd.openxmlformats-officedocument.wordprocessingml.document"></div>${options}</div></div>`
                    );
                    ajaxAdd(title, type, required, []);
                    break;
                case "money":
                    $("#render").append(
                        `<div class="form-group myrow"><div class="row"><label class="col-sm-2 col-form-label">${text}</label><div class="col-sm-7"><input type="number" min=".01" class="form-control" ></div>${options}</div></div>`
                    );
                    ajaxAdd(title, type, required, []);
                    break;
                case "range":
                    $("#render").append(
                        `<div class="form-group myrow"><div class="row"><label class="col-sm-2 col-form-label">${text}</label><div class="col-sm-3 form-group"><input type="number"  class="form-control" > </div>  <div class="form-group col-sm-1">/
                    </div>
                        <div class="form-group col-sm-3">
                            <input type="text" class="form-control" />
                        </div>${options}</div></div>`
                    );
                    ajaxAdd(title, type, required, []);
                    break;
                default:
                    $("#render").append(
                        `<div class="form-group myrow"><div class="row"><label class="col-sm-2 col-form-label">${text}</label><div class="col-sm-7"><input type="${type}" class="form-control" ></div>${options}</div></div>`
                    );
                    ajaxAdd(title, type, required, []);
            }
        }

        function chkprivate() {
            if ($("#private").is(":checked")) {
                $("#front").prop("checked", false).attr("disabled", "disabled");
            } else
                $("#front").removeAttr("disabled");

        }

        function up(obj) {
            var row = $(obj).parents(".myrow:first");

            id = ($(row).find(".del").data("id"));

            $.ajax({
                url: "cat_attr{{ $attr }}/up/" + id,
                method: "POST",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status === "ok") {

                        row.insertBefore(row.prev());
                    }
                },
                error: function(jqXHR, exception) {
                    $("#render").children(".foorm-group:last").remove();
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    new Noty({
                        type: 'error',
                        layout: 'center',
                        text: msg,
                        //timeout: 2000,
                        killer: false
                    }).show();
                },
            });

        }

        // function pay(obj) {
        //     bol = $(obj).is(":checked");
        //     //alert(bol);
        //     $.ajax({
        //         url: "cat_attr/pay",
        //         method: "Put",
        //         type: "PuT",
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             val: bol
        //         },
        //         success: function(response) {
        //             if (response.status == 'ok') {

        //                 new Noty({
        //                     type: 'success',
        //                     layout: 'topRight',
        //                     text: "{{ _i('Saved Successfully') }}",
        //                     timeout: 2000,
        //                     killer: true
        //                 }).show();

        //             }
        //         },
        //         error: function(jqXHR, exception) {
        //             $("#render").children(".myrow:last").remove();
        //             var msg = '';
        //             if (jqXHR.status === 0) {
        //                 msg = 'Not connect.\n Verify Network.';
        //             } else if (jqXHR.status == 404) {
        //                 msg = 'Requested page not found. [404]';
        //             } else if (jqXHR.status == 500) {
        //                 msg = 'Internal Server Error [500].';
        //             } else if (exception === 'parsererror') {
        //                 msg = 'Requested JSON parse failed.';
        //             } else if (exception === 'timeout') {
        //                 msg = 'Time out error.';
        //             } else if (exception === 'abort') {
        //                 msg = 'Ajax request aborted.';
        //             } else {
        //                 msg = 'Uncaught Error.\n' + jqXHR.responseText;
        //             }
        //             new Noty({
        //                 type: 'error',
        //                 layout: 'center',
        //                 text: msg,
        //                 //timeout: 2000,
        //                 killer: false
        //             }).show();
        //         },
        //     });

        // }

        function down(obj) {
            var row = $(obj).parents(".myrow:first");
            id = ($(row).find(".del").data("id"));

            $.ajax({
                url: "cat_attr{{ $attr }}/down/" + id,
                method: "POST",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status === "ok") {

                        row.insertAfter(row.next());
                    }
                },
                error: function(jqXHR, exception) {
                    $("#render").children(".myrow:last").remove();
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    new Noty({
                        type: 'error',
                        layout: 'center',
                        text: msg,
                        //timeout: 2000,
                        killer: false
                    }).show();
                },
            });



        }

        function ajaxAdd(title, type, required, items) {
            $.ajax({
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    title: title,
                    type: type,
                    required: required,
                    private: $("#private").is(":checked"),
                    front: $("#front").is(":checked"),
                    icon: $("#icon").val(),
                    placeholder: $("#placeholder").val(),

                    lang_id: $("#lang").val(),
                    items: items
                },
                dataType: 'json',
                success: function(response) {
                    if (response.errors) {
                        $('#masages_model').empty();
                        $.each(response.errors, function(index, value) {
                            $('#masages_model').show();
                            $('#masages_model').append(value + "<br>");
                        });
                    }
                    if (response.status == 'ok') {
                        $("#render").children(".myrow:last").find("button.del").last().attr("data-id", response
                            .id);
                        bind();
                        // $("#render").children(".myrow:last").find("a.dyn").last().attr("data-id", response.id);

                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Saved Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();

                    }
                },
                error: function(jqXHR, exception) {
                    $("#render").children(".myrow:last").remove();
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    new Noty({
                        type: 'error',
                        layout: 'center',
                        text: msg,
                        //timeout: 2000,
                        killer: false
                    }).show();
                },

            });

        }

        function deleteMe(obj) {
            var id = $(obj).data("id");
            $.ajax({
                url: "cat_attr{{ $attr }}/" + id,
                method: "delete",
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.data === true) {
                        var row = $(obj).parents(".myrow:first").remove();
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: "{{ _i('Deleted Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();

                    }
                },
                error: function(jqXHR, exception) {
                    $("#render").children(".myrow:last").remove();
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    new Noty({
                        type: 'error',
                        layout: 'center',
                        text: msg,
                        //timeout: 2000,
                        killer: false
                    }).show();
                },
            });
        }
    </script>
@endpush
