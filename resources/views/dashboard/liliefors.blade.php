@extends('template.index')

@section('container')

<div class="container mt-5">

  <div class="d-flex justify-content-between mb-3">
    <h3>Liliefors</h3>
  </div>
  <table id="myTable" class="display mt-3">
    <thead>
        <tr>
            <th width="20">Nomor</th>
            <th>Skor</th>
            <th>Z</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($scores as $score)  
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $score->score }}</td>
            <td>{{ $zScores[$score->id] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection