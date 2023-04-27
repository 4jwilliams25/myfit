const modal = $(".modal");
const showModalButton = $(".show-modal");
const closeModal = $(".close-modal");
const myExercisesTab = $("#myExercisesTab");
const allExercisesTab = $("#allExercisesTab");
const myExercisesPanel = $("#myExercises");
const allExercisesPanel = $("#allExercises");

const tabToggleArray = [
    "border-transparent",
    "border-blue-600",
    "hover:text-gray-600",
    "text-blue-600",
    "hover:border-gray-300",
];

showModalButton.click(function () {
    modal.removeClass("invisible");
});

closeModal.each(function () {
    $(this).click(function () {
        modal.addClass("invisible");
    });
});

myExercisesTab.click(function () {
    myExercisesPanel.removeClass("hidden");
    allExercisesPanel.addClass("hidden");

    tabToggleArray.forEach((attribute) => {
        myExercisesTab.toggleClass(attribute);
        allExercisesTab.toggleClass(attribute);
    });
});

allExercisesTab.click(function () {
    allExercisesPanel.removeClass("hidden");
    myExercisesPanel.addClass("hidden");

    tabToggleArray.forEach((attribute) => {
        myExercisesTab.toggleClass(attribute);
        allExercisesTab.toggleClass(attribute);
    });
});

function add_exercise_to_workout(exerciseId, workoutId) {
    const baseURL = window.location.origin;
    const token = $('meta[name="csrf-token"]').attr("content");

    const request = new XMLHttpRequest();

    $.post(
        `${baseURL}/exercise/${exerciseId}/${workoutId}`,
        { _token: token },
        function (data, status) {
            modal.addClass("invisible");

            const newExercise = `<li>
                        <div style="border: 2px solid black; margin: 3px; width: 500px; padding: 3px;">
                            <h5>${data["name"]}</h5>
                            <p>Reps: ${data["repetitions"]}</p>
                            <p>Sets: ${data["sets"]}</p>
                            <p>Weight: ${data["weight"]}</p>
                            <form action="${baseURL}/exercise/${exerciseId}/${workoutId}" method="POST">
                                <input type="hidden" name="_token" value="${token}" /> 
                                <input type="hidden" name="_method" value="DELETE" />
                                <button type="submit">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </li>`;
            $("#workout_exercise_list").append(newExercise);
        }
    ).fail(function (data, status, error) {
        console.log(data);
        console.log(status);
        console.log(error);
        throw new Error("Bad Request");
    });
}
