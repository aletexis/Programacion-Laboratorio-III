{% extends 'principal.html' %}

{% block content %}

<div class="container">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul id="main-nav" class="navbar-nav ms-5">
                <div class="d-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="color: dodgerblue">
                            Listados
                        </a>
                        <div class="dropdown-menu">
                            <p class="dropdown-item" id="usuarios">Usuarios</p>
                            <p class="dropdown-item" id="perfiles">Perfiles</p>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="altaPerfiles" style="color: dodgerblue">
                            Alta Perfiles
                        </a>
                    </li>
                </div>
            </ul>
        </div>
    </nav>

    <div style="margin-top: 100px;">
    <!-- alert start -->
    <div class="alert alert-danger d-none" role="alert" >
            <p class="flex-fill"></p>
            <i class="fas fa-times close" style="cursor: pointer"></i>
        </div>
    <!-- alert end -->
        <div class="row" style="height: 80vh;">
            <div class="col-6 bg-danger" id="izquierda">
                <h4>IZQUIERDA</h4>
            </div>
            <div class="col-6 bg-success" id="derecha">
                <h4>DERECHA</h4>
            </div>
        </div>
    </div>


</div>

{% endblock %}