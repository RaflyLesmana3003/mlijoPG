@extends('layouts.template')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Admin</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- /.card -->
            <div class="card">
            <div class="col-md-12">
                <a href="/withdrawal/cetak_pdf" class="btn btn-primary" target="_blank">CETAK PDF</a>
                <a href="/withdrawal/cetak_excel" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
		
              </div>
              
              <div class="card-header">
           
                <h3 class="card-title">penarikan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
              
              <table class="table table-striped">
                  <thead>
                  <tr>
                      <th style="width: 10px">tgl</th>
                      <th>atasnama</th>
                      <th>bank</th>
                      <th>no rekening</th>
                      <th>total</th>
                      <th>note</th>
                      <th style="width: 40px">status</th>
                      <th>reference_no</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($transaction as $ts)
                    <tr>
                      <td>{{$ts->created_at}}</td>
                      <td>{{$ts->atasnama}}</td>
                      <td>{{$ts->bank}}</td>
                      <td>{{$ts->rekening}}</td>
                      <td>{{$ts->amount}}</td>
                      <td>{{$ts->notes}}</td>
                      <td>
                      @if($ts->status == "queued")
                      <span class="badge bg-dark">{{$ts->status}}</span>
                      @elseif($ts->status == "approved")
                      <span class="badge bg-success">{{$ts->status}}</span>
                      @elseif($ts->status == "rejected")
                      <span class="badge bg-danger">{{$ts->status}}</span>
                      @elseif($ts->status == "processed")
                      <span class="badge bg-info">{{$ts->status}}</span>
                      @elseif($ts->status == "completed")
                      <span class="badge bg-success">{{$ts->status}}</span>
                      @elseif($ts->status == "failed")
                      <span class="badge bg-danger">{{$ts->status}}</span>
                      @endif
                     </td>
                      <td>{{$ts->reference_no}}</td>
                      <td>
                      <button class="btn btn-success" onclick="submitApprove('{{$ts->reference_no}}');">approve</button>
                      <button class="btn btn-danger" onclick="submitReject('{{$ts->reference_no}}');">reject</button>
                    </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!--/.col (left) -->
        </div>
        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="{{ !config('services.midtrans.isProduction') ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <script>
    function submitApprove(reference) {
      // console.log(reference);

        // Kirim request ajax
        $.post("{{ route('approval') }}",
        {
            _method: 'POST',
            _token: '{{ csrf_token() }}',
            reference_no: reference,
            otp: $('select#bank').val(),
        },
        function (data, status) {
            snap.pay(data.snap_token, {
                // Optional
                onSuccess: function (result) {
                    location.reload();
                },
                // Optional
                onPending: function (result) {
                    location.reload();
                },
                // Optional
                onError: function (result) {
                    location.reload();
                }
            });
        });
        return false;
    }
    function submitReject(reference) {
      // console.log(reference);
      
        // Kirim request ajax
        $.post("{{ route('reject') }}",
        {
            _method: 'POST',
            _token: '{{ csrf_token() }}',
            reference_no: reference,
            reason: "test",
        },
        function (data, status) {
            snap.pay(data.snap_token, {
                // Optional
                onSuccess: function (result) {
                    location.reload();
                },
                // Optional
                onPending: function (result) {
                    location.reload();
                },
                // Optional
                onError: function (result) {
                    location.reload();
                }
            });
        });
        return false;
    }
    </script>
    <!-- /.content -->
    @endsection