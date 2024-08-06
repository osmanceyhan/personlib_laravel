@extends(getAdminView('layouts.master'))
@section('title', __('Forbidden'))
@section('code', '403')
@section('content')

    <div class="alert alert-danger">
        {{$message}}
    </div>

@endsection
