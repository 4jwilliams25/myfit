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
                            <li>
                                <div class="border-r border-b border-l border-gray-400 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal hover:bg-gray-400" onclick="add_exercise_to_workout({{$exercise->id}}, {{$workout->id}})">
                                    <div class="text-gray-900 font-bold text-xl mb-2">{{$exercise->name}}</div>
                                    <div class="flex flex-row">
                                        <p class="text-gray-700"><b>Sets:</b> {{$exercise->sets}}</p>
                                        <p class="text-gray-700 pl-3"><b>Reps:</b> {{$exercise->repetitions}}</p>
                                        <p class="text-gray-700 pl-3"><b>Weight:</b> {{$exercise->weight}}</p>
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
                            <li>
                                <div class="border-r border-b border-l border-gray-400 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal hover:bg-gray-400" onclick="add_exercise_to_workout({{$exercise->id}}, {{$workout->id}})">
                                    <div class="text-gray-900 font-bold text-xl mb-2">{{$exercise->name}}</div>
                                    <div class="flex flex-row">
                                        <p class="text-gray-700"><b>Sets:</b> {{$exercise->sets}}</p>
                                        <p class="text-gray-700 pl-3"><b>Reps:</b> {{$exercise->repetitions}}</p>
                                        <p class="text-gray-700 pl-3"><b>Weight:</b> {{$exercise->weight}}</p>
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
            <button class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white mr-1 close-modal">Cancel</button>
            {{-- Removing add button for now. May add back in for multiselect --}}
            {{-- <button class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white">Add to Workout</button> --}}
        </div>
    </div>
    
</div>

<script>
  const modal = $('.modal');
  const showModalButton = $('.show-modal');
  const closeModal = $('.close-modal');
  const myExercisesTab = $('#myExercisesTab');
  const allExercisesTab = $('#allExercisesTab');
  const myExercisesPanel = $('#myExercises');
  const allExercisesPanel = $('#allExercises');

  const tabToggleArray = ['border-transparent', 'border-blue-600', 'hover:text-gray-600', 'text-blue-600', 'hover:border-gray-300'];

  showModalButton.click(function () {
    modal.removeClass('invisible');
  });

  closeModal.each(function () {
    $(this).click(function () {
        modal.addClass('invisible');
    });
  });

  myExercisesTab.click(function () {
      myExercisesPanel.removeClass('hidden');
      allExercisesPanel.addClass('hidden');

      tabToggleArray.forEach(attribute => {
          myExercisesTab.toggleClass(attribute);
          allExercisesTab.toggleClass(attribute);
      });
  });

  allExercisesTab.click(function () {
      allExercisesPanel.removeClass('hidden');
      myExercisesPanel.addClass('hidden');

      tabToggleArray.forEach(attribute => {
          myExercisesTab.toggleClass(attribute);
          allExercisesTab.toggleClass(attribute);
      });
  });

  function add_exercise_to_workout(exerciseId, workoutId) {
        const baseURL = window.location.origin;
        const token = '{{csrf_token()}}';

        const request = new XMLHttpRequest();

        $.post(
            `${baseURL}/exercise/${exerciseId}/${workoutId}`,
            { _token: token },
            function (data, status) {
                modal.addClass('invisible');

                const newExercise = 
                    `<li>
                        <div style="border: 2px solid black; margin: 3px; width: 500px; padding: 3px;">
                            <h5>${data['name']}</h5>
                            <p>Reps: ${data['repetitions']}</p>
                            <p>Sets: ${data['sets']}</p>
                            <p>Weight: ${data['weight']}</p>
                            <form action="{{ route('exercise.remove', ['exercise' => $exercise->id, 'workout' => $workout->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </li>`;
                $('#workout_exercise_list').append(newExercise);
            }
        ).fail(function (data, status, error) {
            console.log(data);
            console.log(status);
            console.log(error);
            throw new Error("Bad Request");
        });
  };

</script>