@extends('admin.layouts.modal')

{{-- Content --}}
@section('notifications')
@stop

@section('scripts')
<script type="text/javascript">
	parent.$.colorbox.close();
	parent.location.reload();
</script>
@stop