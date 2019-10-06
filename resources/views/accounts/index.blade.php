@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>
          Account
          <a class="btn btn-success float-xs-right" href="{{ route('accounts.create') }}">Create</a>
        </h1>
      </div>

      <div class="card-body">
        @if($accounts->count())
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th class="text-xs-center">#</th>
                <th> Guid</th> <th>Slug</th> <th>User_id</th> <th>Aname</th> <th>Adesc</th> <th>Jsonattrs</th>
                <th class="text-xs-right">OPTIONS</th>
              </tr>
            </thead>

            <tbody>
              @foreach($accounts as $account)
              <tr>
                <td class="text-xs-center"><strong>{{$account->id}}</strong></td>

                <td>{{$account-> guid}}</td> <td>{{$account->slug}}</td> <td>{{$account->user_id}}</td> <td>{{$account->aname}}</td> <td>{{$account->adesc}}</td> <td>{{$account->jsonattrs}}</td>

                <td class="text-xs-right">
                  <a class="btn btn-sm btn-primary" href="{{ route('accounts.show', $account->id) }}">
                    V
                  </a>

                  <a class="btn btn-sm btn-warning" href="{{ route('accounts.edit', $account->id) }}">
                    E
                  </a>

                  <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">

                    <button type="submit" class="btn btn-sm btn-danger">D </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $accounts->render() !!}
        @else
          <h3 class="text-xs-center alert alert-info">Empty!</h3>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
