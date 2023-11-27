@extends('template.index')

@section('container')

<div class="container mt-5">
 <div class="mb-3">
  <h3>Data Chi Kuadrat</h3>
 </div>

 <form action="{{ route('chi') }}" method="post" class="d-flex my-4">
  @csrf
   <input type="text" class="form-control w-50" name="chi" placeholder="calculate"> 
   <div class="mx-1"></div>
   <button type="submit" class="btn btn-primary">Cari</button>
   @error('chi')
   {{ $message }}
 @enderror
 </form>

@if (session()->has('success'))
 <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Hasil</strong> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

 <table id="myTable" class="display mt-3">
  <thead>
      <tr>
          <th>Nilai Z</th>
          <th>nol</th>
          <th>satu</th>
          <th>dua</th>
          <th>tiga</th>
          <th>empat</th>
          <th>lima</th>
          <th>enam</th>
          <th>tujuh</th>
          <th>delapan</th>
          <th>sembilan</th>
      </tr>
  </thead>
  <tbody>
    @foreach ($result as $score)  
      <tr>
          <td>{{ $score->z }}</td>
          <td>{{ $score->nol }}</td>
          <td>{{ $score->satu }}</td>
          <td>{{ $score->dua }}</td>
          <td>{{ $score->tiga }}</td>
          <td>{{ $score->empat }}</td>
          <td>{{ $score->lima }}</td>
          <td>{{ $score->enam }}</td>
          <td>{{ $score->tujuh }}</td>
          <td>{{ $score->delapan }}</td>
          <td>{{ $score->sembilan }}</td>
      </tr>
    @endforeach
  </tbody>
 </table>
</div>

@endsection