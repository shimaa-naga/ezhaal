@forelse($sliders as $query)
    @php
        $image = asset($query->image);
       // print_r($query );
        // $image = $slider->image != '' ? "<img class='img-thumbnail' src=" . $image . " >" : '';
        if ((int)$query->status == 0) {

            $published = '<a href="#" class="btn btn-round btn-xs btn-default"> ' . _i('Not Published') . '</a>';
        } else {

            $published= '<a href="#" class="btn btn-round btn-xs btn-success"> ' . _i('Published') . '</a>';
        }

        $html = '
						<a href ="#" data-toggle="modal" data-target="#modal-edit" class="btn waves-effect waves-light btn-primary edit text-center" title="' . _i("Edit") . '" data-id="' . $query->id . '"  data-url="' . $query->url . '" data-status="' . $query->status . '" data-image="' . $query->image . '">
							<i class="fa fa-edit"></i>
						</a>' . '
                    	<form class="delete" action="' . route("master.sliders.destroy", $query->id) . '"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form>';
                    $html .= '';

                    $langs = \App\Language::get();
                    $options = '';
                    foreach ($langs as $lang) {
                        $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="' . $query->id . '" data-lang="' . $lang->id . '" data-title="' . $lang->title . '"
                        style="display: block; padding: 5px 10px 10px;">' . $lang->title . '</a></li>';
                    }
                    $html = $html . '
                     <div class="btn-group">
                       <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" ' . _i('Translation') . ' ">
                         <span class="fa fa-cogs"></span>
                       </button>
                       <ul class="dropdown-menu">
                         ' . $options . '
                       </ul>
                     </div> ';
    @endphp
    <li>
        <figure>
            <img src="{{ $image }}?{{Str::random(5)}}" alt="img04">
            <figcaption>
                <h3>Mindblowing</h3>
                <span>lorem ipsume </span>
                <a class="fancybox" rel="group" href="{{ $image }}">Take a look</a>
            </figcaption>
        </figure>
        {!!$published!!} {!!$html!!}
    </li>
@empty
    <li>
        empty
    </li>
@endforelse
{{ $sliders->appends(Request::except('page'))->links() }}
