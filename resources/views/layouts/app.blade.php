<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">




    @yield('css')
</head>

<body class="skin-blue sidebar-mini">
    @if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <b>{{ env('APP_NAME') }}</b>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{ asset('images/admin-images.png') }}" class="user-image" alt="User Image" />
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{!! Auth::user()->username !!}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{{ asset('images/admin-images.png') }}" class="img-circle" alt="User Image" />
                                    <p>
                                        {!! Auth::user()->username !!}
                                        <small>Member since {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{!! route('userRegistrations.EditProfile', [Auth::user()->id]) !!}" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Sign out
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © 2019 <a href="#">PlayRummy</a>.</strong> All rights reserved.
        </footer>

    </div>
    @else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{!! url('/') !!}">
                    {{ env('APP_NAME') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/home') !!}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/login') !!}">Login</a></li>
                    <li><a href="{!! url('/register') !!}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- jQuery 3.1.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>



    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>

    @yield('scripts')
    <script>
        $(document).ready(function() {
            /*  $('#start_date').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss',
			 
        }); */
            /* 	$('#start_date').on('changeDate', function(ev){
            		$(this).datetimepicker('hide');
            	}); */

        });
        $(document).ready(function() {
            let base_url = "<?=URL::to('/');?>";
            $('#date_time').datetimepicker({
                format: 'YYYY-MM-DD hh:mm:ss',
            });

            $('#date_time').on('changeDate', function(ev) {
                $(this).datetimepicker('hide');
            });

            $("select[name='report_type']").change(function(){
                withdrawDatatable.ajax.reload();
            });

            // $('#withdrawAmounts-table').DataTable({

            //     "paging": true,
            //     "searching": true,
            //     dom: 'Bfrtip',
            //     buttons: [{
            //         extend: 'excelHtml5',
            //         autoFilter: true,
            //         sheetName: 'Exported data'
            //     }]
            // });
            let withdrawDatatable = $('#withdrawAmounts-table').DataTable({
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    autoFilter: true,
                    sheetName: 'Exported data'
                }],
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                'aaSorting':[[0,'desc']],
                'paginate':true,
                "ajax": {
                    "url": "{{ route('withdrawAmounts.datatable') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        "type": function(){ return $("select[name='report_type']").val()},
                    }
                },
                columns: [
                    { data: 'user_id', name: 'user_id', searchable: true },
                    { data: 'username', name: 'username', searchable: true },
                    { data: 'amount', name: 'amount', searchable: true },
                    { data: 'is_released', name: 'is_released', searchable: true, render:function(row, type, data){
                        if(data.is_released == 'checked'){
                            return `<label class="text-info text-center text-uppercase">
                                <i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> &nbsp; Checked
                            </label>`;
                        }
                        else if(data.is_released == 'pending'){
                            return `<a href="${base_url}/payment_release/${data.id}" class="btn btn-danger text-center text-uppercase">
                                <i class="fa fa-bell" aria-hidden="true"></i> &nbsp; Pending</a>`;
                        }
                        else{
                            return `<label class="text-success text-center text-uppercase">
                                <i class="fa fa-money" aria-hidden="true"></i> &nbsp; Released
                            </label>`;
                        }
                    } },
                    { data: 'updated_at', name: 'updated_at', searchable: true },
                    { data: 'action', name: 'action', searchable: true, render: function ( row, type, data ) {
                        return `<a href="${base_url}/withdrawAmounts/show/${data.id}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>`;
                     }},
                ],
                "order": [],
            });

            // $('#playGames-table').DataTable({

            //     "paging": true,
            //     "searching": true,
            //     dom: 'lBfrtip',
            //     buttons: [{
            //         extend: 'excelHtml5',
            //         autoFilter: true,
            //         sheetName: 'Exported data'
            //     }]
            // });
            $('#playGames-table').DataTable({
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    autoFilter: true,
                    sheetName: 'Exported data'
                }],
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                'aaSorting':[[0,'desc']],
                'paginate':true,
                "ajax": {
                    "url": "{{ route('playGames.datatable') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: 'game_type', name: 'game_type', orderable: true, searchable: true },
                    { data: 'game_id', name: 'game_id', searchable: true },
                    { data: 'username', name: 'username', searchable: true },
                    { data: 'total_players', name: 'total_players', searchable: true },
                    { data: 'entry_fee', name: 'entry_fee', searchable: true },
                    { data: 'status', name: 'status', searchable: true, render: function ( row, type, data ) {
                        if(data.status == 'loss'){
                            return `<label class="text-danger text-center text-uppercase" name="mobile_verified"> loss</label>`;
                            }
                            else{
                                return `<label class="text-info text-center text-uppercase" name="mobile_verified"> win</label>`;
                        }} 
                     },
                    { data: 'created_at', name: 'created_at', searchable: true},
                ],
                "order": [],
            });

            // $('#transactions-table').DataTable({

            //     "paging": true,
            //     "searching": true,
            //     dom: 'lBfrtip',
            //     buttons: [{
            //         extend: 'excelHtml5',
            //         autoFilter: true,
            //         sheetName: 'Exported data'
            //     }]
            // });
            $('#transactions-table').DataTable({
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    autoFilter: true,
                    sheetName: 'Exported data'
                }],
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                'aaSorting':[[0,'desc']],
                'paginate':true,
                "ajax": {
                    "url": "{{ route('transactions.depositDatatable') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: 'username', name: 'username', searchable: true },
                    { data: 'transaction_id', name: 'transaction_id', orderable: true, searchable: true },
                    { data: 'trans_type', name: 'trans_type', searchable: true },
                    { data: 'amount', name: 'amount', searchable: true },
                    { data: 'created_at', name: 'created_at', searchable: true },
                ],
                "order": [],
            });
            $('#referrals-table').DataTable({
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    autoFilter: true,
                    sheetName: 'Exported data'
                }],
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                'aaSorting':[[0,'desc']],
                'paginate':true,
                "ajax": {
                    "url": "{{ route('transactions.referDatatable') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: 'username', name: 'username', searchable: true },
                    { data: 'transaction_id', name: 'transaction_id', orderable: true, searchable: true },
                    { data: 'amount', name: 'amount', searchable: true },
                    { data: 'created_at', name: 'created_at', searchable: true },
                ],
                "order": [],
            });
            $('#gameresult-table').DataTable({
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    autoFilter: true,
                    sheetName: 'Exported data'
                }],
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                'aaSorting':[[0,'desc']],
                'paginate':true,
                "ajax": {
                    "url": "{{ route('transactions.gameResultsDatatable') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: 'username', name: 'username', searchable: true },
                    { data: 'game_type', name: 'game_type', orderable: true, searchable: true },
                    { data: 'win_amount', name: 'win_amount', searchable: true },
                    { data: 'status', name: 'status', searchable: true },
                    { data: 'created_at', name: 'created_at', searchable: true },
                ],
                "order": [],
            });
            // $('#transactions-table1').DataTable({
            //     dom: 'lBfrtip',
            //     buttons: [{
            //         extend: 'excelHtml5',
            //         autoFilter: true,
            //         sheetName: 'Exported data'
            //     }],
            //     "processing": true,
            //     "serverSide": true,
            //     "stateSave": true,
            //     'aaSorting':[[0,'desc']],
            //     'paginate':true,
            //     "ajax": {
            //         "url": "{{ route('userRegistration.datatable') }}",
            //         "type": "POST",
            //         "data": {
            //             "_token": "{{ csrf_token() }}"
            //         }
            //     },
            //     columns: [
            //         { data: 'username', name: 'username', orderable: true, searchable: true },
            //         { data: 'transaction_id', name: 'transaction_id', searchable: true },
            //         { data: 'transaction_type', name: 'transaction_type', searchable: true },
            //         { data: 'amount', name: 'amount', searchable: true },
            //         { data: 'created_at', name: 'created_at', searchable: true },
            //     ],
            //     "order": [],
            // });

            // $('#userRegistrations-table').DataTable( {

            // 		"paging":true,
            // 		"searching": true,
            // 		dom: 'Bfrtip',
            //     buttons: [ {
            //         extend: 'excelHtml5',
            //         autoFilter: true,
            //         sheetName: 'Exported data'
            //     } ]
            // } );
            $('#userRegistrations-table').DataTable({
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                'aaSorting':[[0,'desc']],
                'paginate':true,
                "paging": true,
                "ajax": {
                    "url": "{{ route('userRegistration.datatable') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                // "drawCallback": function() {
                //     var i = 0;
                //     $("#datatable .editIcon").each(function() {
                //         $(this).attr('id', 'edit_' + i);
                //     });

                //     i = 0;
                //     $("#datatable .deleteIcon").each(function() {
                //         $(this).attr('id', 'delete_' + i);
                //     });
                // },
                columns: [
                    { data: 'id', name: 'id', orderable: true, searchable: true },
                    { data: 'username', name: 'username', searchable: true },
                    { data: 'email', name: 'email', searchable: true },
                    { data: 'dob', name: 'dob', searchable: true },
                    { data: 'gender', name: 'gender', searchable: true },
                    { data: 'state', name: 'state', searchable: true },
                    { data: 'created_at', name: 'created_at', searchable: true },
                    { data: 'is_block', name: 'is_block', searchable: true , render: function ( row, type, data ) {
                        if(data.is_block == 1){
                            return `<a href="${base_url}/user_action/${data.id}" class="btn btn-success" name="is_status">Unblock</a>`;
                            }
                            else{
                                return `<a href="${base_url}/user_action/${data.id}" class="btn btn-danger" name="is_status">Block</a>`;
                        }} 
                     },
                    { data: 'mobile_verified_at', name: 'mobile_verified_at', searchable: true, render: function ( row, type, data ) {
                        if(data.mobile_verified_at != null){
                            return `<label class="text-info text-center text-uppercase" name="mobile_verified"> Verified</label>`;
                            }
                            else{
                                return `<label class="text-danger text-center text-uppercase" name="mobile_verified"> Unverified</label>`;
                        }}  },
                    { data: 'email_verified_at', name: 'email_verified_at', searchable: true, render: function ( row, type, data ) {
                        if(data.email_verified_at != null){
                            return `<label class="text-info text-center text-uppercase" name="mobile_verified"> Verified</label>`;
                            }
                            else{
                                return `<label class="text-danger text-center text-uppercase" name="mobile_verified"> Unverified</label>`;
                        }}},
                    { data: 'kyc_verified_at', name: 'kyc_verified_at', searchable: true, render: function ( row, type, data ) {
                        if(data.kyc_verified_at != null){
                            return `<label class="text-info text-center text-uppercase" name="mobile_verified"> Verified</label>`;
                            }
                            else{
                                return `<label class="text-danger text-center text-uppercase" name="mobile_verified"> Unverified</label>`;
                        }}},
                    { data: 'actions', name: 'actions', searchable: true, render: function ( row, type, data ) {
                        // <a href="${base_url}/editProfile/${data.id}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        return `
                                <a href="${base_url}/userActivity/${data.id}" class='btn btn-xs'><i title="View Activity" class="glyphicon glyphicon-eye-open"></i></a>
                                <a href="${base_url}/destroy/${data.id}" class='btn btn-danger btn-xs'><i title="Delete" class="glyphicon glyphicon-trash"></i></a>
                                `;
                        }},
                ],
                "order": [],
            });
            $('#userActivity-game-table').DataTable({
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                'aaSorting':[[0,'desc']],
                'paginate':true,
                "paging": true,
                "ajax": {
                    "url": "{{ route('userRegistration.userActivityDataTable') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        "user_id":"{{request()->route('id')}}"
                    }
                },
                // "drawCallback": function() {
                //     var i = 0;
                //     $("#datatable .editIcon").each(function() {
                //         $(this).attr('id', 'edit_' + i);
                //     });

                //     i = 0;
                //     $("#datatable .deleteIcon").each(function() {
                //         $(this).attr('id', 'delete_' + i);
                //     });
                // },
                columns: [
                    { data: 'id', name: 'id', searchable: true },
                    { data: 'username', name: 'username', searchable: true },
                    { data: 'game_name', name: 'game_name', searchable: true },
                    { data: 'game_type', name: 'game_type', searchable: true },
                    { data: 'tournament_name', name: 'tournament_name', searchable: true },
                    { data: 'status', name: 'status', searchable: true },
                    { data: 'entry_fee', name: 'entry_fee', searchable: true },
                    { data: 'win_amount', name: 'win_amount', searchable: true },
                    { data: 'game_date', name: 'game_date', searchable: true },
                    { data: 'result_date', name: 'result_date', searchable: true },
                ],
                "order": [],
            });

            $('#gameTournaments-table').DataTable({

                "paging": true,
                "searching": true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    autoFilter: true,
                    sheetName: 'Exported data'
                }]
            });

            $('#chips-table').DataTable({

                "paging": true,
                "searching": true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    autoFilter: true,
                    sheetName: 'Exported data'
                }]
            });
            $('#rewards-table').DataTable({
                "paging": true,
                "searching": true,
                'aaSorting':[[0,'desc']],
                'paginate':true,
                "paging": true,
                "ajax": {
                    "url": "{{ route('rewards.datatable') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        "user_id":"{{request()->route('id')}}"
                    }
                },
                columns: [
                    { data: 'reward', name: 'reward', searchable: true },
                    { data: 'chips', name: 'chips', searchable: true },
                    // { data: 'action', name: 'action', searchable: true },
                    { data: 'actions', name: 'actions', searchable: true, render: function ( row, type, data ) {
                        return `
                                <a href="${base_url}/rewards/edit/${data.id}" class='btn btn-xs'><i title="View Activity" class="glyphicon glyphicon-edit"></i></a>
                                <a href="${base_url}/rewards/destroy/${data.id}" class='btn btn-danger btn-xs'><i title="Delete" class="glyphicon glyphicon-trash"></i></a>
                                `;
                        }},
                ],
                "order": [],                
            });
            $('#gameLevel-table').DataTable({
                "paging": true,
                "searching": true,
                'aaSorting':[[0,'desc']],
                'paginate':true,
                "paging": true,
                "ajax": {
                    "url": "{{ route('rank.datatable') }}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        "user_id":"{{request()->route('id')}}"
                    }
                },
                columns: [
                    { data: 'level', name: 'level', searchable: true },
                    { data: 'matches', name: 'matches', searchable: true },
                    { data: 'actions', name: 'actions', searchable: true, render: function ( row, type, data ) {
                        return `
                                <a href="${base_url}/rank/edit/${data.id}" class='btn btn-xs'><i title="View Activity" class="glyphicon glyphicon-edit"></i></a>
                                <a href="${base_url}/rank/destroy/${data.id}" class='btn btn-danger btn-xs'><i title="Delete" class="glyphicon glyphicon-trash"></i></a>
                                `;
                        }},
                ],
                "order": [],                
            });
        });
    </script>
</body>

</html>