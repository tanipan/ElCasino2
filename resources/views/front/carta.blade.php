@extends('layouts.webInside')

@section('content')
    <div class="my-5" style="height: 1000px">
        <embed src="{{ Storage::url('pdf/carta.pdf') }}" type="application/pdf" width="100%" height="100%" />
    </div>
@endsection
