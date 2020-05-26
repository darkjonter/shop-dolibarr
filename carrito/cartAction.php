<?php
// initialize shopping cart class
include 'Cart.php';
include 'include/functions.php';

$cart = new Cart;

// include database configuration file
if(isset($_POST['action']) && !empty($_POST['action'])){
    if($_POST['action'] == 'addToCart' && !empty($_POST['id'])){
        $productID = $_POST['id'];
        $productoCantidad = $_POST['cantidad'];
        // get product details
        $producto = products_detail($productID);
        $itemData = array(
            'id' => $producto['id'],
            'name' => $producto['label'],
            'price' => round($producto['price_ttc']),
            'qty' => $productoCantidad
        );
        
        $insertItem = $cart->insert($itemData);
        $redirectLoc = $insertItem?'viewCart.php':'index.php';
        header("Location: ".$redirectLoc);
    }elseif($_POST['action'] == 'updateCartItem' && !empty($_POST['id'])){
        $itemData = array(
            'rowid' => $_POST['id'],
            'qty' => $_POST['qty']
        );
        $updateItem = $cart->update($itemData);
        echo $updateItem?'ok':'err';die;
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){
        $deleteItem = $cart->remove($_REQUEST['id']);
        header("Location: viewCart.php");
    }/*elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['sessCustomerID'])){
        // insert order details into database
        $insertOrder = $db->query("INSERT INTO orders (customer_id, total_price, created, modified) VALUES ('".$_SESSION['sessCustomerID']."', '".$cart->total()."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')");
        
        if($insertOrder){
            $orderID = $db->insert_id;
            $sql = '';
            // get cart items
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
                $sql .= "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('".$orderID."', '".$item['id']."', '".$item['qty']."');";
            }
            // insert order items into database
            $insertOrderItems = $db->multi_query($sql);
            
            if($insertOrderItems){
                $cart->destroy();
                header("Location: orderSuccess.php?id=$orderID");
            }else{
                header("Location: checkout.php");
            }
        }else{
            header("Location: checkout.php");
        }
    }*/else{
        header("Location: https://aseotalca.cl/tienda/");
    }
}else{
    header("Location: https://aseotalca.cl/tienda/");
}