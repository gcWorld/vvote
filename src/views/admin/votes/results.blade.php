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
{{$results}}
@stop

@section('scripts')

@stop