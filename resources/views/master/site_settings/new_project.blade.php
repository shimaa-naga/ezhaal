<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ _i('Create Project Intro') }}</h3>
    </div>
    <div class="card-body p-6">
        <div class="panel panel-primary">
            <div class="tab-menu-heading">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        @php
                            $langs = \App\Language::all();
                        @endphp
                        @foreach ($langs as $lang)
                            <li class=""><a href="#tab{{ $lang->id }}" class=" @if ($loop->first) active @endif"
                                    data-toggle="tab">{{ $lang->title }}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <form method="POST" action="{{ url('master/settings/intro') }}" class="form-horizontal"
                data-parsley-validate="">
                @csrf
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content">
                        @php
                            $data =\App\Help\Settings::GetIntro();


                        @endphp
                        @foreach ($langs as $lang)
                            <div class="tab-pane  @if ($loop->first) active @endif " id="tab{{ $lang->id }}">
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label" id="examplenameInputname2">
                                                {{ _i('Header') }}</label>
                                        </div>
                                        <div class="col-md-9">

                                            <input type="text" name="title[{{ $lang->code }}]" class="form-control"
                                                placeholder="{{ _i('Header') }}" value="{!!$data->title->{$lang->code}!!}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label" id="examplenameInputname2">
                                                {{ _i('Intro') }}</label>
                                        </div>
                                        <div class="col-md-9">

                                            <textarea name="intro[{{ $lang->code }}]" class="form-control"
                                                placeholder="{{ _i('intro') }}">{!!$data->intro->{$lang->code}!!}</textarea>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        @endforeach


                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-info col-sm-12">{{ _i('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
