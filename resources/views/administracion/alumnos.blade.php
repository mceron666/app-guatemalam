@extends("layouts.header")

@section("contenido")
<div id="header-alumnos" style="position: relative; width: 100%; height: 200px; overflow: hidden;">
    <img src="/images/ruinas.jpg" alt="Header" style="width: 100%; height: 200px; object-fit: cover;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 60%, white 100%);"></div>
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 34px; font-weight: bold; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);"> 
    Alumnos </div>
</div>
<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="input-group w-50">
                    <input type="text" class="form-control" placeholder="Buscar Usuario">
                    <button class="btn btn-success">
                        Buscar <i class="bi bi-search"></i>
                    </button>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#usuarioModal">
                    Agregar <i class="bi bi-plus-circle"></i> 
                </button>
            </div>
            <div class="table-responsive">
                <table id="tablaUsuarios" class="table table-bordered">
                    <thead>
                        <tr class="table-header">
                            <th>ID</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Perfil</th>
                            <th>Correo</th>
                            <th>Sexo</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se llenarán los datos dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchUsuarios();
    });

    function fetchUsuarios() {
        fetch('/api/usuarios')
            .then(response => response.json())
            .then(data => {
                console.log("Datos recibidos:", data);

                let tbody = document.querySelector("#tablaUsuarios tbody");
                if (!tbody) return;

                tbody.innerHTML = ""; // Limpiar antes de agregar nuevos datos

                data.forEach(usuario => {
                    let row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${usuario.idPersona}</td>
                        <td>${usuario.nombres}</td>
                        <td>${usuario.apellidos}</td>
                        <td>${usuario.perfil}</td>
                        <td>${usuario.correo}</td>
                        <td>${usuario.sexo}</td>
                        <td>${usuario.rol}</td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center">
                                <button class="btn btn-warning btn-sm me-2">
                                    <i class="bi bi-pencil-square"></i> Modificar
                                </button>
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            })
            .catch(error => console.error("Error al obtener usuarios:", error));
    }
</script>


@endsection

