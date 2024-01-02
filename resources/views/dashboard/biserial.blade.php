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
    <th>Total</th>
   </tr>
  </thead>
  <tbody>
   <tr>
    <td><strong>MEAN Y</strong></td>
    <td>{{ $meanX1 }}</td>
    <td>{{ $meanX2 }}</td>
    <td>{{ $meanN }}</td>
   </tr>
   <tr>
    <td><strong>N</strong></td>
    <td>{{ $N }}</td>
    <td>{{ $N }}</td>
    <td>{{ $N + $N }}</td>
   </tr>
   <tr>
    <td><strong>SSY</strong></td>
    <td>{{ $SSYX1 }}</td>
    <td>{{ $SSYX2 }}</td>
    <td>{{ $SSYN }}</td>
   </tr>
   <tr>
    <td><strong>&Sigma;Y</strong></td>
    <td>{{ $sumX1 }}</td>
    <td>{{ $sumX2 }}</td>
    <td>{{ $sumX1 + $sumX2 }}</td>
   </tr>
   <tr>
    <td><strong>&Sigma;Y2</strong></td>
    <td>{{ $sumY2X1 }}</td>
    <td>{{ $sumY2X2 }}</td>
    <td>{{ $sumY2X1 + $sumY2X2 }}</td>
   </tr>
  </tbody>
 </table>
</div>

 @endsection