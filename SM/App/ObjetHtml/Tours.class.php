<?php 
 namespace App\ObjetHtml;

 use App\Model\Produit;

/**
 * 
 */
class Tours
{
	
	function __construct()
	{
		# code...
	}

		public function button($url,$name)
	{
		# code...
		echo "<section class='container-fluid' style= 'height:auto'>";
	 		echo "<article class='row justify-content-center' style='margin-top: 90px'>";
	 			echo "<div class='col-12 col-sm-6 col-md-6'>";
		
					echo "<a href = '$url' type='button' class='btn btn-outline-success btn-lg btn-block'>".$name."</a>";

				echo "</div>";
			echo "</article>";
		echo "</section>";



					 
	}

	public static function get_content($list_Produit){
		echo "<form action='index.php?page=traitement_vente' method= 'post' style = 'margin-top: 30px; margin-left: 30px;' >";
			echo "<div class='row'>";
			 	$list_filtres = Tours::filter($list_Produit);
			 	Tours::onglet($list_filtres['listProduit']);
			 	Tours::allContenuOngle($list_filtres);
		 	echo "</div>";
		 	echo "<div class = 'row'>";
		 	echo "<div class = 'offset-3 col-6' style='padding-right: 0px;'>";
		 	echo "<input type='number' name='remise' class = 'form-control remise' placeholder = 'remise en FCFA'>";
		 	echo "</div>";
		 	echo "<div class = 'col-3' style='padding-left : 0px; border-left:0px;'>";
		 	echo "<input type='submit' value='Valider' min='0'  class = 'btn btn-info valide' style = 'width:70%;' />";
		 	echo "</div>";
		 	echo "</div>";
		 echo "</form>";
	 	
	 }

	 public static function filter($list_Produit){
	 	$list_filtres=[];
	 	foreach ($list_Produit as $produit) {
	 		$list_filtres[$produit->getMarque()][$produit->getkeys()] = $produit;
	 		$list_quantite[$produit->getKey()] = $produit->getQuantite();
	 	}
	 	return ['listProduit'=>$list_filtres,'quantite'=>$list_quantite];
	 }

	 public static function checkRadio($value,$name){
	 	$check = $value=="original"? "checked":"";
	 	echo "<div class='form-check form-check-inline'>";
		  echo "<input class='form-check-input' type='radio' name='choix_$name' id='$value"."_$name' value='$value' $check>";
		  echo "<label class='form-check-label' for='$value"."_$name'>".$value."</label>";
		echo "</div>";
	 }
	 public static function number($name,$placeholder,$max=0){
	 	$desable = $max>0 ?'' : 'disabled';
	 	echo "<div class='col-sm-7'>";
	 		echo "<input name = '$name' type='number' class='form-control' id='number' placeholder='$placeholder' $desable max ='$max'>";
		echo "</div>"; }
	 public static function grille($model,$quantites){
	 
	 	echo "<div class='col border p-4 bg-light text-center'>"
	 	.$model->getType()." : ".$model->getMarque()." ".$model->getModel()."<br/>";
	 		echo "<div class='form-check form-check-inline'>";

	 			$q1 = isset($quantites[$model->getKeys().'_Original'])?
	 			$quantites[$model->getKeys().'_Original']:0;
	 			$q2 = isset($quantites[$model->getKeys().'_Copie'])? 
	 			$quantites[$model->getKeys().'_Copie'] : 0;

		 		Tours::number($model->getKey(),'Original('.$q1.')',$q1);
		 		Tours::number($model->getKey(),'Copie('.$q2.')',$q2);
			echo "</div>";
		echo "</div>";
	 	
	 }

	 public static function contenuOglet($marque,$list_model,$active,$quantites){
	 	$activer = $active? "active" : "";
	 	echo "<div class='tab-pane fade show $activer' id='v-pills-$marque' role='tabpanel' aria-labelledby='v-pills-$marque-tab' >";
	 				Tours::get_row($list_model,$quantites);
	 	echo "</div>";
	 }

	  public static function allContenuOngle($list_Produit){
		echo "<div class='col-9'>";
			echo "<div class='tab-content' id='v-pills-tabContent'>";
			$active = true;
			  	foreach ($list_Produit['listProduit'] as $key => $value) {
			  		Tours::contenuOglet($key,$value,$active,$list_Produit['quantite']);
			  		$active = false;
			  	}
			echo "</div>";
		echo "</div>"; 
	  }

	  public static function get_row($list_model,$quantites)
	  {
	  	$i = 0;
	  	$size = count($list_model);
	 	foreach ($list_model as $value) {
	 		if ($i%3 == 0) {
	 			echo "<div class='container mx-md-n5'>";
 					echo "<div class='row row-cols-3 px-md-5'>";

	 		}
	 		Tours::grille($value, $quantites);
	 		$i++;
	 		if ($i%3 == 0 || $i == $size) {
	 				echo "</div>";
				echo "</div>"; 
	 		}	
 		}
	  }

	 


//////////////////////////////////////////////////////////////////////////
	  public static function link($marque,$active){
	  	$activer = $active? "active" : "";
	  	echo "<a class='nav-link $activer' id='v-pills-$marque-tab' data-toggle='pill' href='#v-pills-$marque' role='tab' aria-controls='v-pills-$marque' aria-selected='true'>$marque</a>";
	  }

	  public static function onglet($list_Produit){
	  	echo "<div class='col-3'>";
		  	echo " <div class='nav flex-column nav-pills' id='v-pills-tab' role='tablist' aria-orientation='vertical'>";
		  	$active = true;
		  		foreach ($list_Produit as $key => $value) {
		  			Tours::link($key,$active);
		  			$active = false;
		  		}
		  	echo "</div>";
		echo "</div>";
	  }
	  
	public static function str_array($sep, $value){
		$val="";
		$values = [];
		$size =  strlen($value);
		for ($i=0; $i <$size; $i++) { 
			if ($value[$i]== $sep && $val!=""){
				$values[] = $val;
				$val = "";
			}else if($value[$i]!= $sep)
				$val= $val.$value[$i];
		}
		$values[] = $val;
		return $values;
	} 

}



 ?>