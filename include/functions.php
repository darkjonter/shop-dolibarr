<?php 
include ('callAPI.php');

// LISTA DE CATEGORIAS
function categories_list(){
    global $apiKey;
    global  $apiUrl;
     // Retrieve Categories list
	$listCategories = [];
	$categorieParam = ["limit" => 10000, "sortfield" => "rowid", "type" => "product"];
	$listCategoriesResult = callAPI("GET", $apiKey, $apiUrl."categories", $categorieParam);
	$listCategoriesResult = json_decode($listCategoriesResult, true);

	if (isset($listCategoriesResult["error"]) && $listCategoriesResult["error"]["code"] >= "300") {
	} else {
		foreach ($listCategoriesResult as $categorie) {
			$listCategories[intval($categorie["id"])] = html_entity_decode($categorie["label"], ENT_QUOTES);
			/*echo "<pre>";
                print_r($produit);
            echo "</pre>";*/
		}
	}

    return $listCategories;

    
}

//LISTA DE PRODUCTOS

function products_list(){
    global $apiKey;
    global  $apiUrl;
    // Retrieve products list
	$listProduits = [];
	$produitParam = ["limit" => 10000, "sortfield" => "rowid"];
	$listProduitsResult = callAPI("GET", $apiKey, $apiUrl."products", $produitParam);
	$listProduitsResult = json_decode($listProduitsResult, true);

	if (isset($listProduitsResult["error"]) && $listProduitsResult["error"]["code"] >= "300") {
	} else {
		foreach ($listProduitsResult as $produit) {
			$listProduits[intval($produit["id"])] = html_entity_decode($produit["ref"], ENT_QUOTES);
			/*echo "<pre>";
                print_r($produit);
            echo "</pre>";*/
            $produits[]=$produit;
		}
	}

    return $produits;
}



//CATEGORIAS POR ID
function products_by_category($c_id){
    global $apiKey;
    global  $apiUrl;
    // Retrieve products list
	$listProduits = [];
	$produitParam = ["limit" => 10000, "sortfield" => "rowid", "category" => $c_id];
	$listProduitsResult = callAPI("GET", $apiKey, $apiUrl."products", $produitParam);
	$listProduitsResult = json_decode($listProduitsResult, true);
/*
	if (isset($listProduitsResult["error"]) && $listProduitsResult["error"]["code"] >= "300") {
	} else {
		foreach ($listProduitsResult as $produit) {
			$listProduits[intval($produit["id"])] = html_entity_decode($produit["ref"], ENT_QUOTES);
            $produits[]=$produit;
		}
	}
*/	

return $listProduitsResult;

}

function products_detail($p_id){
     global $apiKey;
    global  $apiUrl;
    // Retrieve products list
	$listProduits = [];
	$produitParam = ["limit" => 10000, "sortfield" => "rowid"];
	$listProduitsResult = CallAPI("GET", $apiKey, $apiUrl."products/".$p_id, $produitParam);
	$listProduitsResult = json_decode($listProduitsResult, true);
/*
	if (isset($listProduitsResult["error"]) && $listProduitsResult["error"]["code"] >= "300") {
	} else {
		foreach ($listProduitsResult as $produit) {
			$listProduits[intval($produit["id"])] = html_entity_decode($produit["ref"], ENT_QUOTES);
            $produits[]=$produit;
		}
	}
*/	

return $listProduitsResult;

}

function imagen_principal($p_id){
  global $apiKey;
    global  $apiUrl;
    // Retrieve products list
	$listProduits = [];
	$produitParam = ["modulepart" => "product","limit" => 1, "id" => $p_id];
	$listProduitsResult = CallAPI("GET", $apiKey, $apiUrl."documents", $produitParam);
	$listProduitsResult = json_decode($listProduitsResult, true);
/*
	if (isset($listProduitsResult["error"]) && $listProduitsResult["error"]["code"] >= "300") {
	} else {
		foreach ($listProduitsResult as $produit) {
			$listProduits[intval($produit["id"])] = html_entity_decode($produit["ref"], ENT_QUOTES);
            $produits[]=$produit;
		}
	}
*/	

return $listProduitsResult;
}

function images_list($p_id){
  global $apiKey;
    global  $apiUrl;
    // Retrieve products list
	$listProduits = [];
	$produitParam = ["modulepart" => "product","limit" => 10000, "id" => $p_id];
	$listProduitsResult = CallAPI("GET", $apiKey, $apiUrl."documents", $produitParam);
	$listProduitsResult = json_decode($listProduitsResult, true);
/*
	if (isset($listProduitsResult["error"]) && $listProduitsResult["error"]["code"] >= "300") {
	} else {
		foreach ($listProduitsResult as $produit) {
			$listProduits[intval($produit["id"])] = html_entity_decode($produit["ref"], ENT_QUOTES);
            $produits[]=$produit;
		}
	}
*/	

return $listProduitsResult;
}


//buscar orden por id

function get_order($id){
    global $apiKey;
    global  $apiUrl;
    // Retrieve products list
	$listOrder = [];
	$orderParam = ["contact_list" => 1];
	$listOrderResult = callAPI("GET", $apiKey, $apiUrl."orders/".$id, $orderParam);
	$listOrderResult = json_decode($listOrderResult, true);

	if (isset($listOrderResult["error"]) && $listOrderResult["error"]["code"] >= "300") {
	} else {
		foreach ($listOrderResult as $order => $value) {
			$orders[$order] = $value;
			//$listOrder[intval($order["id"])] = html_entity_decode($order["ref"], ENT_QUOTES);
			/*echo "<pre>";
                print_r($produit);
            echo "</pre>";*/
            
		}
	}

    return $orders;
}

//guardar orden
function save_order($cliente_id){
    
     global $apiKey;
    global  $apiUrl;
    include 'Cart.php';
    $cart = new Cart;
     // create an order with 2 products

// The array where there will be all the products lines of my order.

    $newCommandeLine = [];
    if($cart->total_items() > 0){
            //get cart items from session
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
            $newCommandeLine[] = [
		        "desc"		=> $item['ref'],
		        "subprice"	=> $item['subprice'],
		        "qty"		=> $item['qty'],
		        "tva_tx"	=> floatval(19),
		        "fk_product"=> $item['id']
	            ];
            }
        if (count($newCommandeLine) > 0) {
		$newCommande = [
			"socid"			=> $cliente_id,
			"type" 			=> "0",
			"date" => time(),
			"date_command" =>time(),
			"lines"			=> $newCommandeLine,
			"note_private"	=> "orden creada pero no validada",
		];
		
		
		$newCommandeResult = CallAPI("POST", $apiKey, $apiUrl."orders", json_encode($newCommande));
		$newCommandeResult = json_decode($newCommandeResult, true);
		return $newCommandeResult;
	}
    }else{
     echo 'carrito vacio';   
    } 
}


//validarla
function validate_order($newCommandeResult){
    global $apiKey;
    global  $apiUrl;
    // Validate an order 
	$newCommandeValider = [
		"idwarehouse"	=> "0",
		"notrigger"		=> "0"
	];
	$newCommandeValiderResult = CallAPI("POST", $apiKey, $apiUrl."orders/".$newCommandeResult."/validate", json_encode($newCommandeValider));
	$newCommandeValiderResult = json_decode($newCommandeValiderResult, true);
	return $newCommandeValiderResult;
}


//buscar cliente
function search_customer($rut){
    global $apiKey;
    global  $apiUrl;
    // search in the database if a customer exist
	$clientSearch = json_decode(CallAPI("GET", $apiKey, $apiUrl."thirdparties", array(
		"sortfield" => "t.rowid", 
		"sortorder" => "ASC", 
		"limit" => "1", 
		"mode" => "1",
		"sqlfilters" => "(t.siren:=:'".$rut."')"
		)
	), true);
	
	return $clientSearch;
}
//buscarcliente por id
function search_customer_id($id){
    global $apiKey;
    global  $apiUrl;
    // search in the database if a customer exist
	$clientSearch = json_decode(CallAPI("GET", $apiKey, $apiUrl."thirdparties", array(
		"sortfield" => "t.rowid", 
		"sortorder" => "ASC", 
		"limit" => "1", 
		"mode" => "1",
		"sqlfilters" => "(t.rowid:=:'".$id."')"
		)
	), true);
	if($clientSearch[0]){
	   return $clientSearch[0];
	}
	else{
	    return $clientSearch;
	}
}

//crear cliente
function create_customer($name, $address, $phone, $rut, $email){
    global $apiKey;
    global  $apiUrl;
    // customer doesn't exist. Let's create it and get it's ID
	$newClient = [
		"name" 			=> $name,
		"email"			=> $email,
		"client" 		=> "1",
		"idprof1" => $rut,
		"address" => $address,
		"phone" => $phone,
		"code_client"	=> "-1"
	];
	$newClientResult = CallAPI("POST", $apiKey, $apiUrl."thirdparties", json_encode($newClient));
	$newClientResult = json_decode($newClientResult, true);
	$clientDoliId = $newClientResult;
	return $clientDoliId;
}

function order_mail($email_usuario, $email_admin){
    
}


function formatear_moneda($moneda){
		return '$'.number_format($moneda, 0, ',', '.');
}


function cortar_string ($string, $largo) { 
   $marca = "<!--corte-->"; 
 
   if (strlen($string) > $largo) { 
        
       $string = wordwrap($string, $largo, $marca); 
       $string = explode($marca, $string); 
       $string = $string[0]; 
   } 
   return $string; 
 
} 
?>