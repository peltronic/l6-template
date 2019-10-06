@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>Account / Show #{{ $account->id }}</h1>
      </div>

      <div class="card-body">
        <div class="card-block bg-light">
          <div class="row">
            <div class="col-md-6">
              <a class="btn btn-link" href="{{ route('accounts.index') }}"><- Back</a>
            </div>
            <div class="col-md-6">
              <a class="btn btn-sm btn-warning float-right mt-1" href="{{ route('accounts.edit', $account->id) }}">
                Edit
              </a>
            </div>
          </div>
        </div>
        <br>

        <label> Guid</label>
<p>
	{{ $account-> guid }}
</p> <label>Slug</label>
<p>
	{{ $account->slug }}
</p> <label>User_id</label>
<p>
	{{ $account->user_id }}
</p> <label>Aname</label>
<p>
	{{ $account->aname }}
</p> <label>Adesc</label>
<p>
	{{ $account->adesc }}
</p> <label>Jsonattrs</label>
<p>
	{{ $account->jsonattrs }}
</p>
      </div>
    </div>
  </div>
</div>

@endsection
