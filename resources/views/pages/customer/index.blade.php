@extends('layouts.template')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Customer</h1>
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
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">customer transaction</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" onsubmit="return submitForm();">
                <div class="card-body">
                  <div class="form-group">
                    <label for="customerid">Customer id</label>
                    <input type="text" class="form-control" id="customerid" placeholder="customer id">
                  </div>
                  <div class="form-group">
                    <label for="productid">Product id</label>
                    <input type="text" class="form-control" id="productid" placeholder="product id">
                  </div>
                  <div class="form-group">
                    <label for="tenantid">Tenant id</label>
                    <input type="text" class="form-control" id="tenantid" placeholder="tenant id">
                  </div>
                  <div class="form-group">
                    <label for="discount">amount</label>
                    <input type="text" class="form-control" id="amount" placeholder="ex 10000">
                  </div>
                  <div class="form-group">
                    <label for="discount">Discount (%)</label>
                    <input type="text" class="form-control" id="discount" placeholder="ex 5%">
                  </div>
                  <div class="form-group">
                    <label for="note">Note</label>
                    <input type="text" class="form-control" id="note" placeholder="note">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" >Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">transaksi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>tgl</th>
                      <th>customer id</th>
                      <th>Product id</th>
                      <th>Tenant id</th>
                      <th>total</th>
                      <th>status pembayaran</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($transaction as $ts)
                    <tr>
                      <td>{{$ts->created_at}}</td>
                      <td>{{$ts->customer_id}}</td>
                      <td>{{$ts->product_id}}</td>
                      <td>{{$ts->tenant_id}}</td>
                      <td>{{$ts->amount}}</td>
                      <td>{{$ts->status}}</td>
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
    function submitForm() {
        // Kirim request ajax
        $.post("{{ route('transaction.store') }}",
        {
            _method: 'POST',
            _token: '{{ csrf_token() }}',
            amount:  $('input#amount').val(),
            discount: $('input#discount').val(),
            note: $('input#note').val(),
            customer_id: $('input#customerid').val(),
            product_id: $('input#productid').val(),
            tenant_id: $('input#tenantid').val(),
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