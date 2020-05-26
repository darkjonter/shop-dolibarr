<?php
include 'common/header.php';
// initializ shopping cart class
?>
<section class="section-main bg padding-y-sm">
<div class="container">
<div id="detalle_comprador">
    <h1>Crear Cliente</h1>
    <form id="form1" name="form1" action="cliente.php" method="POST">
    <div class="form-group"> 
	<input type="text" id="rut" name="rut" required onchange="return Rut(form1.rut.value);" placeholder="Rut" class="form-control">
    </div> 
    <div class="form-group">
	<input type="text" name="nombre" id="name" placeholder="Nombre" required class="form-control">
    </div>
    <div class="form-group">
    <input type="email" name="email" placeholder="Mail" id="email" class="form-control" required>
    </div>
    <div class="form-group">
    <input type="text" name="direccion" id="direccion" placeholder="Direcci贸n Facturacion"  required class="form-control">
    </div>
    <div class="form-group">
    <input type="tel" name="telefono" id="telefono" placeholder="Tel茅fono" required class="form-control">
    </div>
     <input type="hidden" name="action" value="crear_cliente">
    <div>
        <button type="submit">CREAR CLIENTE </button>
    </div>
</form>

</div>
</div>
</section>


<?php include('common/footer.php'); ?>