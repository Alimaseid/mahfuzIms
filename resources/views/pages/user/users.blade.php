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
                            <button type="button" class="btn btn-primary pull-rigth" style="float: right;"
                                data-toggle="modal" data-target="#modal-lg">
                                ADD New User
                            </button>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped"
                                style=" overflow-y:scroll;display:block;overflow-y: hidden;">
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
                                    @if (count($users) > 0)
                                        @php
                                            $no = 0;
                                        @endphp
                                        @foreach ($users as $user)
                                            @php
                                                $no = $no + 1;
                                            @endphp

                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @forelse ($roles as $role)
                                                        @if ($role->id == $user->role)
                                                            <a type="button" class="text-warning"
                                                                href="#">{{ $role->role_name }}</a>
                                                        @endif
                                                    @empty
                                                    @endforelse
                                                </td>
                                                <td>{{ $user->created_at->toDateString() }}</td>
                                                <td>
                                                    <a type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                        data-target="#modal-lg-role-{{ $user->id }}">Set-Role</a>
                                                </td>
                                                <td>
                                                    @if ($permission->manage_edit_user == 'on')
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-toggle="modal" data-target="#modal-lg-{{ $user->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    @endif
                                                    @if (auth()->user()->role == 1)
                                                        {{-- Logged in as Super Admin --}}
                                                        @if ($user->role != 1)
                                                            {{-- Show delete button only if the user is NOT Super Admin --}}
                                                            <a type="button" class="btn btn-danger btn-sm"
                                                                href="delete-user-{{ $user->id }}"
                                                                onclick="return confirm('Are you sure you want to delete this user?');">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        {{-- Other roles need permission to delete users --}}
                                                        @if ($permission->manage_delete_user == 'on' && $user->role != 1)
                                                            <a type="button" class="btn btn-danger btn-sm"
                                                                href="delete-user-{{ $user->id }}"
                                                                onclick="return confirm('Are you sure you want to delete this user?');">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        @endif
                                                    @endif


                                                </td>
                                            </tr>

                                            <div class="modal fade" id="modal-lg-{{ $user->id }}">
                                                <div class="modal-dialog modal-lg-{{ $user->id }}">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit user</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
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
                                                                                <h3 class="card-title">user
                                                                                    <small>Information</small>
                                                                                </h3>
                                                                            </div>
                                                                            <!-- /.card-header -->
                                                                            <!-- form start -->
                                                                            <form action="/editUser-{{ $user->id }}"
                                                                                method="POST" id="quickForm">
                                                                                @csrf
                                                                                <div class="card-body">
                                                                                    <div class="form-group">
                                                                                        <label>Full Name</label>
                                                                                        <input type="text"
                                                                                            name="full_name"
                                                                                            class="form-control"
                                                                                            value="{{ $user->name }}"
                                                                                            required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Email</label>
                                                                                        <input type="email" name="email"
                                                                                            class="form-control"
                                                                                            value="{{ $user->email }}"
                                                                                            required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="">Phone</label>
                                                                                        <input type="text" name="phone"
                                                                                            class="form-control"
                                                                                            value="{{ $user->phone }}"
                                                                                            pattern="[+ , 0]{1}[0 , 9]{9 , 14}">
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="modal-footer justify-content-between">
                                                                                    <button type="button"
                                                                                        class="btn btn-default"
                                                                                        data-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary swalDefaultSuccess"
                                                                                        onclick="return confirm('Are you sure you want to save changes ?');">Save
                                                                                        Change</button>
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



                                            <div class="modal fade" id="modal-lg-role-{{ $user->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">
                                                                <button type="button" class="btn btn-success"
                                                                    data-toggle="modal" data-target="#modal-lg-ADDROLE">
                                                                    <i class="fas fa-edit"></i>
                                                                    Manage Roles
                                                                </button>
                                                            </h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
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
                                                                                <h3 class="card-title"><small>set role to -
                                                                                    </small> {{ $user->name }} </h3>
                                                                            </div>

                                                                            <form action="/set-role-{{ $user->id }}"
                                                                                method="POST" id="quickForm">
                                                                                @csrf
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        @forelse ($roles as $role)
                                                                                            @if ($role->supper_admin != 'on')
                                                                                                <div class="col-sm-4">
                                                                                                    <div
                                                                                                        class="form-group clearfix">
                                                                                                        <div
                                                                                                            class="icheck-success d-inline text-white">
                                                                                                            <input
                                                                                                                type="radio"
                                                                                                                id="{{ $role->id }}{{ $user->id }}"
                                                                                                                name="role"
                                                                                                                value="{{ $role->id }}"
                                                                                                                @if ($role->id == $user->role) @checked(true) @endif>

                                                                                                            <label
                                                                                                                class="text-warning"
                                                                                                                for="{{ $role->id }}{{ $user->id }}">
                                                                                                                {{ $role->role_name }}
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        @empty
                                                                                        @endforelse
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="modal-footer justify-content-between">
                                                                                    <button type="button"
                                                                                        class="btn btn-default"
                                                                                        data-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary swalDefaultSuccess">Register</button>
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
                                                    <form action="/add-user" method="POST" id="quickForm">
                                                        @csrf
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label>Full Name</label>
                                                                <input type="text" name="full_name"
                                                                    class="form-control" placeholder="Full Name" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="email" name="email" class="form-control"
                                                                    placeholder="Email" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Phone</label>
                                                                <input type="text" name="phone" class="form-control"
                                                                    id="" placeholder="+251"
                                                                    pattern="[+ , 0]{1}[0-9]{9,14}">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-primary swalDefaultSuccess">Register</button>
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
                                                    <form action="/add-role" method="POST" id="quickForm">
                                                        @csrf
                                                        <div class="card-body text-success">
                                                            <div class="form-group">
                                                                <label>Role Name</label>
                                                                <input type="text" name="role_name"
                                                                    class="form-control" placeholder="Role Name" required>
                                                            </div>

                                                            <h5>Select Permissions</h5>
                                                            <hr>

                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_user"
                                                                            id="manage_user">
                                                                        <label for="manage_user">Manage-User</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_location"
                                                                            id="manage_location">
                                                                        <label
                                                                            for="manage_location">Manage-Location</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_item"
                                                                            id="manage_item">
                                                                        <label for="manage_item">Manage-Item</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_item_unit"
                                                                            id="manage_item_unit">
                                                                        <label
                                                                            for="manage_item_unit">ManageItemUnit</label>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row mt">
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_edit_user"
                                                                            id="manage_edit_user">
                                                                        <label for="manage_item_unit">M-EditUser</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_edit_location"
                                                                            id="manage_edit_location">
                                                                        <label
                                                                            for="manage_edit_location">M-EditLocation</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_edit_item"
                                                                            id="manage_edit_item">
                                                                        <label for="manage_edit_item">M-EditItem</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_edit_unit"
                                                                            id="manage_edit_unit">
                                                                        <label for="manage_edit_unit">M-EditUnit</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt">
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_delete_user"
                                                                            id="manage_delete_user">
                                                                        <label
                                                                            for="manage_delete_user">M-DeleteUser</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_delete_location"
                                                                            id="manage_delete_location">
                                                                        <label
                                                                            for="manage_delete_location">M-DeleteLocation</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_delete_item"
                                                                            id="manage_delete_item">
                                                                        <label
                                                                            for="manage_delete_item">M-DeleteItem</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_delete_unit"
                                                                            id="manage_delete_unit">
                                                                        <label
                                                                            for="manage_delete_unit">M-DeleteUnit</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row ">
                                                                <div class="col-sm-3">

                                                                </div>
                                                                <div class="col-sm-3">

                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="set_item_price"
                                                                            id="set_item_price">
                                                                        <label for="set_item_price">Set-ItemPrice</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">

                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row mt">
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_category"
                                                                            id="manage_category">
                                                                        <label
                                                                            for="manage_category">Manage-Category</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_shelf"
                                                                            id="manage_shelf">
                                                                        <label for="manage_shelf">Manage-Shelf</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_customer"
                                                                            id="manage_customer">
                                                                        <label
                                                                            for="manage_customer">Manage-Customer</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_good_receiving"
                                                                            id="manage_good_receiving">
                                                                        <label
                                                                            for="manage_good_receiving">M-GoodReceiving</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt">
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_edit_category"
                                                                            id="manage_edit_category">
                                                                        <label
                                                                            for="manage_edit_category">EditCategory</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_edit_shelf"
                                                                            id="manage_edit_shelf">
                                                                        <label for="manage_edit_shelf">EditShelf</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_edit_customer"
                                                                            id="manage_edit_customer">
                                                                        <label
                                                                            for="manage_edit_customer">EditCustomer</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_edit_goodreceiving"
                                                                            id="manage_edit_goodreceiving">
                                                                        <label
                                                                            for="manage_edit_goodreceiving">EditGoodReceiving</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt">
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_delete_category"
                                                                            id="manage_delete_category">
                                                                        <label
                                                                            for="manage_delete_category">DeleteCategory</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_delete_shelf"
                                                                            id="manage_delete_shelf">
                                                                        <label
                                                                            for="manage_delete_shelf">DeleteShelf</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_delete_customer"
                                                                            id="manage_delete_customer">
                                                                        <label
                                                                            for="manage_delete_customer">DeleteCustomer</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_delete_goodreceiving"
                                                                            id="manage_delete_goodreceiving">
                                                                        <label
                                                                            for="manage_delete_goodreceiving">DeleteGoodReceive</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row mt">
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_disposal"
                                                                            id="manage_disposal">
                                                                        <label
                                                                            for="manage_disposal">Manage-Disposal</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_purchase_plan"
                                                                            id="manage_purchase_plan">
                                                                        <label
                                                                            for="manage_purchase_plan">M-PurchasePlan</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_sales"
                                                                            id="manage_sales">
                                                                        <label for="manage_sales">Manage-Sales</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_dailysalesReport"
                                                                            id="manage_dailysalesReport">
                                                                        <label
                                                                            for="manage_dailysalesReport">M-SalesReport</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row mt">
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_edit_disposal"
                                                                            id="manage_edit_disposal">
                                                                        <label
                                                                            for="manage_edit_disposal">EditDisposal</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_delete_purchasePlan"
                                                                            id="manage_delete_purchasePlan">
                                                                        <label
                                                                            for="manage_delete_purchasePlan">DeletePurchasePlan</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_edit_sales"
                                                                            id="manage_edit_sales">
                                                                        <label for="manage_edit_sales">EditSales</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_shopStock_reports"
                                                                            id="manage_shopStock_reports">
                                                                        <label
                                                                            for="manage_shopStock_reports">ShopStockeReport</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row mt">
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_delete_disposal"
                                                                            id="manage_delete_disposal">
                                                                        <label
                                                                            for="manage_delete_disposal">DeleteDisposal</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="approval"
                                                                            id="approval">
                                                                        <label for="approval">Manage-Approval</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_delete_sales"
                                                                            id="manage_delete_sales">
                                                                        <label
                                                                            for="manage_delete_sales">DeleteSales</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_shopTRansferReports"
                                                                            id="manage_shopTRansferReports">
                                                                        <label
                                                                            for="manage_shopTRansferReports">SalesTransferReport</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <br>

                                                            <div class="row mt">
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_customer_history"
                                                                            id="manage_customer_history">
                                                                        <label
                                                                            for="manage_customer_history">M-CustomerHistory</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_item_transfer"
                                                                            id="manage_item_transfer">
                                                                        <label
                                                                            for="manage_item_transfer">M-ItemTransfer</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_stock_reports"
                                                                            id="manage_stock_reports">
                                                                        <label
                                                                            for="manage_stock_reports">M-StockReport</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox" name="manage_activity_log"
                                                                            id="manage_activity_log">
                                                                        <label
                                                                            for="manage_activity_log">M-ActivityLog</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row mt">
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_dailycustomerReport"
                                                                            id="manage_dailycustomerReport">
                                                                        <label
                                                                            for="manage_dailycustomerReport">CustomerReport</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_itemTransfer_delete"
                                                                            id="manage_itemTransfer_delete">
                                                                        <label
                                                                            for="manage_itemTransfer_delete">DeleteItemTransfer</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="icheck-success d-inline">
                                                                        <input type="checkbox"
                                                                            name="manage_storeTRansferReports"
                                                                            id="manage_storeTRansferReports">
                                                                        <label
                                                                            for="manage_storeTRansferReports">StockItemTransfer</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">

                                                                </div>

                                                            </div>
                                                            <br>


                                                        </div>

                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-primary swalDefaultSuccess">Register</button>
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
                                            <div class="table-responsive">
                                                <table class="table align-middle table-bordered">
                                                    {{-- <thead class="bg-success text-white">
                                                        <tr>
                                                            <th>Role Name</th>
                                                            <th>User Management</th>
                                                            <th>Location / Item / Unit</th>
                                                            <th>Category / Shelf / Customer</th>
                                                            <th>Good Receiving / Disposal / Sales</th>
                                                            <th>Reports / Transfers</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead> --}}
                                                    <tbody class="text-info">
                                                        @forelse ($roles as $role)
                                                            @if ($role->SuperAdmin != 'on')
                                                                <form action="{{ url('/edit-role-' . $role->id) }}"
                                                                    method="POST" id="quickForm">
                                                                    @csrf
                                                                    <tr>
                                                                        <!-- Role Name -->
                                                                        <td class="text-success fw-bold">
                                                                            {{ $role->role_name }}
                                                                        </td>

                                                                        <!-- Column 1: User Management -->
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input type="hidden" name="manage_user"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="manage_user"
                                                                                    id="manage_user{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_user == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_user{{ $role->id }}">M-User</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_edit_user"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_edit_user"
                                                                                    id="manage_edit_user{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_edit_user == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_edit_user{{ $role->id }}">Edit-User</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_delete_user"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_delete_user"
                                                                                    id="manage_delete_user{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_delete_user == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_delete_user{{ $role->id }}">Delete-User</label>
                                                                            </div>

                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_item_unit"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_item_unit"
                                                                                    id="manage_item_unit{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_item_unit == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_item_unit{{ $role->id }}">M-Unit</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_edit_itemUnit"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_edit_itemUnit"
                                                                                    id="manage_edit_itemUnit{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_edit_itemUnit == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_edit_itemUnit{{ $role->id }}">Edit-Unit</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_delete_itemUnit"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_delete_itemUnit"
                                                                                    id="manage_delete_itemUnit{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_delete_itemUnit == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_delete_itemUnit{{ $role->id }}">Delete-Unit</label>
                                                                            </div>
                                                                        </td>

                                                                        <!-- Column 2: Location / Item / Unit -->
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_location" value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="manage_location"
                                                                                    id="manage_location{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_location == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_location{{ $role->id }}">M-Location</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_edit_location"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_edit_location"
                                                                                    id="manage_edit_location{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_edit_location == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_edit_location{{ $role->id }}">Edit-Location</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_delete_location"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_delete_location"
                                                                                    id="manage_delete_location{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_delete_location == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_delete_location{{ $role->id }}">Delete-Location</label>
                                                                            </div>

                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_customer" value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="manage_customer"
                                                                                    id="manage_customer{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_customer == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_customer{{ $role->id }}">M-Customer</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_edit_customer"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_edit_customer"
                                                                                    id="manage_edit_customer{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_edit_customer == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_edit_customer{{ $role->id }}">Edit-Customer</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_delete_customer"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_delete_customer"
                                                                                    id="manage_delete_customer{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_delete_customer == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_delete_customer{{ $role->id }}">Delete-Customer</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_dailycustomerReport"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_dailycustomerReport"
                                                                                    id="manage_dailycustomerReport{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_dailycustomerReport == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_dailycustomerReport{{ $role->id }}">CustomerReport</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_customer_history"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_customer_history"
                                                                                    id="manage_customer_history{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_customer_history == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_customer_history{{ $role->id }}">CustomerHistory</label>
                                                                            </div>
                                                                        </td>

                                                                        <!-- Column 3: Category / Shelf / Customer -->
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_category" value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="manage_category"
                                                                                    id="manage_category{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_category == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_category{{ $role->id }}">M-Category</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_edit_category"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_edit_category"
                                                                                    id="manage_edit_category{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_edit_category == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_edit_category{{ $role->id }}">Edit-Category</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_delete_category"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_delete_category"
                                                                                    id="manage_delete_category{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_delete_category == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_delete_category{{ $role->id }}">Delete-Category</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden" name="manage_sales"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="manage_sales"
                                                                                    id="manage_sales{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_sales == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_sales{{ $role->id }}">M-Sales</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_edit_sales"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_edit_sales"
                                                                                    id="manage_edit_sales{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_edit_sales == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_edit_sales{{ $role->id }}">Edit-Sales</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_delete_sales"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_delete_sales"
                                                                                    id="manage_delete_sales{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_delete_sales == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_delete_sales{{ $role->id }}">Delete-Sales</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_dailysalesReport"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_dailysalesReport"
                                                                                    id="manage_dailysalesReport{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_dailysalesReport == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_dailysalesReport{{ $role->id }}">SalesReport</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_shopStock_reports"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_shopStock_reports"
                                                                                    id="manage_shopStock_reports{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_shopStock_reports == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_shopStock_reports{{ $role->id }}">ShopStockReport</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_shopTRansferReports"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_shopTRansferReports"
                                                                                    id="manage_shopTRansferReports{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_shopTRansferReports == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_shopTRansferReports{{ $role->id }}">ShopTransferReport</label>
                                                                            </div>
                                                                        </td>

                                                                        <!-- Column 4: Good Receiving / Disposal / Sales -->
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input type="hidden" name="manage_shelf"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="manage_shelf"
                                                                                    id="manage_shelf{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_shelf == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_shelf{{ $role->id }}">M-Shelf</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_edit_shelf"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_edit_shelf"
                                                                                    id="manage_edit_shelf{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_edit_shelf == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_edit_shelf{{ $role->id }}">Edit-Shelf</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_delete_shelf"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_delete_shelf"
                                                                                    id="manage_delete_shelf{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_delete_shelf == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_delete_shelf{{ $role->id }}">Delete-Shelf</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_good_receiving"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_good_receiving"
                                                                                    id="manage_good_receiving{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_good_receiving == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_good_receiving{{ $role->id }}">M-GoodReceiving</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_edit_goodreceiving"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_edit_goodreceiving"
                                                                                    id="manage_edit_goodreceiving{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_edit_goodreceiving == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_edit_goodreceiving{{ $role->id }}">Edit-GoodReceiving</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_delete_goodreceiving"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_delete_goodreceiving"
                                                                                    id="manage_delete_goodreceiving{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_delete_goodreceiving == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_delete_goodreceiving{{ $role->id }}">Delete-GoodReceiving</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_stock_reports"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_stock_reports"
                                                                                    id="manage_stock_reports{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_stock_reports == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_stock_reports{{ $role->id }}">StockReport</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_storeTRansferReports"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_storeTRansferReports"
                                                                                    id="manage_storeTRansferReports{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_storeTRansferReports == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_storeTRansferReports{{ $role->id }}">TStoreTransferReport</label>
                                                                            </div>
                                                                        </td>

                                                                        <!-- Column 5: Reports / Transfers -->
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input type="hidden" name="manage_item"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="manage_item"
                                                                                    id="manage_item{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_item == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_item{{ $role->id }}">M-Item</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_edit_item"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_edit_item"
                                                                                    id="manage_edit_item{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_edit_item == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_edit_item{{ $role->id }}">Edit-Item</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_delete_item"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_delete_item"
                                                                                    id="manage_delete_item{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_delete_item == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_delete_item{{ $role->id }}">Delete-Item</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_disposal" value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="manage_disposal"
                                                                                    id="manage_disposal{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_disposal == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_disposal{{ $role->id }}">M-Disposal</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_edit_disposal"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_edit_disposal"
                                                                                    id="manage_edit_disposal{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_edit_disposal == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_edit_disposal{{ $role->id }}">Edit-Disposal</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_delete_disposal"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_delete_disposal"
                                                                                    id="manage_delete_disposal{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_delete_disposal == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_delete_disposal{{ $role->id }}">Delete-Disposal</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden" name="approval"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="approval"
                                                                                    id="approval{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->approval == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="approval{{ $role->id }}">Approval</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="hidden"
                                                                                    name="manage_activity_log"
                                                                                    value="off">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="manage_activity_log"
                                                                                    id="manage_activity_log{{ $role->id }}"
                                                                                    value="on"
                                                                                    @checked($role->manage_activity_log == 'on')>
                                                                                <label class="form-check-label"
                                                                                    for="manage_activity_log{{ $role->id }}">ActivityLog</label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- Column 6: Actions -->


                                                                    <tr>
                                                                        <td>
                                                                            <button type="submit"
                                                                                class="btn btn-warning btn-sm">
                                                                                <i class="fas fa-save"></i> Save
                                                                            </button>
                                                                            <a href="{{ url('delete-role-' . $role->id) }}"
                                                                                class="btn btn-danger btn-sm"
                                                                                onclick="return confirm('Are you sure you want to delete this role?');">
                                                                                <i class="fas fa-trash"></i>
                                                                            </a>
                                                                        </td>

                                                                    </tr>
                                                                </form>
                                                            @endif
                                                        @empty
                                                            <tr>
                                                                <td colspan="7" class="text-center text-muted">No roles
                                                                    found.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
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
