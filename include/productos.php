<?php

include ('callAPI.php');

// Retrieve products list
	$listProduits = [];
	$produitParam = ["limit" => 10000, "sortfield" => "rowid"];
	$listProduitsResult = CallAPI("GET", $apiKey, $apiUrl."products", $produitParam);
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
	
/*echo "<pre>";
print_r($listProduits);
echo "</pre>";
*/
$productos = array_values($produits);

print_r($productos);
?>