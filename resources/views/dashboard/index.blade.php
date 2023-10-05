@extends('template.index')

@section('container')

<div class="container mt-5">
  <div class="d-flex justify-content-between mb-3">
    <h3>Data Skor</h3>
    <a href="" class="btn btn-primary">Tambah Data</a>
  </div>
  <table id="myTable" class="display mt-3">
    <thead>
        <tr>
            <th width="20">Nomor</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($scores as $score)  
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $score->score }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection