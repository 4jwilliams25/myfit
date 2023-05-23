@extends('layouts.app')

@section('content')

        <form class="w-full max-w-lg" action="{{ url('/exercises') }}" method="post">
            @csrf
            <input type="hidden" name="url" value="{{ url()->previous() }}">
            <div class="flex flex-wrap mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">Exercise Name</label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" name="name">
                </div>
            </div>
            <div class="flex flex-wrap mx-3 mb-6">
                <div class="w-full md:w-1/3 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="sets">Exercise Sets</label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" name="sets">
                </div>
                <div class="w-full md:w-1/3 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="repetitions">Exercise Repetitions</label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" name="repetitions">
                </div>
                <div class="w-full md:w-1/3 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="weight">Exercise Weight</label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" name="weight">
                </div>
            </div>
            <div class="flex flex-wrap mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="notes">Exercise Notes</label>
                    <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded-lg py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="textarea" name="notes"></textarea>
                </div>
            </div>
            <div class="flex flex-wrap mx-3 mb-6">
                <button class="bg-blue-600 hover:bg-blue-700 transform transition-all duration-300 hover:scale-110 px-3 py-1 rounded text-white m-5" type="submit">Create Exercise</button>
            </div>
        </form>

@endsection