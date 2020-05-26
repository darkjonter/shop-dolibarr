<?php
include 'common/header.php';
// initializ shopping cart class
$cart = new Cart;
?>
<style>


</style>

 <section class="section-main bg padding-y-sm">
     <br><br><br><br>
<div class="container">
    <script>
    function updateCartItem(obj,id){
        $.post("cartAction.php", {action:"updateCartItem", id:id, qty:obj.value}, function(data){
            if(data == 'ok'){
                location.reload();
            }else{
                alert('Cart update failed, please try again.');
            }
        });
    }
    </script>
<div class="container" style="overflow-x:auto;">
    <h1>Tú Carrito de Compras</h1>
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
            <td><input type="number" class="form-control text-center" value="<?php echo $item["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')"></td>
            <td><?php echo ''.formatear_moneda($item["subtotal"]).' '; ?></td>
            <td>
                <a href="cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>" class="btn btn-danger" onclick="return confirm('Estas Seguro?')"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
        <?php } }else{ ?>
        <tr><td colspan="5"><p>Tu carrito esta vacio.....</p></td>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td><a href="https://aseotalca.cl/tienda/" class="btn btn-warning"><i class="fas fa-chevron-left"></i> Continuar Comprando</a></td>
            <td colspan="2"></td>
            <?php if($cart->total_items() > 0){ ?>
            <td class="text-center"><strong>Total <?php echo ''.formatear_moneda($cart->total()).''; ?></strong></td>
            <td><a href="compra.php" class="btn btn-success btn-block">Proceder con la compra <i class="fas fa-chevron-right"></i></a></td> 
            <?php } ?>
        </tr>
    </tfoot>
    </table>
</div>
</div><br><br><br><br><br><br><br>
</section>


<?php include('common/footer.php'); ?>

<!--</body>
</html>-->