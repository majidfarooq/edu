@extends('backend.layouts.app')

@section('style')

    <style type="text/css">

        td.action {
            display: flex;
            gap: 10px;
        }

        [data-title]:hover:after {
            opacity: 1;
            transition: all 0.1s ease 0.5s;
            visibility: visible;
        }

        [data-title]:after {
            content: attr(data-title);
            background-color: #f8f9fc;
            color: #4e73df;
            font-size: 15px;
            position: absolute;
            padding: 1px 5px 2px 5px;
            top: -35px;
            left: 0;
            white-space: nowrap;
            box-shadow: 1px 1px 3px #4e73df;
            opacity: 0;
            border: 1px solid #4e73df;
            z-index: 99999;
            visibility: hidden;
        }

        [data-title] {
            position: relative;
        }

    </style>

@endsection

@section('content')

    <div class="row">

        <div class="col-12">

            <div class="card border-0">

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

            <!--end card-body-->

            </div>

        </div>

        <!--end col-->

    </div>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Student</h1>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Student</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Type</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($users))
                            @php $counter=1; @endphp
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                    <td>{{ $user->type }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->gender }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td name="buttons">
                                        <div class="pull-right">
                                            <a href="{{ route('user-detail',$user->id) }}">
                                                <button id="bEdit" type="button" class="btn btn-info btn-circle mr-2"><i class="fas fa-edit"></i></button>
                                            </a>
                                            <a onclick="return confirm(' you want to delete?');" href="{{ route('admin.users.destroy',$user->id) }}">
                                                <button id="bElim" type="button" class="btn btn-danger btn-circle"><i class="fas fa-trash-alt"></i></button>
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

@endsection


