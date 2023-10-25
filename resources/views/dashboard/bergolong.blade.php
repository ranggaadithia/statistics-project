@extends('template.index')

@section('container')

<div class="container mt-5">

  <div class="d-flex justify-content-between mb-3">
    <h3>Data Skor</h3>
  </div>
  <table id="myTable" class="display mt-3">
    <thead>
        <tr>
            <th width="20">Nomor</th>
            <th>Skor</th>
            <th>Nilai Tengah</th>
            <th>Frekuensi</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($scoreGroups as $score)  
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $score['interval'] }}</td>
            <td>{{ $score['mid_value'] }}</td>
            <td>{{ $score['frequency'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection