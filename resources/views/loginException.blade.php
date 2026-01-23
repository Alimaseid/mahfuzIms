@extends('inc.frame')

@section('content')
    <section class="content">
        <div class="container-fluid">

            {{-- Page Title --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><b>User Login Exceptions</b></h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger mt-2">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- CREATE EXCEPTION --}}
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <b>Create New Exception</b>
                </div>

                <form method="POST" action="{{ route('admin.login-exceptions.store') }}">
                    @csrf

                    <div class="card-body row">
                        <div class="col-md-3">
                            <label>User</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Allowed From</label>
                            <input type="datetime-local" name="allowed_from" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label>Allowed To</label>
                            <input type="datetime-local" name="allowed_to" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label>Reason</label>
                            <input type="text" name="reason" class="form-control" placeholder="Optional">
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Exception
                        </button>
                    </div>
                </form>
            </div>

            {{-- LIST EXCEPTIONS --}}
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <b>Active / Past Exceptions</b>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($exceptions as $ex)
                                <tr>
                                    <form method="POST" action="{{ route('admin.login-exceptions.update', $ex) }}">
                                        @csrf
                                        @method('PUT')

                                        <td>{{ $ex->user->name }}</td>

                                        <td>
                                            <input type="datetime-local" name="allowed_from"
                                                class="form-control form-control-sm"
                                                value="{{ \Carbon\Carbon::parse($ex->allowed_from)->format('Y-m-d\TH:i') }}">
                                        </td>

                                        <td>
                                            <input type="datetime-local" name="allowed_to"
                                                class="form-control form-control-sm"
                                                value="{{ \Carbon\Carbon::parse($ex->allowed_to)->format('Y-m-d\TH:i') }}">
                                        </td>

                                        <td>
                                            <select name="active" class="form-control form-control-sm">
                                                <option value="1" {{ $ex->active ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$ex->active ? 'selected' : '' }}>Inactive
                                                </option>
                                            </select>
                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-success btn-xs">
                                                <i class="fas fa-save"></i> Update
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No login exceptions found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection
