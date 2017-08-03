<h2>Product Page Settings</h2>
<?php 
    $response = jem_sf_api_call('GetCustomerFeatures', null);
    $features = $response->Data;
    
    $product_pages_enabled =  $features && $features->ProductPages;
    
    $options = get_option('jem_sf_options');

    if (jem_sf_initialize_product_page_default($options))
    {
        jem_sf_create_product_page($options);        
        update_option('jem_sf_options', $options);
    }
    $product_page_activated = true;
    
    if (!jem_sf_get_and_validate_product_page($options))
    {
        $product_page_activated = false;
    } 
    else if (jem_sf_initialize_product_page_default($options))
    {
        update_option('jem_sf_options', $options);
    }
    
    if ($_GET['pp_activate'] && !$product_page_activated && $product_pages_enabled)
    {
        jem_sf_create_product_page($options);        
        jem_sf_initialize_product_page_default($options);
        update_option('jem_sf_options', $options);
        $product_page_activated = true;
    }
    else if ($_GET['pp_submitted'])
    {
        $pp_enabled = $_GET['pp_enabled'];
        $xsell_max = $_GET['xsell_max'];
        $xsell_cols = $_GET['xsell_cols'];        
        $xsell_img = $_GET['xsell_img'];        
        $image_width = $_GET['image_width'];
        $call_to_action_img = $_GET['call_to_action_img'];
        $new_window = $_GET['new_window'] == "1";
        
        $options['pp_xsell_header'] = $_GET['xsell_header'];
        $options['pp_merchant_header']= $_GET['merchant_header'];
        $options['pp_button_text']= $_GET['button_text'];
        
        $options['pp_call_to_action_img']= $call_to_action_img;
        
        $options['pp_new_window']= $new_window;
        
        if (is_numeric($xsell_max))
        {
            $options['pp_xsell_max'] = $xsell_max;
        }
        
        if (is_numeric($xsell_cols))
        {
            $options['pp_xsell_cols'] = $xsell_cols;
        }
        
        if (is_numeric($xsell_img))
        {
            $options['pp_xsell_img'] = $xsell_img;
        }
        
        if (is_numeric($image_width))
        {
            $options['pp_image_width'] = $image_width;
        }
        
        update_option('jem_sf_options', $options);
    }
    
    $pp_enabled = $options['pp_enabled'];
    $xsell_max = $options['pp_xsell_max'];
    $xsell_cols = $options['pp_xsell_cols'];
    $xsell_header = $options['pp_xsell_header'];
    $xsell_img = $options['pp_xsell_img'];
    $merchant_header = $options['pp_merchant_header'];
    $button_text = $options['pp_button_text'];    
    $image_width = $options['pp_image_width'];
    $call_to_action_img = $options['pp_call_to_action_img'];
    $new_window = $options['pp_new_window'];
    
    if (!$product_pages_enabled)
    {
        ?>        
        <p>            
            Product page functionality is not available for your account.
            To enable product pages, please upgrade your subscription to the Professional, 
            Premium, or Developer plan. To learn more about product pages,
            please <a href="/features/product-pages">click here</a>.
        </p>           
        <?php
        return;
    }
    else if ($product_page_activated)
    {
?>

        <p>
            Product pages are the pages generated by SellFire for an individual product.
            You can use this page to configure how they look and behave.
        </p>
        
        <form method="GET" action="<?php echo site_url() . '/wp-admin/admin.php' ?>">
            <h3 class="setting-heading">General</h3>
            <table class="product-page-setting"  cellpadding="0" cellspacing="0">
                <tr class="alt">
                    <td class="sf-setting-label">Merchant List Header Text:</td>
                    <td>
                        <input type="text" size="50" name="merchant_header" value="<?php echo $merchant_header ?>">
                        <div>
                            Header text that appears above the list of merchants that
                            sell a product. This section only appears if more than
                            one merchant sells the product.
                        </div>
                    </td>                        
                    </td>
                </tr>                  
                <tr>
                    <td class="sf-setting-label">Buy Button Text:</td>
                    <td>
                        <input type="text" size="50" name="button_text" value="<?php echo $button_text ?>">
                        <div>
                            Text that appears in a product page button
                        </div>
                    </td>                        
                    </td>
                </tr>   
                <tr class="alt">
                    <td class="sf-setting-label">Buy Button Image URL:</td>
                    <td>
                        <input type="text" size="50" name="call_to_action_img" value="<?php echo $call_to_action_img ?>">
                        <div>
                            If you'd like to use an image to as your buy button, you can enter the location of the URL
                        </div>
                    </td>                        
                    </td>
                </tr>          
                <tr>
                    <td class="sf-setting-label">Open In New Window:</td>
                    <td>
                        <input type="checkbox" name="new_window" value="1" <?php echo $new_window ? "checked" : "" ?>>
                        <div>
                            Text that appears in a product page button
                        </div>
                    </td>                        
                    </td>
                </tr>                 
                <tr class="alt">
                    <td class="sf-setting-label">Main Product Image Width:</td>
                    <td>
                        <input type="text" size="10" name="image_width" value="<?php echo $image_width ?>">
                        <div>
                            The width of the product image in pixels.
                        </div>
                    </td>                        
                    </td>
                </tr>                  
                <tr>
                    <td colspan="2">
                        <h3 class="setting-heading">Cross Sells</h3>
                        <p>
                            Cross sells are the similar products that show on the product page.
                        </p>                        
                    </td>
                </tr>     
                <tr class="alt">
                    <td class="sf-setting-label">Section Header:</td>
                    <td>
                        <input type="text" size="50" name="xsell_header" value="<?php echo $xsell_header ?>">
                        <div>
                            Header text to show at the top of the cross sell section.
                        </div>                        
                    </td>
                </tr>                   
                <tr>
                    <td class="sf-setting-label">Maximum Cross Sells:</td>
                    <td>
                        <input type="text" size="10" name="xsell_max" value="<?php echo $xsell_max ?>">
                        <div>
                            The maximum number of cross sells to show on the
                            product page. Maximum allowed is 100.
                        </div>
                    </td>
                </tr>                
                <tr class="alt">
                    <td class="sf-setting-label">Cross Sells Columns:</td>
                    <td>
                        <input type="text" size="10" name="xsell_cols" value="<?php echo $xsell_cols ?>">
                        <div>
                            The number of cross sells to show in a single row.                            
                        </div>
                    </td>                        
                    </td>
                </tr>  
                <tr>
                    <td class="sf-setting-label">Cross Sell Image Width:</td>
                    <td>
                        <input type="text" size="10" name="xsell_img" value="<?php echo $xsell_img ?>">
                        <div>
                            The width, in pixels, of the cross sell images.
                        </div>                        
                    </td>
                </tr>                                                 
            </table>    
            <input type="hidden" name="page" value="jem_sf_sellfire_product_pages"/>
            <input type="hidden" name="pp_submitted" value="1"/>
            
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </form>
        
        <?php
    }
    else
    {
        ?>       
        <form method="GET" action="<?php echo site_url() . '/wp-admin/admin.php' ?>">
            <p>Product pages are not currently activated. Click the button below
            to activate this feature.
            </p>
            <div>
                <input type="hidden" name="pp_activate" value="1">
                <input type="hidden" name="page" value="jem_sf_sellfire_product_pages"/>                
                <input type="submit" value="Activate Product Pages"/>
            </div>
        </form>
        <?php
    }
        
    
        