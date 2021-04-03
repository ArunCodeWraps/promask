<?php

class wfCart {
	var $total = 0;
	var $itemcount = 0;
	var $items = array();
	var $itemProdId = array();
	var $itemPrice = array();
	var $itemQnt = array();
	var $itemName = array();
	var $itemImage = array();
	var $itemSize = array();
	var $itemPriceId = array();

	function cart() {} // constructor function

	function get_contents()
	{ // gets cart contents
		$items = array();
		foreach($this->items as $tmp_item)
		{
		    $item = FALSE;

			$item['id'] = $tmp_item;
			$item['prodId'] = $this->itemProdId[$tmp_item];
            $item['qty'] = $this->itemQnt[$tmp_item];
			$item['price'] = $this->itemPrice[$tmp_item];
			$item['name'] = $this->itemName[$tmp_item];
			$item['image'] = $this->itemImage[$tmp_item];
			$item['size'] = $this->itemSize[$tmp_item];
			$item['prodPriceId'] = $this->itemPriceId[$tmp_item];
			$item['subtotal'] = $item['qty'] * $item['price'];
            $items[] = $item;
		}
		return $items;
	} // end of get_contents



function add_item($prodId,$prodPrice,$qty,$prodName,$prodImage,$prodSize,$prodPriceId,$max_qty= FALSE)
{ 
    //$this->empty_cart();
    if(!$prodPrice)
	{
	    $prodPrice = wf_get_price($prodId,$qty);
	}

    if($this->itemQnt[$prodId] > 0)
    { 
        $this->itemQnt[$prodId] = $qty + $this->itemQnt[$prodId];   	
		
	} else {
		$this->items[]=$prodId;
		$this->itemProdId[$prodId] = $prodId;
		$this->itemQnt[$prodId] = $qty;
		$this->itemPrice[$prodId] = $prodPrice;
		$this->itemName[$prodId] = $prodName;
		$this->itemImage[$prodId] = $prodImage;
		$this->itemSize[$prodId] = $prodSize;
		$this->itemPriceId[$prodId] = $prodPriceId;
	}
	$this->_update_total();
} 





	function edit_item($prodId,$qty,$price)
	{ // changes an items quantity
		echo $price;
		if($qty < 1) {
			$this->del_item($prodId);
		} else {
			$this->itemQnt[$prodId] = $qty;
			$this->itemPrice[$prodId] = $price;
			// uncomment this line if using 
			// the wf_get_price function
			// $this->itemprices[$itemid] = wf_get_price($itemid,$qty);
		}
		$this->_update_total();
	} // end of edit_item

	
	// removes an item from cart
	function del_item($prodId)
	{ 
		$ti = array();
		$this->itemQnt[$prodId] = 0;
		foreach($this->items as $item)
		{
			if($item != $prodId)
			{
				$ti[] = $item;
			}
		}
		$this->items = $ti;
		$this->_update_total();
	}



	// empties / resets the cart
    function empty_cart()
	{ 
            $this->total = 0;
	        $this->itemcount = 0;
	        $this->items = array();
            $this->itemProdId = array();
            $this->itemPrice = array();
	        $this->itemQnt = array();
            $this->itemName = array();
            $this->itemImage = array();
	} 


	function _update_total()
	{ // internal function to update the total in the cart
	    $this->itemcount = 0;
		$this->total = 0;
                if(sizeof($this->items > 0))
		{
                        foreach($this->items as $item) {
                                $this->total = $this->total + ($this->itemPrice[$item] * $this->itemQnt[$item]);
				$this->itemcount++;
			}
		}
	} // end of update_total

}
?>
