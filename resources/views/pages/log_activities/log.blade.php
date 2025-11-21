@extends('inc.frame')
@section('content')
    <div class="container">
        <h2 class="mb-4">System Activity Logs</h2>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <table id="example1" class="table table-bordered table-striped "
                        style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Model</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $key => $activity)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $activity->causer ? $activity->causer->name : 'System' }}
                                    </td>
                                    <td>{{ $activity->description }}</td>
                                    <td>{{ class_basename($activity->subject_type) }}</td>
                                    <td>{{ $activity->created_at->timezone('Africa/Mogadishu')->format('Y-m-d h:i:s A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No activity logs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @endsection
