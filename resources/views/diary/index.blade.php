@extends('layouts.app')

@section('content')

    <div class="h-auto w-full flex flex-col justify-center items-center">
        <div class="h-auto w-3/4 border border-slate-500 rounded p-4 my-2">Breakfast</div>
        <div class="h-auto w-3/4 border border-slate-500 rounded p-4 my-2">Lunch</div>
        <div class="h-auto w-3/4 border border-slate-500 rounded p-4 my-2">Dinner</div>
        <div class="h-auto w-3/4 border border-slate-500 rounded p-4 my-2">Snacks</div>
        <div class="h-auto w-3/4 border border-slate-500 rounded p-4 my-2">
            Exercise

            {{-- @include('exercises.modal') --}}

        </div>
    </div>
@endsection