@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>
          Listing
          <a class="btn btn-success float-xs-right" href="{{ route('listings.create') }}">Create</a>
        </h1>
      </div>

      <div class="card-body">
        @if($listings->count())
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th class="text-xs-center">#</th>
                <th>     Guid</th> <th>   Slug</th> <th>   Account_id</th> <th>   Ltitledescription</th> <th>   Ldesc</th> <th>   Jsonattrs</th>
                <th class="text-xs-right">OPTIONS</th>
              </tr>
            </thead>

            <tbody>
              @foreach($listings as $listing)
              <tr>
                <td class="text-xs-center"><strong>{{$listing->id}}</strong></td>

                <td>{{$listing->     guid}}</td> <td>{{$listing->   slug}}</td> <td>{{$listing->   account_id}}</td> <td>{{$listing->   ltitledescription}}</td> <td>{{$listing->   ldesc}}</td> <td>{{$listing->   jsonattrs}}</td>

                <td class="text-xs-right">
                  <a class="btn btn-sm btn-primary" href="{{ route('listings.show', $listing->id) }}">
                    V
                  </a>

                  <a class="btn btn-sm btn-warning" href="{{ route('listings.edit', $listing->id) }}">
                    E
                  </a>

                  <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">

                    <button type="submit" class="btn btn-sm btn-danger">D </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $listings->render() !!}
        @else
          <h3 class="text-xs-center alert alert-info">Empty!</h3>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
