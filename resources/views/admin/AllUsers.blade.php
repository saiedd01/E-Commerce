@extends('admin.layout')

@section('body')
    <div class="container my-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Users List</h4>
                    </div>
                    <div class="card-body">
                        @include('error')
                        {{-- Search Form --}}
                        <form action="{{ url('search/user') }}" method="GET" class="mb-4">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="key" class="form-control" placeholder="Search users..."
                                    value="{{ request()->input('key') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-dark">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Orders</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td><a href="{{ url("user/orders/$user->id") }}"
                                                    class="btn btn-info btn-sm">View Orders</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
