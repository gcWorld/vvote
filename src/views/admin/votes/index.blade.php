@extends('site.layouts.default')

@section('title_content')
{{ Lang::get('vvote::general.admin_title') }}
@stop

@section('content')

	<div class=" clearfix pad-bottom">
		<a href="{{{ URL::to('admin/vote/create') }}}" class="pull-right btn btn-success iframe"><i class="icon-plus-sign"></i> {{ Lang::get('button.create') }}</a>
	</div>

@if ($questions)
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="col-md-1">ID</th>
				<th class="col-md-3">Name</th>
				<th class="col-md-2">Ende</th>
				<th class="col-md-1">Aktionen</th>
				<th class="col-md-3">Status</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($questions as $q)
				<tr>
					<td>{{{ $q->id }}}</td>
					<td>{{{ $q->name }}}</td>
					<td>{{{ $q->enddate() }}}</td>
                    <td>{{ $q->getActions() }}</td>
                    <td>
                        {{ $q->getStatus() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no votes
@endif

<div class='modal fade' id='deletevote'>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
				    <h3 id='modal-title'>Löschen</h3>
				</div>
				<div class='modal-body'>
					Wirklich Löschen?
					<form id='delete-vote-form' method='post' action="{{ action('VvoteController@postDelete') }}">
						<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />
						<input type="hidden" id="delete-vote-id" name="vote" value="" />
					</form>
				</div>
				<div class='modal-footer'>
				    <button class='btn' data-dismiss='modal' aria-hidden='true'>{{{ Lang::get('button.cancel') }}}</button>
				    <button class='btn btn-danger' type='submit' id='vote-delete'>{{{ Lang::get('button.delete') }}}</button>
				</div>
			</div>
		</div>
	</div>

@stop

{{-- Scripts --}}
@section('scripts')
	<script type="text/javascript">
		$('.votedelete-link').click(function() {
			var userid = $(this).data('id');
			$('#delete-vote-id').val(userid);
		});
		$('#vote-delete').click(function() {
			$('#delete-vote-form').submit();
		});
		$(".iframe").colorbox({iframe:true, width:"70%", height:"80%"});
		$('.tooltips').tooltip();
	</script>
@stop
