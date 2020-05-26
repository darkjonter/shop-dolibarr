<?php

include ('callAPI.php');

// Retrieve Categories list
	$listCategories = [];
	$categorieParam = ["limit" => 10000, "sortfield" => "rowid", "type" => "product"];
	$listCategoriesResult = CallAPI("GET", $apiKey, $apiUrl."categories", $categorieParam);
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

$categorias = array_values($listCategories);

print_r($categorias);




?>