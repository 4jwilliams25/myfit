<div>
    <button class="show-modal bg-blue-600 hover:bg-blue-700 transform transition-all duration-300 hover:scale-110 px-3 py-1 rounded text-white m-5">
        Add Exercises
    </button>
</div>

{{-- Modal --}}
<div class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50 invisible">
    <div class="bg-white rounded shadow-lg w-1/3">
        {{-- Modal Header --}}
        <div class="px-4 py-2 items-center flex justify-end">
          {{-- <h3 class="font-semibold text-lg flex justify-center">Select Exercise</h3> --}}
          <button class="text-black close-modal">&cross;</button>
        </div>
        {{-- Modal tabs --}}
        <div class="text-base font-medium text-center text-gray-500 border-b border-gray-200">
            <ul class="flex">
                <li class="mr-2 w-1/2">
                    <a href="#" id="myExercisesTab" class="inline-block p-4 border-b-2 border-blue-600 rounded-t-lg text-blue-600 active">
                        My Exercises
                    </a>
                </li>
                <li class="mr-2 w-1/2">
                  <a href="#" id="allExercisesTab" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">
                      All Exercises
                  </a>
                </li>
            </ul>
        </div>
        {{-- Modal body --}}
        <div id="myExercises" class="h-48 overflow-y-auto p-3">
            <ul>
                @if (count($userExercises) > 0)
                    @foreach ($userExercises as $exercise)
                        @if ($workout->exercises->doesntContain($exercise))
                            <li id="{{ $exercise->id . '_my_card' }}">
                                <div class="border-r border-b border-l border-gray-400 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-row justify-between leading-normal">
                                    <div class="flex flex-col">
                                        <div class="text-gray-900 font-bold text-xl mb-2 hover:text-blue-600 hover:cursor-pointer" onclick="add_exercise_to_workout({{$exercise->id}}, {{$workout->id}})">{{$exercise->name}}</div>
                                        <div class="flex flex-row">
                                            <p class="text-gray-700"><b>Sets:</b> {{$exercise->sets}}</p>
                                            <p class="text-gray-700 pl-3"><b>Reps:</b> {{$exercise->repetitions}}</p>
                                            <p class="text-gray-700 pl-3"><b>Weight:</b> {{$exercise->weight}}</p>
                                        </div>
                                    </div>
                                    <div class="items-center flex justify-end inline-block align-middle">
                                        <img class="h-8 w-8 transform transition-all duration-300 hover:scale-125 hover:cursor-pointer" onclick="modal_delete_exercise({{$exercise->id}})" src="{{ asset('images/delete.png') }}" alt="delete_button">
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @else
                    <p>This user has no exercises.</p>
                @endif
            </ul>
        </div>
        <div id="allExercises" class="h-48 overflow-y-auto p-3 hidden">
            <ul>
                @if (count($allExercises) > 0)
                    @foreach ($allExercises as $exercise)
                        @if ($workout->exercises->doesntContain($exercise))
                            <li id="{{ $exercise->id . '_all_card' }}">
                                <div class="border-r border-b border-l border-gray-400 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-row justify-between leading-normal">
                                    <div class="flex flex-col">
                                        <div class="text-gray-900 font-bold text-xl mb-2 hover:text-blue-600 hover:cursor-pointer" onclick="add_exercise_to_workout({{$exercise->id}}, {{$workout->id}})">{{$exercise->name}}</div>
                                        <div class="flex flex-row">
                                            <p class="text-gray-700"><b>Sets:</b> {{$exercise->sets}}</p>
                                            <p class="text-gray-700 pl-3"><b>Reps:</b> {{$exercise->repetitions}}</p>
                                            <p class="text-gray-700 pl-3"><b>Weight:</b> {{$exercise->weight}}</p>
                                        </div>
                                    </div>
                                    <div class="items-center flex justify-end inline-block align-middle">
                                        <img class="h-8 w-8 transform transition-all duration-300 hover:scale-125 hover:cursor-pointer" onclick="modal_delete_exercise({{$exercise->id}})" src="{{ asset('images/delete.png') }}" alt="delete_button">
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @else
                    <p>There are no exercises in the system.</p>
                @endif
            </ul>
        </div>
        <div class="flex justify-end items-center w-100 border-t p-3">
            <button class="bg-green-600 hover:bg-green700 px-3 py-1 rounded text-white mr-1">
                <a href="{{ route('exercise.create') }}">Create an Exercise</a>
            </button>
            <button class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white mr-1 close-modal">Cancel</button>
            {{-- Removing add button for now. May add back in for multiselect --}}
            {{-- <button class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white">Add to Workout</button> --}}
        </div>
    </div>
    
</div>

<script type="text/javascript" src="{{ asset('assets/exercise_modal.js') }}"></script>