@extends('template.index')

@section('container')

<div class="container mt-5">
 <div class="mb-3">
  <h3>Data Uji T</h3>
 </div>

 <table class="table mt-3">
  <thead>
   <tr>
    <th>#</th>
    <th>X1</th>
    <th>X2</th>
   </tr>
  </thead>
  <tbody>
   @foreach ($result as $item)       
   <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->x1 }}</td>
    <td>{{ $item->x2 }}</td>
   </tr>
   @endforeach
   <tr>
    <td><strong>SUM:</strong></td>
    <td>{{ $sumX1 }}</td>
    <td>{{ $sumX2 }}</td>
   </tr>
   <tr>
    <td><strong>Rerata:</strong></td>
    <td>{{ $averageX1 }}</td>
    <td>{{ $averageX2 }}</td>
   </tr>
   <tr>
    <td><strong>SD:</strong></td>
    <td>{{ $roundedSDX1 }}</td>
    <td>{{ $roundedSDX2 }}</td>
   </tr>
   <tr>
    <td><strong>Variants:</strong></td>
    <td>{{ $roundedVariance1 }}</td>
    <td>{{ $roundedVariance2 }}</td>
   </tr>
  </tbody>
 </table>
</div>

 @endsection