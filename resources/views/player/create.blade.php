@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Player</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url("teams/$id/players") }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" autofocus>

                                @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">

                                @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('team_id') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Select Team</label>

                            <div class="col-md-6">
                                <select id="team_id" class="form-control" name="team_id">
                                    @foreach($teams as $team)
                                    <option value="{{$team->id}}" @if($team->id == old('team_id')){{'selected="selected"'}}@endif>{{$team->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('team_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('team_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('image_uri') ? ' has-error' : '' }}">
                            <label for="logo_uri" class="col-md-4 control-label">Upload Image</label>

                            <div class="col-md-6">
                                <input id="image_uri" type="file" class="form-control" name="image_uri">

                                @if ($errors->has('image_uri'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image_uri') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
