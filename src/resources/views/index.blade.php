@extends('layouts.app')

@section('content')
    @if (view()->exists('livewire.' . $currentComponent))
        <livewire:is :component="$currentComponent" />
    @else
        <div class="text-center text-danger">
            Component "{{ $currentComponent }}" not found.
        </div>
    @endif
@endsection
