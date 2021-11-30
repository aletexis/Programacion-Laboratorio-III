{% extends 'principal.html' %}

{% block content %}


<div class="container-fluid" style="margin-top:30px">

    <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">

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
              <button class="dropdown-item" onclick="MostrarUsuarios()">Usuarios</button> <!--id="usuarios"-->
              <button class="dropdown-item" onclick="MostrarAutos()">Autos</button> <!--id="autos"-->
            </div>
          </li>

          <li class="dropdown dropdown">
            <a class="nav-link text-primary" id="navbardrop" data-toggle="dropdown" onclick="AltaAutos()"> <!--id="altaPerfiles"-->
              Alta Autos <b class="caret"></b>
            </a>
          </li>
        </ul>
      </div>

      <div class="container">
        <a class="navbar-brand me-auto" >
          <img src="http://api_slim4/src/fotos/waa@wawa.ar_11.jpg" title="usuario" class="rounded-circle float-right" width="40" height="40">
        </a>
      </div>
      
    </nav>
  </div>

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
        <h6>IZQUIERDA</h6>
        <div style="height: auto;" id="izquierda">
        </div>
      </div>

      <div class="col bg-success w-100">
        <h6>DERECHA</h6>
        <div style="height: auto; " id="derecha">

        </div>
      </div>
    </div>
  </div>



{% endblock %}