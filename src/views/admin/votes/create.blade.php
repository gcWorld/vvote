@extends('admin.layouts.modal')
{{-- Web site Title --}}
@section('title')
{{{ Lang::get('vvote::general.admin_title') }}} ::
@parent
@stop

@section('title_content')
{{{ Lang::get('vvote::general.admin_title') }}}
@stop

{{-- Content --}}
@section('content')
<form action="@if (isset($vote)){{ URL::to('admin/vote/' . $vote->id . '/edit') }} @else {{ action('VvoteController@postCreate') }} @endif" method="post" role="form" id="form">
	<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />
	<div class="form-group {{ $errors->first('question','has-error') }}">
		<label class="control-label" for="question">{{{ Lang::get('vvote::general.question') }}}</label><br>
		<input type="text" class="form-control " name="question" id="question" value="{{{ Input::old('question', isset($vote) ? is_null($vote->name) ? "" : $vote->name : null) }}}" />
	</div>
    
    <div class="form-group {{ $errors->first('date','has-error') }}">
		<label class="control-label" for="date">{{{ Lang::get('vvote::general.end_date') }}}</label><br>
		<input type="date" class="form-control " name="date" id="date" value="{{{ Input::old('date', isset($vote) ? is_null($vote->end) ? "" : date('Y-m-d',strtotime($vote->enddate())) : null) }}}" />
	</div>
    @if($mode=="create")
	<div class="form-group {{ $errors->first('answer1','has-error') }}">
		<label class="control-label" for="answer1">Answer 1</label>
		<input type="text" class="form-control" name="answer1" id="answer1" value="{{{ Input::old('answer1', isset($vote) ? $vote->answer1 : null) }}}"/>
        
    <div class="form-group {{ $errors->first('answer2','has-error') }}">
		<label class="control-label" for="answer2">Answer 2</label>
		<input type="text" class="form-control" name="answer2" id="answer2" value="{{{ Input::old('answer2', isset($vote) ? $vote->answer2 : null) }}}"/><a href="#" id="target">Add Answer</a>
	</div>
    <div id="append">
    
    </div>
    @endif
        
    @if($mode!="create")
    <div class="form-group row {{{ $errors->has('status') ? 'error' : '' }}}">
        <label class="col-xs-4 control-label" for="status">Status</label>
        <div class="col-xs-10">
            <select class="form-control" name="status" id="status">
                <option value="0"{{{ ($vote->active==0 ? ' selected="selected"' : '') }}}>Inaktiv</option>
                <option value="3"{{{ ($vote->active==3 ? ' selected="selected"' : '') }}}>Aktiv</option>
            </select>

           <!-- <span class="help-block">
                Select a group to assign to the user, remember that a user takes on the permissions of the group they are assigned.
            </span>-->
        </div>
    </div>
    @endif
        
	<input type="submit" value="{{{ $mode=='create' ? 'Create' : 'Edit' }}}" class="btn btn-primary" />
	<a href="{{ action('VvoteController@getIndex') }}" class="btn btn-link">Cancel</a>
</form>
@stop

@section('scripts')
    @if($mode=="create")
<script>
    i = 3
    $( "#target" ).click(function() {
        $( "#append" ).append( '<div class="form-group"><label class="control-label" for="subject">Answer '+ i +'</label><input type="text" class="form-control" name="answer'+i+'" id="answer'+i+'" value=""/></div>' );
        i++;
        return false;
    });
</script>
    @endif
@stop