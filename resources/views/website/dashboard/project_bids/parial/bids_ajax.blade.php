@forelse($bids as $item)
@include("website.dashboard.project_bids.parial.bid_item")
@empty
    {{ _i('There are no bids') }}
@endforelse

<div class="col-md-8 offset-md-4">
    {{ $bids->appends(Request::except('page'))->links() }}
</div>
