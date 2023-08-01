@extends('backend.layouts.app')

@section('style')

@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a class="d-none d-sm-inline-block shadow-sm">
                <select class="form-control d-none d-sm-inline-block" onchange="sortby(this)">
                    <option value="">Sort By</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
            </a>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Applications</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($data['total_applications']) ? $data['total_applications'] : '' }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Active Applications</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($data['applications_active']) ? $data['applications_active'] : '' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Universities</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($data['university']) ? $data['university'] : '' }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Universities</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($data['university_active']) ? $data['university_active'] : '' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($data['student']) ? $data['student'] : '' }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($data['student_active']) ? $data['student_active'] : '' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Pages</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($data['pages']) ? $data['pages'] : '' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-fw fa-bullseye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Offers extended</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($data['isOffered']) ? $data['isOffered'] : '' }}</div>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Rejection</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($data['rejected']) ? $data['rejected'] : '' }}</div>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Approve Shortlist</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($data['approve_shortlist']) ? $data['approve_shortlist'] : '' }}</div>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Accepted Offers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($data['accepted']) ? $data['accepted'] : '' }}</div>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')

    @include('flashy::message')

    <script type="application/javascript">

        function sortby(elem){

            window.location='https://cloud.ferozitech.com/edu/admin/dashboard/'+$(elem).val()
        }

    </script>

@endsection

