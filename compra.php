<?php
include 'common/header.php';
// initializ shopping cart class
$cart = new Cart;
?>
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Float four columns side by side */
.column {
  float: left;
  width: 50%;
  padding: 0 10px;
}

/* Remove extra left and right margins, due to padding */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #f1f1f1;
}


</style>

<section class="section-main bg padding-y-sm">
<div class="container">
    <h1 align="center">Compra en comercio Aseo Talca</h1><br>
    <div class="row">
  <div class="column">
    <div class="card" style="overflow-x:auto;">
       <h3 align="left">Detalle de la Compra</h3>
    <table class="table">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th> </th>
        </tr>
    </thead>
    <tbody>
        <?php
        if($cart->total_items() > 0){
            //get cart items from session
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
        ?>
        <tr>
            <td><?php echo $item["name"]; ?></td>
            <td><?php echo ''.formatear_moneda($item["price"]).' '; ?></td>
            <td><?php echo $item["qty"]; ?></td>
            <td><?php echo ''.formatear_moneda($item["subtotal"]).' '; ?></td>
        </tr>
        <?php } }else{ ?>
        <tr><td colspan="5"><p>Tu carrito esta vacio.....</p></td>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <?php if($cart->total_items() > 0){ ?>
            <td class="text-center"><strong>Total <?php echo ''.formatear_moneda($cart->total()).''; ?></strong></td>
            
            <?php } ?>
        </tr>
    </tfoot>
    </table>
    </div>
  </div>

  <div class="column">
    <div class="card">
       <form id="form1" name="form1" action="webpay.php" method="POST">
    <h3 align="left">Ingrese su RUT si ya es cliente</h3>
    <div id="div-alert"></div>
    <div class="form-group"> 
	<input type="text" id="rut" name="rut" required onchange="return Rut(form1.rut.value, this.id);" placeholder="Rut" class="form-control">
	<!-- <button type="button" id="comprobar_rut">Comprobar RUT</button> -->
	 
    </div> 
    <input type="hidden" id="id_cliente" name="id_cliente">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" align="left">
        Crear cliente
        </button>
    <div>
       
    </div>
    

    </div>
  </div>
  
</div>
<br><br>
   <button type="submit" id="pagar-button" class="btn btn-success btn-block" disabled>Pagar <i class="fas fa-chevron-right"></i></button>
   </form>

</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo cliente </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="alerta_modal"></div>
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
    <input type="text" name="direccion" id="direccion" placeholder="Dirección Facturacion"  required class="form-control">
    </div>
    <div class="form-group">
    <input type="tel" name="telefono" id="telefono" placeholder="Teléfono" required class="form-control">
    </div>
     <input type="hidden" name="action" value="crear_cliente">
    <div>
    </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="crear_cliente">Crear cliente </button>
      </div>
    </div>
  </div>
</div>
<br><br>
</section>

<script>
    
    $( "#crear_cliente" ).click(function() {
        var alerta = "<div class='alert alert-warning' role='alert'>";
        var action = 'crear_cliente';
        var rut = $('#rut2').val();
        var name = $('#name').val();
        var email = $('#email').val();
        var address = $('#direccion').val();
        var phone = $('#telefono').val();
        var count= 0;
        
        if(rut!=''){
            count++;
        }else{
            alerta+='Se requiere RUT <br/>';
        }
        if(name!=''){
            count++;
        }else{
            alerta+='Se requiere Nombre <br/>';
        }
        if(email!=''){
            count++;
        }else{
            alerta+='Se requiere Email <br/>';
        }
        if(address!=''){
            count++;
        }else{
            alerta+='Se requiere Dirección <br/>';
        }
        if(phone!=''){
            count++;
        }else{
            alerta+='Se requiere Télefono <br/>';
        }
        
        if(count>=5){
             $.ajax({
                type  : 'ajax',
                method : 'POST',
                url   : 'cliente.php',
                data : { rut : rut, action : action, name:name, email:email, address:address, phone:phone },
                async : false,
                dataType : 'json',
                success : function(data){
                    if(data.id_cliente){
                        $('#id_cliente').val(data.id_cliente);
                        $('#rut').val(rut);
                        $('#exampleModal').modal('hide');
                        alerta+='Usuario registrado correctamente. </div>';
                        $( "#div-alert" ).html(alerta);
                    }else{
                        $('#exampleModal').modal('hide');
                        $('#rut').val(rut);
                        alerta+='ESTE CLIENTE YA SE ENCUENTRA REGISTRADO. </div>';
                        $( "#div-alert" ).html(alerta);
                        
                    }
                }

            });
        }
        else{
            alerta+='</div>';
            $( "#alerta_modal" ).html(alerta);
        }
       
    });
</script>


<?php include('common/footer.php'); ?>