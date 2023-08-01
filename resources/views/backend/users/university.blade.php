@extends('backend.layouts.app')
@section('style')
    <style type="text/css">
        .dt-buttons.btn-group button {
            background: #4e73df !important;
            color: #fff;
            margin: 0px 8px 0px 0px;
            border-radius: 0;
        }
        .form-group.buttons-search button {
            display: block;
            width: 100%;
            margin-top: 7px;
        }
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

        .dt-buttons.btn-group {
            float: left;
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
    </div>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Universities</h1>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listing</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="universityDataTable" class="table table-striped table-bordered mb-0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Total Applications</th>
                            <th>Completed Applications</th>
                            <th>Active Applications</th>
                            <th>HBCUs</th>
                            <th>IsFeatured</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($users))
                            @php $counter=1; @endphp
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>{{ $user->fullname }}</td>
                                    <td>@if(isset($user->applications)) {{ $user->applications->count() }} @else 0 @endif</td>
                                    <td>@if(isset($user->applications)) {{ $user->applications->where('status','approve_shortlist')->count() }} @else 0 @endif</td>
                                    <td>@if(isset($user->applications)) {{ $user->applications->where('status','pending')->count() }} @else 0 @endif</td>
                                    <td>
                                        <select class="form-control" onchange="marKHbcu(this,{{$user->id}})">
                                            <option value="">Select</option>
                                            <option value="1" @if(isset($user->hbcu) && $user->hbcu==1) selected @endif>Yes</option>
                                            <option value="0" @if(isset($user->hbcu) && (int)$user->hbcu==0) selected @endif>No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" onchange="marKFeatured(this,{{$user->id}})">
                                            <option value="">Select</option>
                                            <option value="1" @if(isset($user->isFeatured) && $user->isFeatured==1) selected @endif>Yes</option>
                                            <option value="0" @if(isset($user->isFeatured) && (int)$user->isFeatured==0) selected @endif>No</option>
                                        </select>
                                    </td>
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
                </div>
            </div>
        </div>

    </div>

@endsection
@section('script')

    <script>
        $(document).ready(function() {
            $('#universityDataTable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'print','pdf','excel','csv'
                ]
            } );
        } );

    </script>


@endsection


