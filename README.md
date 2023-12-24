# Liliefos

Cara membuat Liliefors

## Installation

Install math-php untuk membuat liliefors, masukan command dibawah ke terminal di folder.

```bash
composer require markrogoyski/math-php
```

## Usage

Pertama tambahkan route berikut 
```php
Route::get('/liliefors', [ScoreController::class, 'liliefors'])->name('liliefors'); #silahkan di sesuaikan
```

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


# Export & Import

## Instalation
pertama jalakan command dibawah dalam terminal di folder laravel statistiknya

```bash
composer require maatwebsite/excel
```

jika ada error saat menjalankan command diatas maka jalankan yang dibawah ini

```bash
composer require maatwebsite/excel --ignore-platform-reqs
```

lalu pada `config/app.php` dalam method providers & aliases tambahkan

```php
'providers' => [
    /*
     * Package Service Providers...
     */
    Maatwebsite\Excel\ExcelServiceProvider::class,
]

'aliases' => [
    ...
    'Excel' => Maatwebsite\Excel\Facades\Excel::class,
]
```

lalu jalankan 

```bash
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
```

## Export
jalankan

```bash
php artisan make:export ScoresExport --model=Scores
```

lalu buka filenya di `app/Exports/ScoresExport.php` dan ganti menjadi seperti dibawah

```php
<?php

namespace App\Exports;

use App\Models\Score;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ScoresExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('dashboard.export', [
            'scores' => Score::all() #disesuaikan
        ]);
    }
}

```

lalu buat viewnya untuk export dan isinya seperti dibawah

```html
<table>
 <thead>
  <tr>
   <th><b>No</b></th>
   <th><b>Score</b></th>
  </tr>
 </thead>
 <tbody>
  @foreach($scores as $score)
  <tr>
   <td>{{ $loop->iteration }}</td>
   <td>{{ $score->score }}</td>
  </tr>
  @endforeach
 </tbody>
</table>
```

lalu tambahkan code dibawah di controller kalian

```php
public function export()
{
    return Excel::download(new ScoresExport, 'scores.xlsx');
}
```

tambahkan route juga untuk exportnya di `route/web.php`

```php
Route::get('export/', [ScoreController::class, 'export']); #disesuaikan
```

## Import

pertama buat view & route untuk upload file excel 

kalau saya seperti contoh dibawah

`view`
```html
<div class="mt-5 px-3">
 <h1>Import Data Score</h1>
 <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input class="form-control form-control-lg" type="file" id="formFile" name="file">
  <label for=""><i>Extension: xlxs, xlx, csv</i></label>
  <br>
  <button type="submit" class="btn btn-primary mt-3">Submit</button>
 </form>
</div>
```

`route`

```php
Route::get('import/', function () {
 return view('dashboard.import');
});

Route::post('import/', [ScoreController::class, 'import'])->name('import');
```

setelah itu jalankan

```bash
php artisan make:import ScoresImport --model=Score 
```

lalu buka filenya di `app/Imports/ScoresImport.php` dan ubah seperti dibawah

```php
<?php

namespace App\Imports;

use App\Models\Score;
use Maatwebsite\Excel\Concerns\ToModel;

class ScoresImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Score([
            'score' => $row[0] #disesuaikan
        ]);
    }
}

```

lalu tambahkan di controller method dibawah

```php
public function import()
{
    Excel::import(new ScoresImport, request()->file('file'));

    return redirect('/')->with('success', 'Success Import Scores');
}
```

**Note: dalam file excel yang akan di import nilai dari score harus ada di colom pertama dan hanya berisi score. Tidak berisi Heading Score atau semacamnya!**






