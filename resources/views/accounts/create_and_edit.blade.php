@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-header">
        <h1>
          Account /
          @if($account->id)
            Edit #{{ $account->id }}
          @else
            Create
          @endif
        </h1>
      </div>

      <div class="card-body">
        @if($account->id)
          <form action="{{ route('accounts.update', $account->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('accounts.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          @include('common.error')

          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          
                <div class="form-group">
                	<label for=" guid-field"> Guid</label>
                	<input class="form-control" type="text" name=" guid" id=" guid-field" value="{{ old(' guid', $account-> guid ) }}" />
                </div> 
                <div class="form-group">
                	<label for="slug-field">Slug</label>
                	<input class="form-control" type="text" name="slug" id="slug-field" value="{{ old('slug', $account->slug ) }}" />
                </div> 
                <div class="form-group">
                    <label for="user_id-field">User_id</label>
                    <input class="form-control" type="text" name="user_id" id="user_id-field" value="{{ old('user_id', $account->user_id ) }}" />
                </div> 
                <div class="form-group">
                	<label for="aname-field">Aname</label>
                	<input class="form-control" type="text" name="aname" id="aname-field" value="{{ old('aname', $account->aname ) }}" />
                </div> 
                <div class="form-group">
                    <label for="adesc-field">Adesc</label>
                    <input class="form-control" type="text" name="adesc" id="adesc-field" value="{{ old('adesc', $account->adesc ) }}" />
                </div> 
                <div class="form-group">
                    <label for="jsonattrs-field">Jsonattrs</label>
                    <input class="form-control" type="text" name="jsonattrs" id="jsonattrs-field" value="{{ old('jsonattrs', $account->jsonattrs ) }}" />
                </div>

          <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link float-xs-right" href="{{ route('accounts.index') }}"> <- Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
