@extends('layouts.app')

@section('content')

@php
    $userId = Auth::user()->id;
@endphp

<div>
    <ul>
        <li>
            <a
                href="/goals/details/{{$userId}}" 
                class="{{ request()->is('/goals/details/' . $userId) ? 'active' : ''}}"
            >
                My Goals
        </a>
        </li>
        <li>
            <a 
                href="/workouts/{{$userId}}"
                class="{{ request()->is('/workouts/' . $userId) ? 'active' : '' }}"
            >
                My Workouts
            </a>
        </li>
        <li>
            <a 
                href="/recipes/{{$userId}}"
                class="{{ request()->is('/recipes/' . $userId) ? 'active' : '' }}"
            >
                My Recipes
            </a>
        </li>
    </ul>
</div>

@endsection