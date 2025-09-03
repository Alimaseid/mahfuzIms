@extends('inc.frame')


@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <div class="text-warning" style="float: left">Total Users : <b> {{ count($users) }}</b></div>
                  </h3>
                  <button type="button" class="btn btn-primary pull-rigth" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                    ADD New User
                  </button>

                </div>
              </div>

              <div class="card">
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>UserName</th>
                      <th>Email</th>
                      <th>CurrnetRole</th>
                      <th>RegistrationDate</th>
                      <th>Set/Change</th>
                      <td></td>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($users) > 0)
                        @php
                            $no = 0;
                        @endphp
                        @foreach($users as $user)
                        @php
                            $no = $no + 1;
                        @endphp
                        @if ($user->role != '2')
                         <tr>
                            <td>{{$no}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                            @forelse ($roles as $role )
                                @if ($role->id == $user->role)
                                     <a type="button" class="text-warning" href="#">{{$role->role_name}}</a>
                                @endif
                            @empty

                            @endforelse
                            </td>
                            <td>{{$user->created_at->toDateString()}}</td>
                            <td>
                              <a type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-lg-role-{{$user->id}}">Set-Role</a>
                            </td>
                            <td>
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-{{$user->id}}">
                              <i class="fas fa-edit"></i>

                              </button>
                              <a type="button" class="btn btn-danger btn-sm" href="delete-user-{{$user->id}}" onclick="return confirm('Are you sure you ?');">
                                <i class="fas fa-trash"></i>

                              </a>
                            </td>
                        </tr>
                        @endif
                        <div class="modal fade" id="modal-lg-{{$user->id}}">
                            <div class="modal-dialog modal-lg-{{$user->id}}">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit user</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            <!-- jquery validation -->
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">user <small>Information</small></h3>
                                                </div>
                                            <!-- /.card-header -->
                                            <!-- form start -->
                                            <form  action="/editUser-{{$user->id}}" method="POST" id="quickForm" >
                                                @csrf
                                                <div class="card-body">
                                                <div class="form-group">
                                                    <label >Full Name</label>
                                                    <input type="text" name="full_name" class="form-control"  value="{{$user->name}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label >Email</label>
                                                    <input type="email" name="email" class="form-control"  value="{{$user->email}}"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Phone</label>
                                                    <input type="text" name="phone" class="form-control" value="{{$user->phone}}"  pattern="[+ , 0]{1}[0 , 9]{9 , 14}">
                                                </div>
                                                </div>

                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary swalDefaultSuccess" onclick="return confirm('Are you sure you want to save changes ?');" >Save Change</button>
                                                </div>
                                            </form>
                                            </div>
                                            <!-- /.card -->
                                            </div>

                                        <!--/.col (right) -->
                                        </div>
                                        <!-- /.row -->
                                    </div><!-- /.container-fluid -->

                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>



                            <div class="modal fade" id="modal-lg-role-{{$user->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg-ADDROLE">
                                                <i class="fas fa-edit"></i>
                                                Manage Roles
                                            </button>
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row">
                                            <!-- left column -->
                                            <div class="col-md-12">
                                                <!-- jquery validation -->
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title"><small>set role to - </small> {{$user->name}} </h3>
                                                    </div>

                                                <form  action="/set-role-{{$user->id}}" method="POST" id="quickForm" >
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @forelse ($roles as $role)
                                                             @if($role->supper_admin != 'on')
                                                                <div class="col-sm-4">
                                                                    <div class="form-group clearfix">
                                                                        <div class="icheck-success d-inline text-white">
                                                                            <input type="radio" id="{{$role->id}}{{$user->id}}" name="role" value="{{$role->id}}"
                                                                                 @if($role->id == $user->role)
                                                                                     @checked(true)
                                                                                @endif>

                                                                            <label class="text-warning" for="{{$role->id}}{{$user->id}}">
                                                                                 {{$role->role_name}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                             @endif
                                                            @empty

                                                            @endforelse
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary swalDefaultSuccess" >Register</button>
                                                    </div>
                                                </form>
                                                </div>
                                                <!-- /.card -->
                                                </div>

                                            <!--/.col (right) -->
                                            </div>
                                            <!-- /.row -->
                                        </div><!-- /.container-fluid -->

                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        @endforeach
                        @else
                         <h2>No user Found !</h2>
                        @endif
                    </tbody>
                  </table>


                </div>
                <!-- /.card-body -->
              </div>

              <!-- /.card -->
              <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New user</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- jquery validation -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">User <small>Information</small></h3>
                                    </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="/add-user" method="POST" id="quickForm" >
                                    @csrf
                                    <div class="card-body">
                                    <div class="form-group">
                                        <label >Full Name</label>
                                        <input type="text" name="full_name" class="form-control"  placeholder="Full Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label >Email</label>
                                        <input type="email" name="email" class="form-control"  placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Phone</label>
                                        <input type="text" name="phone" class="form-control" id="" placeholder="+251" pattern="[+ , 0]{1}[0-9]{9,14}">
                                    </div>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary swalDefaultSuccess" >Register</button>
                                    </div>
                                </form>
                                </div>
                                <!-- /.card -->
                                </div>

                               <!--/.col (right) -->
                              </div>
                            <!-- /.row -->
                           </div><!-- /.container-fluid -->

                        </div>
                     </div>
                    <!-- /.modal-content -->
                   </div>
                <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <div class="modal fade" id="modal-lg-ADDROLE">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">New Role</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                <!-- left column -->
                                <div class="col-md-12">
                                    <!-- jquery validation -->
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">Role </h3>
                                        </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form  action="/add-role" method="POST" id="quickForm" >
                                        @csrf
                                        <div class="card-body text-success">
                                            <div class="form-group">
                                                <label >Role Name</label>
                                                <input type="text" name="role" class="form-control"  placeholder="Role Name" required>
                                            </div>
                                            <h5>Select Permissions</h5>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                  <div class="form-group clearfix">
                                                    <div class="icheck-success d-inline">
                                                      <input type="checkbox" name="manage_user" id="manage_user">
                                                      <label for="Administrator"  title="Permission to Create User, Role and assign permission ">
                                                         User
                                                      </label>
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="manage_item" id="manage_item">
                                                        <label for="Administrator"  title="Permission to Create User, Role and assign permission ">
                                                             Item
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="manage_vendor" id="manage_vendor">
                                                        <label for="Administrator"  title="Permission to Create User, Role and assign permission ">
                                                             Vendor
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                               </div>

                                               <div class="row">
                                                  <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="manage_purchase" id="manage_purchase">
                                                        <label for="Administrator"  title="Permission to Create User, Role and assign permission ">
                                                             Purchase
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="manage_customer" id="manage_customer">
                                                        <label for="Administrator"  title="Permission to Create User, Role and assign permission ">
                                                             Customer
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="manage_customer_history" id="manage_customer_history">
                                                        <label for="Administrator"  title="Permission to Create User, Role and assign permission ">
                                                            Manage Customer History
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                               </div>

                                            <div class="row">
                                                  <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="manage_sales" id="manage_sales">
                                                        <label for="Administrator"  title="Permission to Create User, Role and assign permission ">
                                                            Manage Sales
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="manage_order" id="manage_order">
                                                        <label for="Administrator"  title="Permission to Create User, Role and assign permission ">
                                                            Managem Order
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>


                                                  <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="manage_store_issue" id="manage_store_issue">
                                                        <label for="Administrator"  title="Permission to Create User, Role and assign permission ">
                                                            Managem Store Issue
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                            </div>
                                            <div class="row">
                                                  <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="approval" id="approval">
                                                        <label for="Administrator"  title="Permission to Create User, Role and assign permission ">
                                                            Approval
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="reports" id="reports">
                                                        <label for="Administrator"  title="Permission to Create User, Role and assign permission ">
                                                            Reports
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                            </div>

                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary swalDefaultSuccess" >Register</button>
                                        </div>
                                    </form>
                                    </div>
                                    <!-- /.card -->
                                    </div>

                                <!--/.col (right) -->
                                </div>
                                <hr>
                                <h5>Manage Roles Here</h5>
                                <div class="row p-2">

                                <table class="table align-baseline" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                                    <tbody class="text-info">
                                        @forelse ($roles as $role)
                                        @if($role->SuperAdmin != 'on')
                                        <form  action="/edit-role-{{$role->id}}" method="POST" id="quickForm" >
                                            @csrf
                                           <tr>
                                            <th class="text-success" scope="row ">{{$role->role_name}}</th>
                                            <td>
                                                <small>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-success d-inline clear-both ">
                                                          <input type="checkbox" name="manage_user" id="manage_user{{$role->id}}" @if ($role->manage_user == 'on')@checked(true)@endif >
                                                          <label for="manage_user{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                            Manage User
                                                          </label>
                                                        </div>
                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="manage_item" id="manage_item{{$role->id}}" @if ($role->manage_item == 'on') @checked(true) @endif >
                                                            <label for="Property{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                Manage Item
                                                            </label>
                                                        </div>
                                                      </div>
                                                </small>
                                            </td>
                                            <td>

                                                <small>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="manage_vendor" id="manage_vendor{{$role->id}}" @if ($role->manage_vendor == 'on') @checked(true) @endif >
                                                            <label for="manage_vendor{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                 Vendor &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp;&nbsp;&nbsp;
                                                            </label>
                                                        </div>

                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="manage_purchase" id="manage_purchase{{$role->id}}" @if ($role->manage_purchase == 'on') @checked(true) @endif >
                                                            <label for="manage_purchase{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                 Purchase
                                                            </label>
                                                        </div>
                                                      </div>
                                                </small>
                                            </td>

                                            <td>
                                                <small>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="manage_customer" id="manage_customer{{$role->id}}" @if ($role->manage_customer == 'on') @checked(true) @endif >
                                                            <label for="manage_customer{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                             Customer  &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;
                                                            </label>
                                                        </div>

                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="manage_store_issue" id="manage_store_issue{{$role->id}}" @if ($role->manage_store_issue == 'on') @checked(true) @endif >
                                                            <label for="manage_store_issue{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                StoreIssue
                                                            </label>
                                                        </div>
                                                      </div>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="manage_sales" id="manage_sales{{$role->id}}" @if ($role->manage_sales == 'on') @checked(true) @endif >
                                                            <label for="manage_sales{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                Manage Sales
                                                            </label>
                                                        </div>

                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="manage_order" id="manage_order{{$role->id}}" @if ($role->manage_order == 'on') @checked(true) @endif >
                                                            <label for="manage_order{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                Manage Order
                                                            </label>
                                                        </div>
                                                      </div>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="manage_customer_history" id="manage_customer_history{{$role->id}}" @if ($role->manage_customer_history == 'on') @checked(true) @endif >
                                                            <label for="manage_customer_history{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                Customer History  &nbsp;&nbsp;&nbsp;
                                                            </label>
                                                        </div>

                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="approval" id="approval{{$role->id}}" @if ($role->approval == 'on') @checked(true) @endif >
                                                            <label for="approval{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                Approval
                                                            </label>
                                                        </div>
                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="reports" id="reports{{$role->id}}" @if ($role->reports == 'on') @checked(true) @endif >
                                                            <label for="reports{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                Reports
                                                            </label>
                                                        </div>
                                                      </div>
                                                      <hr>
                                                      <button type="submit" class="btn btn-warning btn-sm">
                                                          <i class="fas fa-save"></i>
                                                          </button>
                                                          <a type="button" class="btn btn-danger btn-sm" href="delete-role-{{$role->id}}" onclick="return confirm('Are you sure you ?');">
                                                            <i class="fas fa-trash"></i>
                                                          </a>
                                                </small>
                                            </td>
                                            <td>


                                            </td>


                                          </tr>
                                        </form>
                                        @endif
                                        @empty

                                        @endforelse
                                    </tbody>
                                  </table>
                                </div>
                                <!-- /.row -->
                            </div><!-- /.container-fluid -->

                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </div>




  </section>

@endsection
