<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = $this->validateRequest();
        $goals = Goal::create($data);

        return redirect('/goals/' . $goals->user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $data = $this->validateRequest();
        $goals = $user->goals;
        $goals->update($data);

        return redirect('/goals/' . $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $goal = $user->goals;
        $goal->delete();

        return redirect('/mystuff');
    }

    public function goals_detailview(User $user)
    {
        $goals = $user->goals;

        return view('goals.goals_detail', [
            'goals' => $goals
        ]);
    }

    public function goals_editview(User $user)
    {
        $goals = $user->goals;

        return view('goals.goals_edit', [
            'goals' => $goals
        ]);
    }

    private function validateRequest()
    {
        return request()->validate([
            'total_calories' => 'sometimes|required|integer',
            'protein' => 'sometimes|required|integer',
            'carbs' => 'sometimes|integer',
            'fat' => 'sometimes|integer',
            'user_id' => 'sometimes|required|unique:goals,user_id|integer'
        ]);
    }
}
