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
            <th>F(x)</th>
            <th>S(z)</th>
            <th>|F(x) - S(z)|</th>
        </tr>
    </thead>
    <tbody>
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
    </tbody>
  </table>
</div>
@endsection