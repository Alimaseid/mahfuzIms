@extends('inc.frame')

@section('content')
{{-- <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css"> --}}

    <section class="content">
      <div class="row p-2">
        <div class="col-md-3" style="position:-webkit-sticky; position: sticky; top: 0; !important">
          <a href="#" class="btn btn-primary btn-block mb-3">Notifications</a>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Messages</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">

                <li class="nav-item active">
                    <a href="#" class="nav-link" onclick="getPaymentToApprove()">
                      <i class="fas fa-inbox"></i> Payment Approval
                      <span class="badge bg-warning float-right">{{count($payments)}}</span>

                    </a>
                  </li>

                <li class="nav-item">
                  <a href="#" class="nav-link" onclick="getTrushPayments()" >
                    <i class="far fa-file-alt"></i> Trash Payments
                    <span class="badge bg-warning float-right">{{2}}</span>

                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>


          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header" style="position:-webkit-sticky; position: sticky; top: 0; !important">
              <h3 class="card-title" id="title">Payment Approval</h3>
              <div class="card-tools">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" placeholder="Search Mail">
                  <div class="input-group-append">
                    <div class="btn btn-primary">
                      <i class="fas fa-search"></i>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls" style="position:-webkit-sticky; position: sticky; top:0; !important">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm">
                    <i class="far fa-trash-alt"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm">
                    <i class="fas fa-reply"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm">
                    <i class="fas fa-share"></i>
                  </button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm">
                  <i class="fas fa-sync-alt"></i>
                </button>
                <div class="float-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm">
                      <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-sm">
                      <i class="fas fa-chevron-right"></i>
                    </button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover  table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">

                    <tbody id="payment_approve">
                        @php
                        $no =0;
                        @endphp
                        @forelse ($payments as $payment)
                        @php
                            $no = $no + 1;
                        @endphp
                        <tr>
                            <td>
                            {{$no}}
                            </td>
                            <td class="mailbox-name">
                              <a href="#" style="color:orange">
                                 @forelse ($customers as $customer)
                                     @if ($payment->customer_id == $customer->id)
                                      {{$customer->name}}
                                     @endif
                                 @empty
                                 @endforelse
                               </a>
                            </td>
                            <td class="mailbox-subject"><b>
                                <b>Pay: {{number_format($payment->credit)}} <sub>Birr</sub> </b>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <small>
                                    Type : {{$payment->voucher_type}} &nbsp;&nbsp;
                                    Reference: {{$payment->refrence_no}}
                                </small>
                              </p>
                            </td>
                            <td class="mailbox-attachment">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-xs">Action</button>
                                    <button type="button" class="btn btn-success btn-xs dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                        <div class="dropdown-menu" role="menu">
                                            {{-- <a href="sales-approval-{{$sale->id}}-1" class="btn btn-success btn-xs">Approve</a> --}}
                                            <a class="dropdown-item" href="payment approval-{{$payment->id}}" >Approve</a>
                                            <a class="dropdown-item" href="payment reject-{{$payment->id}}" onclick="return confirm('Are you sure reject this payment. ');">Reject </a>
                                            {{-- <a class="dropdown-item" href="salesStatus-Terminated-{{$sale->id}}" style="color: rgb(255, 0, 0)" >Terminate</a> --}}
                                        </div>
                                </div>
                        </td>
                            <td class="mailbox-date">
                            <small class="text-xs" style="color:orange"> {{$payment->created_at->diffForHumans()}} </small>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                  </table>
                </table>
                <!-- /.table -->
              </div>

              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->

          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
    <!-- /.content -->
    </section>

        <script>
            $(function () {
              //Enable check and uncheck all functionality
              $('.checkbox-toggle').click(function () {
                var clicks = $(this).data('clicks')
                if (clicks) {
                  //Uncheck all checkboxes
                  $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
                  $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
                } else {
                  //Check all checkboxes
                  $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
                  $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
                }
                $(this).data('clicks', !clicks)
              })

              //Handle starring for font awesome
              $('.mailbox-star').click(function (e) {
                e.preventDefault()
                //detect type
                var $this = $(this).find('a > i')
                var fa    = $this.hasClass('fa')

                //Switch states
                if (fa) {
                  $this.toggleClass('fa-star')
                  $this.toggleClass('fa-star-o')
                }
              })
            })
        </script>

<script>


    function getPaymentToApprove(){
        document.getElementById('title').innerHTML = 'Payment Approval';
        document.getElementById('payment_approve').style.display = 'block';
        document.getElementById('payment_trush_approve').style.display = 'none';

    }
    function getTrushPayments(){
      document.getElementById('title').innerHTML = 'Payment Trush Approval';
        document.getElementById('payment_trush_approve').style.display = 'block';
        document.getElementById('payment_approve').style.display = 'none';

    }


    function approveOne(id,approval){
        $.ajax({
        type: "POST",
        url: "{{url('payment_approve')}}",
        dataType:'json',
        data:{
               '_token':'{{ csrf_token() }}',
                id:id,
                approval:approval,
            },
        success: function (result) {
            // console.log(result);
        },

        });
    }
  </script>



@endsection
