<div class="modal fade custom-modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header text-white" style="background-color: #dc3545; border-bottom: 2px solid #bb2d3b;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.5rem;"></i>
                    <h4 class="modal-title mb-0" id="deleteModalLabel">Confirmar Eliminación</h4>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="errorMessageContainerdel" class="alert alert-danger mx-4 mt-3 mb-0 d-none">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <span id="errorMessagedel">Mensaje de error aquí</span>
                </div>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="bi bi-trash3 text-danger" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <h5 class="text-danger mb-2">¿Está seguro que desea eliminar este registro?</h5>
                    <p class="text-muted mb-0">Esta acción no se puede deshacer</p>
                </div>
                <div class="card border-danger border-2">
                    <div class="card-header bg-danger bg-opacity-10 border-bottom border-danger">
                        <h6 class="mb-0 text-danger">
                            <i class="bi bi-calendar-x me-2"></i>Información de registro
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-2">
                            <div class="col-4">
                                <strong class="text-muted">
                                    Código:
                                </strong>
                            </div>
                            <div class="col-8">
                                <span id="CodigoEliminar" class="fw-bold text-dark">-</span>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-4">
                                <strong class="text-muted">
                                    Descripción:
                                </strong>
                            </div>
                            <div class="col-8">
                                <span id="DescripcionEliminar" class="fw-bold text-dark">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning border-warning mt-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                        <small class="mb-0">
                            <strong>Advertencia:</strong> No se podrá revertir si elimina este registro
                        </small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-danger btn-lg px-4" id="btnConfirmDelete">
                    <i class="bi bi-trash3 me-2"></i>Eliminar
                </button>
            </div>
        </div>
    </div>
</div>