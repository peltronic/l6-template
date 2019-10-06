@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>Listing / Show #{{ $listing->id }}</h1>
      </div>

      <div class="card-body">
        <div class="card-block bg-light">
          <div class="row">
            <div class="col-md-6">
              <a class="btn btn-link" href="{{ route('listings.index') }}"><- Back</a>
            </div>
            <div class="col-md-6">
              <a class="btn btn-sm btn-warning float-right mt-1" href="{{ route('listings.edit', $listing->id) }}">
                Edit
              </a>
            </div>
          </div>
        </div>
        <br>

        <label>     Guid</label>
<p>
	{{ $listing->     guid }}
</p> <label>   Slug</label>
<p>
	{{ $listing->   slug }}
</p> <label>   Account_id</label>
<p>
	{{ $listing->   account_id }}
</p> <label>   Ltitledescription</label>
<p>
	{{ $listing->   ltitledescription }}
</p> <label>   Ldesc</label>
<p>
	{{ $listing->   ldesc }}
</p> <label>   Jsonattrs</label>
<p>
	{{ $listing->   jsonattrs }}
</p>
      </div>
    </div>
  </div>
</div>

@endsection
