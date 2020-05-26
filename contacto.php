<?php
include 'common/header.php';
?>

<section class="section-main bg padding-y-sm">
<div class="container">
    <h1>Contactenos..</h1>
    <form id="form2" name="form2" method="POST">
    <div class="form-group"> 
	<input type="text" id="rut2" name="rut2" required onchange="return Rut(form2.rut2.value, this.id);" placeholder="Rut" class="form-control">
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
    </div>
    </form>
</div>
</section>


<?php include('common/footer.php'); ?>

