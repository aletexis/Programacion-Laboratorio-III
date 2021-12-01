{% extends 'principal.html' %}

{% block content %}


<header class="navbar navbar-expand bg-dark navbar-dark flex-column flex-md-row bd-navbar">
  <div class="navbar-nav-scroll">
    <ul class="navbar-nav bd-navbar-nav flex-row">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent"> <!--id="collapsibleNavbar"-->
          <ul class="navbar-nav">
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-primary" id="dropdownMenuButton1" data-toggle="dropdown"> <!--id="navbardrop"-->
                Listados<b class="caret"></b>
              </a>
              <div class="dropdown-menu">
                <button class="dropdown-item" id="usuarios">Usuarios</button>
                <button class="dropdown-item" id="autos">Autos</button>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link text-primary" onclick="AltaAutos()"> <!--id="altaPerfiles"-->
                Alta Autos <b class="caret"></b>
              </a>
            </li>
          </ul>
      </div>
    </ul>
  </div>
  <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">  
    <a class="navbar-brand d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3" >
      <img src="http://api_slim4/src/fotos/waa@wawa.ar_11.jpg" title="usuario" class="rounded-circle float-right" width="40" height="40">
    </a>
  </ul>
  <a class="btn btn-danger d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3" id="logout">Logout</a>
</header>

<div style="margin-top: 100px;">
    <!-- alert start -->
    <div class="alert alert-danger d-none" role="alert" >
        <p class="flex-fill"></p>
        <i class="fas fa-times close" style="cursor: pointer"></i>
    </div>
    <!-- alert end -->
</div>

<div class="container" style="height:auto;  padding-top: 5%; ">
<div class="row">
  <div id="divAlert">
  </div>
</div>
<div class="row">
  <div class="col bg-danger ">
    <div style="height: auto;" id="izquierda">
    </div>
  </div>

  <div class="col bg-success">
    <div style="height: auto" id="derecha">

    </div>
  </div>
</div>
</div>
{% endblock %}