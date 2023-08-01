@extends('backend.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                    </div>
                    <h4 class="page-title">Investors</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <h4 class="mt-0 header-title">Investor Users</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if ($message = \Illuminate\Support\Facades\Session::get('error'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>Date Joined</th>
                                    <th>Last Login</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Business</th>
                                    <th>Phone</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($users))
                                    @php $counter=1; @endphp
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d H:i:s') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($user->last_login)->format('Y-m-d H:i:s') }}</td>
                                            <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->business_name }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d F, h:m A, Y') }}</td>
                                            <td name="buttons">
                                                <div class="pull-right">
                                                    <a href="{{ route('user-detail',$user->id) }}">
                                                        <button id="bEdit" type="button" class="btn btn-sm btn-soft-success btn-circle mr-2"><i class="dripicons-document-edit"></i></button>
                                                    </a>
                                                    <a onclick="return confirm(' you want to delete?');" href="{{ route('deleteUser',$user->id) }}">
                                                        <button id="bElim" type="button" class="btn btn-sm btn-soft-danger btn-circle"><i class="dripicons-trash" aria-hidden="true"></i></button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $counter++; @endphp
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="5"><i>No Record Found!</i></td>
                                        </tr>
                                    @endforelse
                                @endif
                                </tbody>
                            </table>
                            <p><?php  if(isset($links)){ echo $links; } ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('public/assets/backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/assets/backend/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    @include('flashy::message')
    <script> </script>
@endsection
