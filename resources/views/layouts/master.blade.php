<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Grafic garzi medici</title>

 <link rel="stylesheet" href="/css/app.css">
</head>
<body class="hold-transition sidebar-mini text-sm">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-danger">
<!-- Left navbar links -->
<ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link " data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

    <!-- SEARCH FORM -->
    <div class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="searchit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->

        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
              class="fas fa-th-large"></i></a>
        </li>
      </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-danger elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
      <img src="./img/logo.png" alt="{{ config('app.name', 'Laravel') }}" class="brand-image img-rounded elevation-2">
      <span class="brand-text font-weight-bold">{{ config('app.name', 'App Name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-flat nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <router-link to="/dashboard" tag="a" class="nav-link"  active-class="active" exact>
                  <i class="nav-icon fas fa-th blue"></i>
                  <p>DASHBOARD</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/profile" tag="a" class="nav-link"  active-class="active" exact>
                  <i class="nav-icon fas fa-id-badge orange"></i>
                  <p>PROFILE
                  </p>
                </router-link>
              </li>
              @can('isAdmin')
              <li class="nav-item">
                <router-link to="/developer" tag="a" class="nav-link"  active-class="active" exact>
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>DEVELOPER
                  </p>
                </router-link>
              </li>
              @endcan
             @can('isAdmin')
              <li class="nav-item has-treeview menu-close active">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-users blue"></i>
                  <p>
                    MANAGEMENT
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <router-link to="/users" tag="a" class="nav-link"  active-class="active" exact>
                      <i class="fas fa-caret-right nav-icon blue"></i>
                      <p>USERS</p>
                    </router-link>
                  </li>
                </ul>
              </li>
              @endcan
          <li class="nav-item has-treeview menu-close">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog green"></i>
              <p>
                GRAFIC GARZI SPITAL
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="grafic" class="nav-link">
                      <i class="fas fa-caret-right nav-icon green"></i>
                      <p>GRAFIC GARZI</p>
                    </a>
                  </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-caret-right nav-icon green"></i>
                  <p>CHIRURGIE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-caret-right nav-icon green"></i>
                  <p>MEDICINA INTERNA</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-caret-right nav-icon green"></i>
                  <p>CPU</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-caret-right nav-icon green"></i>
                  <p>ATI</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-caret-right nav-icon green"></i>
                  <p>OBST. GINECOLOGIE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-caret-right nav-icon green"></i>
                  <p>PEDIATRIE</p>
                </a>
              </li>

            </ul>
          </li>
          <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                       <i class="nav-icon fa fa-power-off red"></i>
                       <p>LOGOUT</p>
               </a>
               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <!-- Main content -->

        <!-- aici mapeaza vue rutarea fisierelor -->
        <!-- display the component content here -->
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-light">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">

            <div class="text-danger">
                <i class="fas fa-user-shield"></i>
              <strong>{{ Auth::user()->name }}</strong>

            </div>

    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020-2025 <a href="https://www.spitalcampina.ro">Spitalul Municipal Campina</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

@auth
    <script>
        window.user = @JSON(auth()->user());
    </script>
@endauth
<!-- REQUIRED SCRIPTS -->

<script src="/js/app.js"></script>
</body>
</html>
