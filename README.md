# Liliefos

Cara membuat Liliefors

## Installation

Install math-php untuk membuat liliefors, masukan command dibawah ke terminal di folder.

```bash
composer require markrogoyski/math-php
```

## Usage

Dalam Controller kalian masukan code-code berikut 

```php
# taruh di paling atas
use MathPHP\Probability\Distribution\Continuous;
```

lalu membuat 2 function seperti dibawah

```php
function normsdist($x)
    {
        $distribution = new Continuous\Normal(0, 1); 
        return $distribution->cdf($x); 
    }

    public function liliefors()
    {
        $scores = Score::all(); # sesuaikan dengan nama model
        $scoresAverage = $scores->avg('score'); # sesuaikan dengan nama colom nilai
        $scoresSTD = DB::table('scores') # sesuaikan dengan table dan colom nilai
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

```

lalu buat viewnya, dan berikut cara menampilkan datanya di table
```php
  @foreach ($zScores as $scoreId => $data)
          <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $data['scoreValue'] }}</td>
              <td>{{ $data['zScore'] }}</td>
              <td>{{ $data['normsdist'] }}</td>
              <td>{{ $data['empiricalCumulativeProbability'] }}</td>
              <td>{{ $data['fx'] }}</td>
          </tr>
      @endforeach
```

