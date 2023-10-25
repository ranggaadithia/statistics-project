@extends('template.index')

@section('container')

<div class="container mt-5 px-5">
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
      <form action="{{ route('score.store') }}" method="POST">
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
            <th width="50">action</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($scores as $score)  
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $score->score }}</td>
            <td>
              <div class="d-flex">
                <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateModal{{ $score->id }}">
                  edit
                </button>
                <form action="{{ route('score.destroy', $score->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
              </div>
              <div class="modal fade" id="updateModal{{ $score->id }}" tabindex="-1" aria-labelledby="updateModal{{ $score->id }}Label" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="updateModal{{ $score->id }}Label">Edit Score</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="{{ route('score.update', $score->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                        <div class="mb-3">
                          <label for="score" class="form-label">Score</label>
                          <input type="number" class="form-control" id="score" placeholder="Masukan Score" name="score" value="{{ $score->score }}">
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
            </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection