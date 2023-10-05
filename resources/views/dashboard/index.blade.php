@extends('template.index')

@section('container')

<div class="container mt-5">
  <!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Score</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="{{ route('scores.store') }}" method="POST">
        @csrf
          <div class="mb-3">
            <label for="score" class="form-label">Score</label>
            <input type="number" class="form-control" id="score" placeholder="Masukan Score" name="score">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
  <div class="d-flex justify-content-between mb-3">
    <h3>Data Skor</h3>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Tambah Data
    </button>
  </div>
  @if (session()->has('success')) 
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <table id="myTable" class="display mt-3">
    <thead>
        <tr>
            <th width="20">Nomor</th>
            <th>Skor</th>
            <th width="30">action</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($scores as $score)  
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $score->score }}</td>
            <td>
              <form action="{{ route('scores.destroy', $score->id) }}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus lab ini?')">Delete</button>
              </form>
            </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection