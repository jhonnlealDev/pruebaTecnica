<div class="modal fade" id="modalConsumidor" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formConsumidor">
                <div class="modal-header"><h4 class="modal-title">Registrar Consumidor</h4></div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id_consumidor">
                    <div class="form-group"><label>Nombre:</label><input type="text" name="nombre" class="form-control" required></div>
                    <div class="form-group"><label>Email:</label><input type="email" name="email" class="form-control" required></div>
                    <div class="form-group"><label>Teléfono:</label><input type="text" name="telefono" class="form-control"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProducto" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formProducto">
                <div class="modal-header"><h4 class="modal-title">Registrar Producto</h4></div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id_producto">
                    <div class="form-group"><label>Descripción:</label><input type="text" name="descripcion" class="form-control" required></div>
                    <div class="form-group"><label>Precio:</label><input type="number" step="0.01" name="precio" class="form-control" required></div>
                    <div class="form-group"><label>Stock:</label><input type="number" name="stock" class="form-control" required></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalOrden" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg"> <div class="modal-content">
            <form id="formOrden">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Nueva Orden</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Consumidor:</label>
                        <select name="consumidor_id" id="consumidor_id" class="form-control" required>
                            </select>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-8">
                            <label>Producto:</label>
                            <select id="producto_selector" class="form-control">
                                </select>
                        </div>
                        <div class="form-group col-md-4">
                            <button type="button" class="btn btn-success" onclick="agregarProducto()" style="margin-top: 25px;">
                                <i class="fa fa-plus"></i> Agregar
                            </button>
                        </div>
                    </div>

                    <table class="table table-bordered" id="tablaDetalles">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="detalles">
                            </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">TOTAL:</th>
                                <th><h4 id="total">$ 0.00</h4><input type="hidden" name="total" id="total_venta"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Guardar Orden</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>