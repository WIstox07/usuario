
    <!-- Modal -->
    <div class="modal fade" id="detalle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="detalle_titulo"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3"  id="prueba" novalidate" autocomplete="off">
                    <input type="hidden" name="detalle_idusuario">

                    <div class="col-12">
                        <label for="detalle_usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" name="detalle_usuario" required >
                        <div class="invalid-feedback">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="detalle_contraseña" class="form-label">Contraseña</label>
                        <input type="text" class="form-control" name="detalle_contraseña" required>
                        <div class="invalid-feedback">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="detalle_correo" class="form-label">Correo</label>
                        <input type="text" class="form-control" name="detalle_correo" required>
                        <div class="invalid-feedback">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="detalle_perfil" class="form-label">Perfil</label>
                        <select class="form-select" name="detalle_perfil">
                           
                            <?php foreach ($perfil->listar_perfil() as $row) { ?>
                                <option value="<?=$row["idPerfil"] ?>"><?=$row["nombre"]?> </option>
                            <?php }?>
                        </select>
                        <div class="invalid-feedback">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" id="detalle_accion">Guardar</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
    </div>
