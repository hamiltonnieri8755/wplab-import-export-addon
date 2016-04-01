<div class="import-export-wrapper">
	
	<!-- TAB START-->
	<h2 class="nav-tab-wrapper">  
	    <a id="wpl_import" href="#" class="nav-tab">Import</a>
        <a id="wpl_export" href="#" class="nav-tab nav-tab-active">Export</a>     
    </h2> 
    <!-- TAB END -->

    <!-- EXPORT TAB CONTENT START-->
    <div class="tab-export tab-active">

    	<!-- ONE ORDER PER ROW FORM START-->
    	<form method="get" id="wple_order_export">
    		<input type="hidden" name="addon_action" value="export_order" />
    		<?php
				do_action( 'wple_order_export' );
				submit_button( __('Export Order CSV') ); 
			?>
    	</form>
    	<!-- ONE ORDER PER ROW FORM END -->
    	
    	<!-- ONE ORDER ITEM PER ROW FORM STARt -->
    	<form method="get" id="wple_orderitem_export">
    		<input type="hidden" name="addon_action" value="export_orderitem" />
    		<?php
				do_action( 'wple_orderitem_export' );
				submit_button( __('Export Order Item CSV') ); 
			?>
    	</form>
    	<!-- ONE ORDER ITEM PER ROW FORM END -->
    
    </div>
    <!-- EXPORT TAB CONTENT END -->

    <!-- IMPORT TAB CONTENT START -->
    <div class="tab-import">
        <form method="get" id="wple_order_import">
        	<input type="file" name="csv_file" />
    		<input type="hidden" name="addon_action" value="import_order" />
    		<?php
				do_action( 'wple_order_import' );
				submit_button( __('Import Order CSV') ); 
			?>
    	</form>
    </div>
    <!-- IMPORT TAB CONTENT END -->

</div>