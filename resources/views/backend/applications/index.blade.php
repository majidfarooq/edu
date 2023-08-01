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
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Applications - (@if(isset($applications)) {{$applications->count()}} @endif)</h1>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Listing</h6>
                <a class="btn btn-primary float-right" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                  Search Filters
                </a>
            </div>
            <div class="collapse @if(isset($isSearch) && !empty($isSearch)) show @endif" id="collapseExample">
                {!! Form::open(array('route' => 'admin.applications','id' => 'admin.applications','class'=>'','files' => true)) !!}
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="meta_title">University Name</label>
                                <input type="text" value="" class="form-control" id="title" placeholder="title here" name="title">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="meta_title">Start Date</label>
                                <input type="date" value="" class="form-control" id="start_date" name="start_date">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="meta_title">End Date</label>
                                <input type="date" value="" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="meta_title">Status</label>
                                <select class="form-control" name="status" id="">
                                    <option value="">Select</option>
                                    <option value="mark_pending">Pending</option>
                                    <option value="approve_shortlist">Approve/Shortlist</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="offer_extend">Offer Received</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group buttons-search">
                                <label for="meta_title"></label>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatables" class="table table-striped table-bordered mb-0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>University</th>
                            <th>Student</th>
                            <th>Season</th>
                            <th>Programe Type</th>
                            <th>Course</th>
                            <th>Apply Via</th>
                            <th>Status</th>
                            <th>Application Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($applications))
                            @php $counter=1; @endphp
                            @forelse ($applications as $app)
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>@if(isset($app->university)){{ $app->university->fullname }} @else N/A @endif</td>
                                    <td>@if(isset($app->user->first_name)){{ $app->user->first_name.' '.$app->user->last_name }}@else N/A @endif</td>
                                    <td>{{ ucfirst($app->season) }}</td>
                                    <td>{{ $app->program->title }}</td>
                                    <td>@if(isset($app->course->title)){{ $app->course->title }} @endif</td>
                                    <td>{{ str_replace('_',' ',$app->apply_via) }}</td>
                                    <td class="change status">
                                        @if($app->status=='mark_pending')
                                            <p onclick="changeStatusModal(this,'{{$app->id}}')">Pending</p>
                                        @elseif($app->status=='approve_shortlist')
                                            <p onclick="changeStatusModal(this,'{{$app->id}}')">@if($app->isOffered==1) Offer Accepeted @else ShortListed @endif</p>
                                        @elseif($app->status=='rejected')
                                            @if($app->notInterested==1)
                                                <p>Not Interested</p>
                                            @else
                                                <p onclick="changeStatusModal(this,'{{$app->id}}')">@if($app->isOffered==1) Offer Rejected @else Rejected @endif</p>
                                            @endif
                                        @elseif($app->status=='offer_extend')
                                            <p onclick="changeStatusModal(this,'{{$app->id}}')">Offer Received</p>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($app->created_at)->format('d F, h:m A, Y') }}</td>
                                    <td name="buttons">
                                        <div class="pull-right">
                                            <a onclick="return confirm(' you want to delete?');" href="{{ route('admin.application.destroy',$app->id) }}">
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

    <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Application Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('route' => 'changeApplicationModal','id' => 'changeApplicationModal','class'=>'','files' => true)) !!}
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Change Status:</label>
                            <input type="hidden" name="modal_status_id" id="modal_status_id" required>
                            <select class="form-control" name="status">
                                <option value="">Select</option>
                                <option value="mark_pending" >Pending</option>
                                <option value="approve_shortlist">Approve/shortlist</option>
                                <option value="rejected">Rejected</option>
                                <option value="offer_extend">Offer Extend</option>
                            </select>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection


@section('script')

    <script>
        function changeApplicationStatus(appId,elemt){
            var dataPost={}
            dataPost['application_id']=appId
            dataPost['status']=$(elemt).val()
            $.post('{{ route('changeApplicationStatus') }}',{_token:'{{ csrf_token() }}',data:dataPost},function(data){ location.reload() });
        }

    </script>


@endsection



