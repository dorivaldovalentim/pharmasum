@php
    use App\Models\Notification;
    $notification = [
        'all' => Notification::whereStatus(0)->get()->count(), 
        'expireds' => Notification::whereType(1)->whereStatus(0)->get()->count(),
        'lowqtd' => Notification::whereType(2)->whereStatus(0)->get()->count(),
    ];
@endphp

<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <!-- CSS Libs -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/checkbox3.min.css') }}">
    <!-- CSS App -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/flat-blue.css') }}">
</head>

<body class="flat-blue">
    <div class="app-container">
        <div class="row content-container">
            <nav class="navbar navbar-default navbar-fixed-top navbar-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-expand-toggle">
                            <i class="fa fa-bars icon"></i>
                        </button>
                        <ol class="breadcrumb navbar-breadcrumb">
                            <li class="active">Dashboard</li>
                        </ol>
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-th icon"></i>
                        </button>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-times icon"></i>
                        </button>
                        @if(!Auth::user()->status)
                            <li class="dropdown danger">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bell"></i> {{$notification['all']}}</a>
                                <ul class="dropdown-menu danger  animated fadeInDown">
                                    <li class="title">
                                        Notification <span class="badge pull-right">{{$notification['all']}}</span>
                                    </li>
                                    <li>
                                        <ul class="list-group notifications">
                                            <a href="#">
                                                <li class="list-group-item">
                                                    <span class="badge danger">{{$notification['expireds']}}</span> <i class="fa fa-exclamation-circle icon"></i> Produtos expirados
                                                </li>
                                            </a>
                                            <a href="#">
                                                <li class="list-group-item">
                                                    <span class="badge danger">{{$notification['lowqtd']}}</span> <i class="fa fa-exclamation-circle icon"></i> Produtos com baixo estoque
                                                </li>
                                            </a>
                                            {{--  
                                            <a href="#">
                                                <li class="list-group-item">
                                                    <span class="badge success">1</span> <i class="fa fa-check icon"></i> new orders
                                                </li>
                                            </a>
                                            <a href="#">
                                                <li class="list-group-item">
                                                    <span class="badge danger">2</span> <i class="fa fa-comments icon"></i> customers messages
                                                </li>
                                            </a>  --}}
                                            <a href="{{ route('notifications') }}">
                                                <li class="list-group-item message">
                                                    ver todas
                                                </li>
                                            </a>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="dropdown profile">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{Auth::user()->name ? Auth::user()->name : Auth::user()->username}} <span class="caret"></span></a>
                            <ul class="dropdown-menu animated fadeInDown">
                                {{--  <li class="profile-img">
                                    <img src="../img/profile/picjumbo.com_HNCK4153_resize.jpg" class="profile-img">
                                </li>  --}}
                                <li>
                                    <div class="profile-info">
                                        <h4 class="username">{{Auth::user()->name ? Auth::user()->name : Auth::user()->username}}</h4>
                                        <p>{{Auth::user()->email}}</p>
                                        <div class="btn-group margin-bottom-2x" role="group">
                                            <button type="button" class="btn btn-default"><i class="fa fa-user"></i> Profile</button>
                                            @if(!Auth::user()->status)
                                                <a href="{{ route('admin.logout') }}" type="button" class="btn btn-default"><i class="fa fa-sign-out"></i> Logout</a>
                                            @else
                                                <a href="{{ route('user.logout') }}" type="button" class="btn btn-default"><i class="fa fa-sign-out"></i> Logout</a>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="side-menu sidebar-inverse">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="side-menu-container">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="#">
                                <div class="icon fa fa-paper-plane"></div>
                                <div class="title">CORSU-PHARMA</div>
                            </a>
                            <button type="button" class="navbar-expand-toggle pull-right visible-xs">
                                <i class="fa fa-times icon"></i>
                            </button>
                        </div>
                        <ul class="nav navbar-nav">
                            <li class="{{ Request::is('admin') ? 'active' : null }} {{ Request::is('*user/home') ? 'active' : null }}">
                                @if(!Auth::user()->status)
                                    <a href="{{route('admin.home')}}">
                                        <span class="icon fa fa-tachometer"></span><span class="title">Dashboard</span>
                                    </a>
                                @else
                                    <a href="{{route('home')}}">
                                        <span class="icon fa fa-tachometer"></span><span class="title">Dashboard</span>
                                    </a>
                                @endif
                            </li>
                            
                            @if(!Auth::user()->status)
                                <li class="{{ Request::is('*categories') ? 'active' : null }}">
                                    <a href="{{ route('category.list') }}">
                                        <span class="icon fa fa-book"></span><span class="title">Categorias</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('*clients') ? 'active' : null }}">
                                    <a href="{{ route('clients.list') }}">
                                        <span class="icon fa fa-user-md"></span><span class="title">Clientes</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('*manufacturers') ? 'active' : null }}">
                                    <a href="{{ route('manufacturer.list') }}">
                                        <span class="icon fa fa-barcode"></span><span class="title">Fabricantes</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('*providers') ? 'active' : null }}">
                                    <a href="{{ route('provider.list') }}">
                                        <span class="icon fa fa-ambulance"></span><span class="title">Fornecedores</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('*employees') ? 'active' : null }}">
                                    <a href="{{ route('employee.list') }}">
                                        <span class="icon fa fa-users"></span><span class="title">Funcionários</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('*products') ? 'active' : null }}">
                                    <a href="{{ route('product.list') }}">
                                        <span class="icon fa fa-tags"></span><span class="title">Produtos</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('*stocks') ? 'active' : null }}">
                                    <a href="{{ route('stock.list') }}">
                                        <span class="icon fa fa-cubes"></span><span class="title">Stock</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('*sales') ? 'active' : null }}">
                                    <a href="{{ route('sales.list') }}">
                                        <span class="icon fa fa-cart-plus"></span><span class="title">Vendas</span>
                                    </a>
                                </li>
                                <li class="panel panel-default dropdown {{ Request::is('*purchases') ? 'active' : null }} {{ Request::is('*purchases/create') ? 'active' : null }}">
                                    <a data-toggle="collapse" href="#dropdown-element">
                                        <span class="icon fa fa-cart-plus"></span><span class="title">Compras</span>
                                    </a>
                                    
                                    <div id="dropdown-element" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ul class="nav navbar-nav">
                                                <li><a href="{{ route('purchase.list') }}">Ver Compras</a></li>
                                                <li><a href="{{ route('purchase.create') }}">Efectuar Compra</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="{{ Request::is('*settings') ? 'active' : null }}">
                                    <a href="{{ route('admin.settings') }}">
                                        <span class="icon fa fa-cog"></span><span class="title">Configurações</span>
                                    </a>
                                </li>
                            @else
                                <li class="{{ Request::is('*clients') ? 'active' : null }}">
                                    <a href="{{ route('client.list') }}">
                                        <span class="icon fa fa-user-md"></span><span class="title">Clientes</span>
                                    </a>
                                </li>

                                <li class="{{ Request::is('*user/products') ? 'active' : null }}">
                                    <a href="{{ route('user.product.list') }}">
                                        <span class="icon fa fa-tags"></span><span class="title">Produtos</span>
                                    </a>
                                </li>

                                <li class="panel panel-default dropdown {{ Request::is('*user/sale') ? 'active' : null }} {{ Request::is('*user/sales') ? 'active' : null }}">
                                    <a data-toggle="collapse" href="#dropdown-element">
                                        <span class="icon fa fa-cart-plus"></span><span class="title">Vendas</span>
                                    </a>
                                    
                                    <div id="dropdown-element" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ul class="nav navbar-nav">
                                                <li><a href="{{ route('sale.create') }}">Efectuar Venda</a></li>
                                                <li><a href="{{ route('sale.list') }}">Ver Venda</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>

                                <li class="{{ Request::is('*user/settings') ? 'active' : null }}">
                                    <a href="{{ route('settings') }}">
                                        <span class="icon fa fa-cog"></span><span class="title">Configurações</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body padding-top" id="app">
                   @yield('content')
                </div>
            </div>
        </div>
        <footer class="app-footer">
            <div class="wrapper">
                <span class="pull-right">2.1 <a href="#"><i class="fa fa-long-arrow-up"></i></a></span> &copy CES Copyright.
            </div>
        </footer>
        <div>
            <!-- Javascript Libs -->
            <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/bootstrap-switch.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/jquery.matchHeight-min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/ace/ace.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/ace/mode-html.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/ace/theme-github.js') }}"></script>
            <!-- Javascript -->
            <script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
            <!-- <script type="text/javascript" src="{{ asset('js/index.js') }}"></script> -->
            

</body>

</html>
