<?php
	namespace  App\Model;
	/**
	 * represente un magasins
	 */
	class Magasin extends Stock
	{

		function __construct()
		{
			$this->setListProduit((new Produit())->allProduitMagasin());	
		}

		public function affiche(){
			$this->body('magasin',"Depot","Retrait");
		}

	}
?>