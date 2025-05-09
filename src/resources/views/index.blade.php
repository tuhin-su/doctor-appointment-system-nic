@extends('layouts.app')

@section('content')
    <livewire:is :component="$currentComponent" />
@endsection