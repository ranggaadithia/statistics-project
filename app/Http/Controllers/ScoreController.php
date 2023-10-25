<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scores = Score::orderBy('created_at', 'desc')->get();
        return view('dashboard.index', compact('scores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Score::create([
            'score' => $request->score
        ]);

        return back()->with('success', 'Berhasil menambah data!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cari data yang akan diperbarui berdasarkan ID
        $score = Score::findOrFail($id);

        // Update data dengan nilai yang baru
        $score->score = $request->input('score');
        $score->save();

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $score = Score::findOrFail($id);
        $score->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    public function bergolong()
    {
        $scores = Score::all();

        // Mengambil nilai minimum dan maksimum dari skor
        $minScore = $scores->min('score');
        $maxScore = $scores->max('score');

        // Menentukan jumlah kelas interval (bisa disesuaikan)
        $jumlahKelas = 5;

        // Menghitung lebar interval
        $intervalWidth = ceil(($maxScore - $minScore) / $jumlahKelas);

        // Mengelompokkan data skor ke dalam kelas interval
        $scoreGroups = [];
        for ($i = 0; $i < $jumlahKelas; $i++) {
            $lowerBound = $minScore + ($i * $intervalWidth);
            $upperBound = $lowerBound + $intervalWidth - 1;
            $count = $scores->whereBetween('score', [$lowerBound, $upperBound])->count();

            // Menyimpan data kelas interval, nilai tengah, dan frekuensi
            $scoreGroups[] = [
                'interval' => "$lowerBound - $upperBound",
                'mid_value' => ($lowerBound + $upperBound) / 2,
                'frequency' => $count,
            ];
        }

        return view('dashboard.bergolong', compact('scoreGroups'));
    }

    public function distribusiFrekuensi()
    {
        $scoreFrequencies = Score::groupBy('score')
            ->selectRaw('score, count(*) as count')
            ->orderBy('score', 'asc')
            ->get()
            ->map(function ($item) {
                return $item;
            });

        return view('dashboard.distribusi-frekuensi', compact('scoreFrequencies'));
    }
}
