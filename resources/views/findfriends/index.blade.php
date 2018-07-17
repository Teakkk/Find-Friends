@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Здравей, {{ Auth::user()->real_name }}!</div>
                <div class="panel-body">
                    Твоите нови приятели те очакват! Намери ги и ги добави!
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Намери приятели</div>
                <div class="panel-body text-center">
                <div class="row text-center">
                    <div class="col-md-6 col-md-offset-3">
                        <form action="{{ route('find-friends-suggestions-prepare') }}" method="post">
                            <div class="form-group">
                              <label for="country">Държава:</label>
                              <select class="form-control" name="country_id" id="country">
                                @foreach($countries as $country)
                                    <option value="{{ $country->language_id }}">{{ $country->country_name }}</option>
                                @endforeach
                              </select>
                            </div>
                            {{ csrf_field() }}
                            <button class="btn btn-success btn-block" type="submit">
                                Намери Приятели
                            </button>
                        </form>
                    </div>
                    
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
