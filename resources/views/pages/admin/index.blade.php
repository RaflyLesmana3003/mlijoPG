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
              <div class="card-header">
                <h3 class="card-title">penarikan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>tgl</th>
                      <th>bank</th>
                      <th>no rekening</th>
                      <th>atasnama</th>
                      <th>total</th>
                      <th>status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>24/04/2001</td>
                      <td>BCA</td>
                      <td>0812381293</td>
                      <td>jhon doe</td>
                      <td>Rp.50.000</td>
                      <td>
                      <button class="btn btn-success">approve</button>
                      <button class="btn btn-danger">eject</button>
                    </td>
                    </tr>
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
    function submitForm() {
        // Kirim request ajax
        $.post("{{ route('transaction.store') }}",
        {
            _method: 'POST',
            _token: '{{ csrf_token() }}',
            jumlah: $('input#jumlah').val(),
            bank: $('select#bank').val(),
            atasnama: $('input#atasnama').val(),
            rekening: $('input#rekening').val(),
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