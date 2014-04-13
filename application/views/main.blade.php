<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="shortcut icon" href="/assets/img/favicon.ico?v=2" type="image/x-icon">
        <link rel="icon" href="/assets/img/favicon.ico?v=2" type="image/x-icon">
        <title>Wheelzo</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=PT+Sans&subset=latin,latin-ext,cyrillic,cyrillic-ext">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/basic/jquery.qtip.min.css">
        <link rel="stylesheet" href="/assets/css/main.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        <div class="jumbotron">
            <div class="container">
                <div class="row" id="introduction">
                    <div class="col-sm-2 text-center">
                        <a href="/">
                            <img class="brand-logo" src="/assets/img/logo.png" width="100%">
                        </a>
                    </div>
                    <div class="col-sm-10">
                        <h1>
                            <a id="toggle-getting-started" href="#">Together</a> on the road...
                        </h1>
                        <p>
                            Wheelzo v{{ CURRENT_VERSION }}
                            @if ( $session )
                                <a class="btn btn-danger btn-xs" id="facebook-session" href="{{ $session_url }}" title="Logout">
                                    <i class="fa fa-sign-out fa-lg"></i> {{ $users[$session]['name'] }}
                                </a>
                            @else
                                <a class="btn btn-primary btn-xs" id="facebook-session" href="{{ $session_url }}">
                                    <i class="fa fa-facebook fa-lg"></i> Login with Facebook
                                </a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <a class="btn btn-default" @if($session) data-toggle="modal" data-target="#create-ride" @else id="facebook-session" href="{{ $session_url }}" @endif>
                        <i class="fa fa-plus fa-lg"></i> Create Ride
                    </a>
                    @if ( !$session )
                        <small>
                            (Login required)
                        </small>
                    @endif
                </div>
                <div class="col-xs-6">
                    <input type="text" class="form-control" id="search-box" placeholder="Search rides ...">
                </div>                    
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>Origin</th>  
                            <th>Destination</th>  
                            <th>Departure</th> 
                            <th>Price</th>
                            <th class="ninja-header">Driver</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $rides as $ride )
                            <tr data-ride-id="{{ $ride->id }}">
                                <td>{{ $ride->origin }}</td>
                                <td>{{ $ride->destination }}</td>
                                <td>{{ date( 'M j, g:ia', strtotime($ride->start) ) }}</td>
                                <td>{{ $ride->price }}</td>
                                <td class="ninja-field">{{ $users[$ride->driver_id]['name'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <!-- Footer -->
            <footer>
                <hr>
                <span>
                    &copy; Wheelzo v{{ CURRENT_VERSION }}    
                </span>
                <small>
                    Made by nerds from <a href="//uwaterloo.ca">uWaterloo</a>
                </small>
            </footer><!-- /.footer -->
        </div><!-- /container -->
        
        <?php 
            $this->load->view('modals/main',
                array(
                    'session' => $session,
                    'users' => $users
                )
            ); 
        ?>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/basic/jquery.qtip.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="/assets/vendor/typeahead/bootstrap3-typeahead.js"></script>
        <script src="/assets/vendor/timepicker/jquery-ui-timepicker-addon.js"></script>
        <script src="/assets/vendor/timepicker/jquery-ui-sliderAccess.js"></script>
        <script src="/assets/vendor/moment/moment.min.js"></script>
        <script src="/assets/js/initializer.js"></script>
        <script src="/assets/js/templates.js"></script>
        <script src="/assets/js/handlers.js"></script>
        <script src="/assets/js/helpers.js"></script>
        <script src="/assets/js/main.js"></script>
        <script>
            var rides = {{ json_encode($rides) }} ;
            var publicUsers = {{ json_encode($users) }} ;
            var session_id = {{ $session ? $session : 'false' }};
        </script>
    </body>
</html>




