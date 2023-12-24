@extends('template.index')

@section('container')
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
@endsection