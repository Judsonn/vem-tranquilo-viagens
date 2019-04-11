@extends('layouts.app', ['title' => __('Página Inicial')])

@section('content')
    @include('layouts.headers.cards')

    {{-- @include('layouts.footers.auth') --}}
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
