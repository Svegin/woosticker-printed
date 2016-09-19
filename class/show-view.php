<?php
class wooStickerView {
	public function __construct() {		
		if (ENABLE_STICKER == "yes") {
			if (ENABLE_NEW_PRODUCT == "yes") {
				if (ENABLE_STICKER_LISTING == "yes") {
					remove_action ( 'woocommerce_before_shop_loop_item_title', array (
							$this,
							'wli_woocommerce_show_product_loop_new_badge' 
					), 30 );
					add_action ( 'woocommerce_before_shop_loop_item_title', array (
							$this,
							'wli_woocommerce_show_product_loop_new_badge' 
					), 30 );
				}
				if (ENABLE_STICKER_DETAIL == "yes") {
					remove_action ( 'woocommerce_single_product_summary', array (
							$this,
							'wli_woocommerce_show_product_loop_new_badge' 
					), 30 );
					add_action ( 'woocommerce_before_single_product_summary', array (
							$this,
							'wli_woocommerce_show_product_loop_new_badge' 
					), 30 );
				}
			}		
			if (ENABLE_SALE_PRODUCT == "yes") {
				if (ENABLE_STICKER_LISTING == "yes") {
					add_filter ( 'woocommerce_sale_flash', array (
							$this,
							'wli_woocommerce_show_product_loop_sale_badge' 
					), 11, 3 );										
				} else {
					add_filter ( 'woocommerce_sale_flash', array (
							$this,
							'wli_woocommerce_show_product_loop_sale_badge_remove' 
					), 11, 3 );
				}
				if (ENABLE_STICKER_DETAIL == "yes") {
					remove_action ( 'woocommerce_before_single_product_summary', array (
							$this,
							'wli_woocommerce_show_product_loop_sale_badge' 
					), 30 );
					add_filter ( 'woocommerce_before_single_product_summary', array (
							$this,
							'wli_woocommerce_show_product_loop_sale_badge' 
					), 11, 3 );
				} else {
					add_filter ( 'woocommerce_before_single_product_summary', array (
							$this,
							'wli_woocommerce_show_product_loop_sale_badge_remove' 
					), 11, 3 );
				}
			} else {
				add_filter ( 'woocommerce_sale_flash', array (
						$this,
						'wli_woocommerce_show_product_loop_sale_badge_remove' 
				), 11, 3 );
			}
			/**
			 * Filter added for resolving bug of sold product
			 * not display.
			 * v 1.0.4 jenilk
			 * */
			if(ENABLE_SOLD_PRODUCT == "yes")
			{				
				if (ENABLE_STICKER_LISTING == "yes") {											
					add_filter ( 'woocommerce_before_shop_loop_item_title', array (
					 $this,
					 'wli_woocommerce_show_product_loop_soldout_badge'
					), 11, 3 );
				} else {
					add_filter ( 'woocommerce_sale_flash', array (
					$this,
					'wli_woocommerce_show_product_loop_sale_badge_remove'
						), 11, 3 );
				}
				if (ENABLE_STICKER_DETAIL == "yes") {
					remove_action ( 'woocommerce_before_single_product_summary', array (
					$this,
					'wli_woocommerce_show_product_loop_sale_badge'
						), 30 );
						add_filter ( 'woocommerce_before_single_product_summary', array (
						$this,
						'wli_woocommerce_show_product_loop_soldout_badge'
							), 11, 3 );
				} else {
					add_filter ( 'woocommerce_before_single_product_summary', array (
					$this,
					'wli_woocommerce_show_product_loop_sale_badge_remove'
						), 11, 3 );
					remove_action ( 'woocommerce_before_shop_loop_item_title', array (
					$this,
					'wli_woocommerce_show_product_loop_soldout_badge'
						), 30 );						
				}
				
			}
			else {
				add_filter ( 'woocommerce_sale_flash', array (
				$this,
				'wli_woocommerce_show_product_loop_sale_badge_remove'
					), 11, 3 );												
			}
			
			
			/**
			 * Filter added for resolving bug of print product
			 * not display.
			 * v 1.0.4 jenilk
			 * */
			if(ENABLE_PRINT_PRODUCT == "yes")
			{				
				if (ENABLE_STICKER_LISTING == "yes") {											
					add_filter ( 'woocommerce_before_shop_loop_item_title', array (
					 $this,
					 'wli_woocommerce_show_product_loop_print_badge'
					), 11, 3 );
				} else {
					add_filter ( 'woocommerce_sale_flash', array (
					$this,
					'wli_woocommerce_show_product_loop_sale_badge_remove'
						), 11, 3 );
				}
				if (ENABLE_STICKER_DETAIL == "yes") {
					remove_action ( 'woocommerce_before_single_product_summary', array (
					$this,
					'wli_woocommerce_show_product_loop_sale_badge'
						), 30 );
						add_filter ( 'woocommerce_before_single_product_summary', array (
						$this,
						'wli_woocommerce_show_product_loop_print_badge'
							), 11, 3 );
				} else {
					add_filter ( 'woocommerce_before_single_product_summary', array (
					$this,
					'wli_woocommerce_show_product_loop_sale_badge_remove'
						), 11, 3 );
					remove_action ( 'woocommerce_before_shop_loop_item_title', array (
					$this,
					'wli_woocommerce_show_product_loop_print_badge'
						), 30 );						
				}
				
			}
			else {
				add_filter ( 'woocommerce_sale_flash', array (
				$this,
				'wli_woocommerce_show_product_loop_sale_badge_remove'
					), 11, 3 );												
			}
		} 
	}
	
	/**
	 * Call back function for show new product badge.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function wli_woocommerce_show_product_loop_new_badge() {
		$postdate = get_the_time ( 'Y-m-d' );
		$postdatestamp = strtotime ( $postdate );				
		$newness = ((NEW_PRODUCT_DAYS=="")?10: trim(NEW_PRODUCT_DAYS));		
		$classPosition=((NEW_PRODUCT_POSITION=='left')? ((is_product())? " pos_left_detail " : " pos_left " ) : ((is_product())? " pos_right_detail " : " pos_right "));
		//$class = (ENABLE_NEW_PRODUCT_STYLE == "ribbon") ? ((NEW_PRODUCT_POSITION=='left')?" new_ribbon_left ":" new_ribbon_right ") : "new_round";
		$class=((NEW_PRODUCT_CUSTOM_STICKER=='')?((ENABLE_NEW_PRODUCT_STYLE == "ribbon") ? ((NEW_PRODUCT_POSITION=='left')?" woosticker new_ribbon_left ":" woosticker new_ribbon_right ") : ((NEW_PRODUCT_POSITION=='left')?" woosticker new_round_left ":" woosticker new_round_right ")):"custom_sticker_image");		
		if ((time () - (60 * 60 * 24 * $newness)) < $postdatestamp && ENABLE_NEW_PRODUCT == "yes") {
			//// If the product was published within the newness time frame display the new badge /////
			if(NEW_PRODUCT_CUSTOM_STICKER=='')
				echo '<span class="'. $class . $classPosition. '">' . __ ( 'New', 'woocommerce-new-badge' ) . '</span>';
			else 
				echo '<span class="custom_sticker_image '. $classPosition. '" style="background-image:url('.NEW_PRODUCT_CUSTOM_STICKER.'); color:transparent;"></span>';
		}
	}
	
	/**
	 * Call back function for show sale product badge.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function wli_woocommerce_show_product_loop_sale_badge() {
		global $product;		
		$classSalePosition=((SALE_PRODUCT_POSITION=='left') ? ((is_product())? " pos_left_detail " : " pos_left " ) : ((is_product())? " pos_right_detail " : " pos_right "));				
		$classSoldPosition=((SOLD_PRODUCT_POSITION=='left') ? ((is_product())? " pos_left_detail " : " pos_left " ) : ((is_product())? " pos_right_detail " : " pos_right "));
		$classPrintPosition=((PRINT_PRODUCT_POSITION=='left') ? ((is_product())? " pos_left_detail " : " pos_left " ) : ((is_product())? " pos_right_detail " : " pos_right "));	
		$classSale = ((SALE_PRODUCT_CUSTOM_STICKER=='')?((ENABLE_SALE_PRODUCT_STYLE == "ribbon") ? ((SALE_PRODUCT_POSITION=='left')?" woosticker onsale_ribbon_left ":" woosticker onsale_ribbon_right ") : ((SALE_PRODUCT_POSITION=='left')?" woosticker onsale_round_left ":" woosticker onsale_round_right ")):"custom_sticker_image");
		//$classSold= (empty(SOLD_PRODUCT_CUSTOM_STICKER)?(ENABLE_SOLD_PRODUCT_STYLE == "ribbon") ? "woosticker soldout_ribbon" : "woosticker soldout_round":"custom_sticker_image");
		$classSold=((SOLD_PRODUCT_CUSTOM_STICKER=='')?((ENABLE_SOLD_PRODUCT_STYLE == "ribbon") ? ((SOLD_PRODUCT_POSITION=='left')?" woosticker soldout_ribbon_left ":" woosticker soldout_ribbon_right ") : ((SOLD_PRODUCT_POSITION=='left')?" woosticker soldout_round_left ":" woosticker soldout_round_right ")):"custom_sticker_image");
		//$classPrint= (empty(PRINT_PRODUCT_CUSTOM_STICKER)?(ENABLE_PRINT_PRODUCT_STYLE == "ribbon") ? "woosticker print_ribbon" : "woosticker soldout_round":"custom_sticker_image");
		$classPrint=((PRINT_PRODUCT_CUSTOM_STICKER=='')?((ENABLE_PRINT_PRODUCT_STYLE == "ribbon") ? ((PRINT_PRODUCT_POSITION=='left')?" woosticker print_ribbon_left ":" woosticker print_ribbon_right ") : ((PRINT_PRODUCT_POSITION=='left')?" woosticker print_round_left ":" woosticker print_round_right ")):"custom_sticker_image");
		
		if (! $product->is_in_stock ()) {
			if(ENABLE_SOLD_PRODUCT=="yes")
			{
				if($classSold=="custom_sticker_image")
					echo '<span class="' . $classSold . $classSoldPosition . '" style="background-image:url('.SOLD_PRODUCT_CUSTOM_STICKER.'); color:transparent;"> Sold Out </span>';
				else
					echo '<span class="'.$classSold . $classSoldPosition .'">Sold Out</span>';
			}
		} else {
			if($classSale=="custom_sticker_image")
				return '<span class="' . $classSale . $classSalePosition . '" style="background-image:url('.SALE_PRODUCT_CUSTOM_STICKER.'); color:transparent;"> Sale </span>';
			else
				return '<span class="' . $classSale . $classSalePosition . '"> Sale </span>';
		}
	}
	/**
	 * Call back function for show sold product badge.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function wli_woocommerce_show_product_loop_soldout_badge()
	{
		global $product;
		
		$classSoldPosition=((SOLD_PRODUCT_POSITION=='left') ? ((is_product())? " pos_left_detail " : " pos_left " ) : ((is_product())? " pos_right_detail " : " pos_right "));
		$classSold=((SOLD_PRODUCT_CUSTOM_STICKER=='')?((ENABLE_SOLD_PRODUCT_STYLE == "ribbon") ? ((SOLD_PRODUCT_POSITION=='left')?" woosticker soldout_ribbon_left ":" woosticker soldout_ribbon_right ") : ((SOLD_PRODUCT_POSITION=='left')?" woosticker soldout_round_left ":" woosticker soldout_round_right ")):"custom_sticker_image");
		if (! $product->is_in_stock ()) {
			if(ENABLE_SOLD_PRODUCT=="yes")
			{
				if($classSold=="custom_sticker_image")
					echo '<span class="' . $classSold . $classSoldPosition . '" style="background-image:url('.SOLD_PRODUCT_CUSTOM_STICKER.'); color:transparent;"> Sold Out </span>';
				else
					echo '<span class="'.$classSold . $classSoldPosition .'">Sold Out</span>';
			}
		}
	}
	
	
	/**
	 * Call back function for show print product badge.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function wli_woocommerce_show_product_loop_print_badge()
	{
		global $product;
		
		$classPrintPosition=((PRINT_PRODUCT_POSITION=='left') ? ((is_product())? " pos_left_detail " : " pos_left " ) : ((is_product())? " pos_right_detail " : " pos_right "));
		$classPrint=((PRINT_PRODUCT_CUSTOM_STICKER=='')?((ENABLE_PRINT_PRODUCT_STYLE == "ribbon") ? ((PRINT_PRODUCT_POSITION=='left')?" woosticker print_ribbon_left ":" woosticker print_ribbon_right ") : ((PRINT_PRODUCT_POSITION=='left')?" woosticker print_round_left ":" woosticker print_round_right ")):"custom_sticker_image");
		if (! $product->is_in_stock ()) {
			if(ENABLE_PRINT_PRODUCT=="yes")
			{
				if($classPrint=="custom_sticker_image")
					echo '<span class="' . $classPrint . $classPrintPosition . '" style="background-image:url('.PRINT_PRODUCT_CUSTOM_STICKER.'); color:transparent;"> Printed </span>';
				else
					echo '<span class="'.$classPrint . $classPrintPosition .'">Printed</span>';
			}
		}
	}
	/**
	 * Remove the sale badge on details page.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function wli_woocommerce_show_product_loop_sale_badge_remove() {		
		
		remove_action ( 'woocommerce_before_single_product_summary', array (
				$this,
				'wli_woocommerce_show_product_loop_sale_badge' 
		), 30 );		
		return false;
	}
}
;
new wooStickerView();
