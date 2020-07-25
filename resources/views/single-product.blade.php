@extends('layouts.app')

@section('content')

<single-product slug="{{ request()->route('slug') }}"></single-product>

@endsection
