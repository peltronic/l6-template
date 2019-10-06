@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-header">
        <h1>
          Listing /
          @if($listing->id)
            Edit #{{ $listing->id }}
          @else
            Create
          @endif
        </h1>
      </div>

      <div class="card-body">
        @if($listing->id)
          <form action="{{ route('listings.update', $listing->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('listings.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          @include('common.error')

          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          
                <div class="form-group">
                	<label for="     guid-field">     Guid</label>
                	<input class="form-control" type="text" name="     guid" id="     guid-field" value="{{ old('     guid', $listing->     guid ) }}" />
                </div> 
                <div class="form-group">
                	<label for="   slug-field">   Slug</label>
                	<input class="form-control" type="text" name="   slug" id="   slug-field" value="{{ old('   slug', $listing->   slug ) }}" />
                </div> 
                <div class="form-group">
                    <label for="   account_id-field">   Account_id</label>
                    <input class="form-control" type="text" name="   account_id" id="   account_id-field" value="{{ old('   account_id', $listing->   account_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="   ltitledescription-field">   Ltitledescription</label>
                    <input class="form-control" type="text" name="   ltitledescription" id="   ltitledescription-field" value="{{ old('   ltitledescription', $listing->   ltitledescription ) }}" />
                </div> 
                <div class="form-group">
                    <label for="   ldesc-field">   Ldesc</label>
                    <input class="form-control" type="text" name="   ldesc" id="   ldesc-field" value="{{ old('   ldesc', $listing->   ldesc ) }}" />
                </div> 
                <div class="form-group">
                    <label for="   jsonattrs-field">   Jsonattrs</label>
                    <input class="form-control" type="text" name="   jsonattrs" id="   jsonattrs-field" value="{{ old('   jsonattrs', $listing->   jsonattrs ) }}" />
                </div>

          <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link float-xs-right" href="{{ route('listings.index') }}"> <- Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
