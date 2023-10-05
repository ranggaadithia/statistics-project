<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ScoreController extends Controller
{
    public function index()
    {
        $scores = Score::orderBy('created_at', 'desc')->get();
        return view('dashboard.index', compact('scores'));
    }

    public function store(Request $request)
    {
        Score::create([
            'score' => $request->score
        ]);

        return back()->with('success', 'Berhasil menambah data!');
    }

    public function destroy($id)
    {

        return $id;
        $score = Score::findOrFail($id);
        $score->delete();

        return "success";
    }
}
