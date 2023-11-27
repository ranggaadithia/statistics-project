@extends('template.index')

@section('container')

<div class="container mt-5">

  <div class="d-flex justify-content-between mb-3">
    <h3>Distribusi Frekuensi</h3>
  </div>
  <table id="myTable" class="display mt-3">
    <thead>
        <tr>
            <th width="20">Nomor</th>
            <th>Skor</th>
            <th>Frekuensi</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($scoreFrequencies as $score)  
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $score['score'] }}</td>
            <td>{{ $score['count'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection