@extends('website.dashboard.index_inner', ['title' => _i('Tickets')])

@section('content')
    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3"
            data-image-src="{{ asset('website2/assets/images/banners/banner2.jpg') }}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{ _i('My Tickets') }}</h1>
                        <ol class=" breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{ _i('Home') }}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{ _i('My Tickets') }}</li>
                            </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Breadcrumb-->

    <!--User Dashboard-->
    <section class="sptb">
        <div class="container">
            <div class="row">
                @include("website.dashboard.complaints.complaint_nav")
                <div class="col-xl-9 col-lg-9 col-md-9">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{ _i('My Tickets') }}</h3>
                        </div>

                        <div class="card-body">

                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ _i('Ticket title') }}</th>
                                        <th scope="col">{{ _i('Status') }}</th>
                                        <th scope="col">{{ _i('Date') }}</th>
                                        <th scope="col">{{ _i('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <th scope="row">
                                                <p><a
                                                        href="{{ route('website.complaints.editTicket', $ticket->complaint_id) }}">{{ $ticket->complaint_id }}</a>
                                                </p>
                                            </th>
                                            <td>
                                                <p>{{ Illuminate\Support\Str::words($ticket->title, 5, '..') }}</p>
                                            </td>
                                            <td>
                                                <a class="btn btn-round btn-sm btn-dark">
                                                    {{ $ticket->Parent->statusDataWithLang() != null ? $ticket->Parent->statusDataWithLang()->title : '' }}
                                                    {{-- {{\App\Models\Complaints\Complaints::where('id',$ticket->complaint_id)->first()->statusDataWithLang()['title'] }} --}}
                                                </a>
                                            </td>
                                            <td>
                                                <p>{{ date('d M Y, h:i A ', strtotime($ticket->created)) }}</p>
                                            </td>
                                            <td>
                                                <a href="{{ route('website.complaints.editTicket', $ticket->complaint_id) }}"
                                                    title="{{ _i('Show ticket') }}"><button
                                                        class="btn btn-primary btn-sm"><i
                                                            class="fa fa-eye"></i></button></a>
                                                <a href="{{ route('website.complaints.deleteTicket', $ticket->complaint_id) }}"
                                                    title="{{ _i('Delete ticket') }}"><button
                                                        class="btn btn-danger btn-sm"><i
                                                            class="fa fa-trash-o"></i></button></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/User Dashboard-->



    <!-- Content section End -->
@endsection
