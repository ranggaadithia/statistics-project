<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use App\Exports\ScoresExport;
use App\Imports\ScoresImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use MathPHP\Probability\Distribution\Continuous;

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
        $jumlahKelas = 10;

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

    public function getChiSqure()
    {
        $result = DB::table('tb_zed')->get();

        return view('dashboard.chi', compact('result'));
    }

    public function calculateChiSqure(Request $request)
    {

        $request->validate([
            'chi' => 'required|regex:/^\d+(\.\d{2})?$/',
        ]);

        $chi = DB::table('tb_zed')->where('z', substr($request->chi, 0, -1))->first();
        $lastChi = substr($request->chi, -1);
        $result = '';

        if ($lastChi === '0') {
            $result = $chi->nol;
        } elseif ($lastChi === '1') {
            $result = $chi->satu;
        } elseif ($lastChi === '2') {
            $result = $chi->dua;
        } elseif ($lastChi === '3') {
            $result = $chi->tiga;
        } elseif ($lastChi === '4') {
            $result = $chi->empat;
        } elseif ($lastChi === '5') {
            $result = $chi->lima;
        } elseif ($lastChi === '6') {
            $result = $chi->enam;
        } elseif ($lastChi === '7') {
            $result = $chi->tujuh;
        } elseif ($lastChi === '8') {
            $result = $chi->delapan;
        } elseif ($lastChi === '9') {
            $result = $chi->sembilan;
        } else {
            $result = $chi->nol;
        }


        return back()->with('success', $result);
    }

    public function ujiT()
    {
        $result = DB::table('ttest')->get();
        $sumX1 = $result->sum('x1');
        $sumX2 = $result->sum('x2');
        $averageX1 = $result->avg('x1');
        $averageX2 = $result->avg('x2');
        $SD1 = DB::table('ttest')
            ->selectRaw('SQRT(SUM(POWER(x1 - ' . $averageX1 . ', 2)) / (COUNT(x1) - 1)) AS result')->first();
        $SD2 = DB::table('ttest')
            ->selectRaw('SQRT(SUM(POWER(x2 - ' . $averageX2 . ', 2)) / (COUNT(x2) - 1)) AS result')->first();

        $roundedSDX1 = round($SD1->result, 2);
        $roundedSDX2 = round($SD2->result, 2);

        $variance1 = DB::table('ttest')
            ->selectRaw('SUM(POWER(x1 - ' . $averageX1 . ', 2)) / (COUNT(x1) - 1) AS result')
            ->first();
        $variance2 = DB::table('ttest')
            ->selectRaw('SUM(POWER(x2 - ' . $averageX2 . ', 2)) / (COUNT(x2) - 1) AS result')
            ->first();

        $roundedVariance1 = round($variance1->result, 2);
        $roundedVariance2 = round($variance2->result, 2);

        return view('dashboard.t', compact('result', 'sumX1', 'sumX2', 'averageX1', 'averageX2', 'roundedSDX1', 'roundedSDX2', 'roundedVariance1', 'roundedVariance2'));
    }

    function normsdist($x)
    {
        $distribution = new Continuous\Normal(0, 1);
        return $distribution->cdf($x);
    }

    public function liliefors()
    {
        $scores = Score::all();
        $scoresAverage = $scores->avg('score');
        $scoresSTD = DB::table('scores')
            ->selectRaw('SQRT(SUM(POWER(score - ' . $scoresAverage . ', 2)) / (COUNT(score) - 1)) AS result')->first();

        $sortedScores = $scores->pluck('score')->sort()->toArray();

        $totalData = count($sortedScores);

        $empiricalCumulativeProbability = [];

        $cumulativeCount = 0;
        foreach ($sortedScores as $value) {
            $cumulativeCount++;
            $empiricalCumulativeProbability[$value] = $cumulativeCount / $totalData;
        }

        $zScores = [];
        foreach ($scores as $score) {
            $scoreValue = $score->score;
            $zScore = ($scoreValue - $scoresAverage) / $scoresSTD->result;
            $normsdist = $this->normsdist($zScore);
            $zScores[$score->id] = [
                'scoreValue' => $scoreValue,
                'zScore' => number_format($zScore, 5),
                'normsdist' => number_format($normsdist, 5),
                'empiricalCumulativeProbability' => number_format($empiricalCumulativeProbability[$scoreValue], 5),
                'fx' => abs($normsdist - $empiricalCumulativeProbability[$scoreValue]),
            ];
        }

        return view('dashboard.liliefors', compact('scores', 'zScores'));
    }

    public function export()
    {
        return Excel::download(new ScoresExport, 'scores.xlsx');
    }

    public function importView()
    {
        return view('dashboard.import');
    }

    public function import()
    {
        Excel::import(new ScoresImport, request()->file('file'));

        return redirect('/')->with('success', 'Success Import Scores');
    }
}
