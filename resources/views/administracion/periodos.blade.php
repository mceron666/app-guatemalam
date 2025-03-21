@extends("layouts.header")

@section("contenido")
<!-- Imagen -->
<div id="header-periodos" class="mb-4" style="position: relative; width: 100%; height: 200px; overflow: hidden;">
    <img src="/images/ruinas.jpg" alt="Header" style="width: 100%; height: 200px; object-fit: cover;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 60%, white 100%);"></div>
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 34px; font-weight: bold; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);"> 
        Períodos Escolares
    </div>
</div>
<!-- Tabla -->
<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="input-group w-50">
                    <input type="text" class="form-control" placeholder="Buscar Período">
                    <button class="btn btn-success">
                         Buscar <i class="bi bi-search"></i>
                    </button>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#periodoModal">
                    Agregar <i class="bi bi-plus-circle"></i> 
                </button>
            </div>
            <div class="table-responsive">
                <table id="tablaPeriodos" class="table table-bordered">
                    <thead>
                        <tr class="table-header">
                            <th>Código Período</th>
                            <th>Descripción</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha Finaliza</th>
                            <th>Estado Período</th>
                            <th>Perfil de ingreso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2024 - 2025</td>
                            <td>Período Escolar 2024 a 2025</td>
                            <td>2024-01-01</td>
                            <td>2024-06-30</td>
                            <td>Activo</td>
                            <td>Administrador</td>
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
                        </tr>
                        <!-- Más filas pueden ir aquí -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="periodoModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Ingresar Período Escolar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="periodoForm">
            <div class="mb-3">
              <label for="codigoPeriodo" class="form-label">Código del Período</label>
              <input type="text" class="form-control" id="codigoPeriodo" name="CODIGO_PERIODO" required>
            </div>
            <div class="mb-3">
              <label for="descripcionPeriodo" class="form-label">Descripción del Período</label>
              <input type="text" class="form-control" id="descripcionPeriodo" name="DESCRIPCION_PERIODO" required>
            </div>
            <div class="mb-3">
              <label for="fechaInicioPeriodo" class="form-label">Fecha de Inicio</label>
              <input type="date" class="form-control" id="fechaInicioPeriodo" name="FECHA_INICIO_PERIODO" required>
            </div>
            <div class="mb-3">
              <label for="fechaFinalizaPeriodo" class="form-label">Fecha de Finalización</label>
              <input type="date" class="form-control" id="fechaFinalizaPeriodo" name="FECHA_FINALIZA_PERIODO" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" form="periodoForm">Guardar</button>
        </div>
      </div>
    </div>
  </div>



@endsection
