<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyFit</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<nav>
    <ul>
        <li>
            <a 
                href="/"
                class="{{ request()->is('/') ? 'active' : '' }}"
            >
                Home
            </a>
        </li>
        <li>
            <a 
                href="eats"
                class="{{ request()->is('eats') ? 'active' : '' }}"
            >
                Food Diary
            </a>
        </li>
        <li>
            <a 
                href="groceries"
                class="{{ request()->is('groceries') ? 'active' : '' }}"
            >
                Groceries
            </a>
        </li>
        <li>
            <a 
                href="recipes"
                class="{{ request()->is('recipes') ? 'active' : '' }}"
            >
                Recipes
            </a>
        </li>
        <li>
            <a 
                href="workouts"
                class="{{ request()->is('workouts') ? 'active' : '' }}"
            >
                Exercise Diary
            </a>
        </li>
    </ul>
</nav>