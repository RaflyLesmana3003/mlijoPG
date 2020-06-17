<!DOCTYPE html>
<html>
<head>
	<title>laporan penarikan tenant/mlijo</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>laporan penarikan tenant/mlijo</h4>
		<h6><a target="_blank">mlijo.id</a></h5>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
            <th style="width: 10px">tgl</th>
                      <th>no.</th>
                      <th>atasnama</th>
                      <th>bank</th>
                      <th>no rekening</th>
                      <th>total</th>
                      <th>note</th>
                      <th style="width: 40px">status</th>
                      <th>reference_no</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($pegawai as $ts)
			<tr>
				<td>{{ $i++ }}</td>
                <td>{{$ts->created_at}}</td>
                      <td>{{$ts->atasnama}}</td>
                      <td>{{$ts->bank}}</td>
                      <td>{{$ts->rekening}}</td>
                      <td>{{$ts->amount}}</td>
                      <td>{{$ts->notes}}</td>
                      <td>
                      {{$ts->status}}
                     </td>
                      <td>{{$ts->reference_no}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>