<?php
require 'header.php';
?>

<div class="content-wrapper" style="padding: 20px;">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">Consumidores</div>
                <div class="panel-body text-center"><h2 id="total_consumidores">0</h2></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading text-center">Productos</div>
                <div class="panel-body text-center"><h2 id="total_productos">0</h2></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading text-center">Órdenes</div>
                <div class="panel-body text-center"><h2 id="total_ordenes">0</h2></div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-12 text-center">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalConsumidor"><i class="fa fa-user"></i> Nuevo Consumidor</button>
            <button class="btn btn-success" data-toggle="modal" data-target="#modalProducto"><i class="fa fa-cubes"></i> Nuevo Producto</button>
            <button class="btn btn-info" data-toggle="modal" data-target="#modalOrden"><i class="fa fa-shopping-cart"></i> Nueva Orden</button>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <table id="tbllistado" class="table table-striped table-bordered">
<thead>
    <tr>
        <th>Acciones</th>
        <th>N° Orden</th>
        <th>Consumidor</th>
        <th>Total</th>
        <th>Fecha</th>
    </tr>
</thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<?php 
require 'modales.php'; // Aquí cargamos los formularios modales
require 'footer.php'; 
?>
<script type="text/javascript" src="scripts/general.js"></script>