<script>
    jQuery(document).ready(function() {
        jQuery('.gaia-new-order').click(function() {
            var data = {
                action: 'gaia_add_to_cart',
                product: jQuery(this).closest('.gaia-new-order').attr('data-product'),
                subscription: jQuery(this).closest('.gaia-new-order').attr('data-subscription'),
                quantity: jQuery(this).parent().find('.quantity-field').val(),
            };
            jQuery.ajax({
                url: "/wp-admin/admin-ajax.php",
                /** Denne skal ændres til korrekt URL senere **/
                type: "post",
                data: data,
                success: function(resp) {
                    console.log(resp);
                    location.reload();
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
        jQuery('#changenote').click(function() {
            var data = {
                action: 'gaia_change_note',
                subscription: jQuery(this).attr('data-subscription'),
                note: jQuery('#note').val(),
            };
            jQuery.ajax({
                url: "/wp-admin/admin-ajax.php",
                /** Denne skal ændres til korrekt URL senere **/
                type: "post",
                data: data,
                success: function(resp) {
                    console.log(resp);
                    location.reload();
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
        jQuery('#changedate').click(function() {
            var data = {
                action: 'gaia_change_date',
                subscription: jQuery(this).attr('data-subscription'),
                note: jQuery('#deliverydate').val(),
            };
            console.log(data);
        });
        jQuery('#changeaddress').click(function() {
            var data = {
                action: 'gaia_change_address',
                subscription: jQuery(this).attr('data-subscription'),
                firstname: jQuery('#fname').val(),
                lastname: jQuery('#lname').val(),
                address1: jQuery('#address1').val(),
                address2: jQuery('#address2').val(),
                postcode: jQuery('#postcode').val(),
                city: jQuery('#city').val(),
            };
            console.log(data);
            jQuery.ajax({
                url: "/wp-admin/admin-ajax.php",
                /** Denne skal ændres til korrekt URL senere **/
                type: "post",
                data: data,
                success: function(resp) {
                    console.log(resp);
                    location.reload();
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
        jQuery('#openintervalmodal').click(function() {
            jQuery('#intervalmodal').toggle('fast');
        });
        jQuery('#openaddressmodal').click(function() {
            jQuery('#addressmodal').toggle('fast');
        });
        jQuery('#opennotemodal').click(function() {
            jQuery('#notemodal').toggle('fast');
        });
        jQuery('#opendatemodal').click(function() {
            jQuery('#datemodal').toggle('fast');

            jQuery("#deliverydate").datepicker({
                autoSize: true, // automatically resize the input field 
                altFormat: 'yy-mm-dd', // Date Format used
                firstDay: 1, // Start with Monday
                beforeShowDay: function(date)

                {
                    return [date.getDay() === 0, ''];
                }
            }); // Allow only one day a week
        });
        jQuery('#billinginterval').click(function() {
            var data = {
                action: 'gaia_update_billing_interval',
                interval: jQuery('#billinginterval').attr('data-interval'),
                subscription: jQuery('#billinginterval').attr('data-subscription')
            };
            console.log(data);
            jQuery.ajax({
                url: "/wp-admin/admin-ajax.php",
                /** Denne skal ændres til korrekt URL senere **/
                type: "post",
                data: data,
                success: function(resp) {
                    console.log(resp);
                    location.reload();
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
        jQuery('#changestatus').click(function() {
            var data = {
                action: 'gaia_change_status',
                status: jQuery('#changestatus').attr('data-status'),
                subscription: jQuery('#changestatus').attr('data-subscription')
            };
            jQuery.ajax({
                url: "/wp-admin/admin-ajax.php",
                /** Denne skal ændres til korrekt URL senere **/
                type: "post",
                data: data,
                success: function(resp) {
                    console.log(resp);
                    location.reload();
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
        jQuery('.removeprod').click(function() {
            var data = {
                action: 'gaia_remove_product',
                productid: jQuery('.removeprod').attr('data-productid'),
                subscription: jQuery('#changestatus').attr('data-subscription')
            };
            console.log(data);
            jQuery.ajax({
                url: "/wp-admin/admin-ajax.php",
                /** Denne skal ændres til korrekt URL senere **/
                type: "post",
                data: data,
                success: function(resp) {
                    console.log(resp);
                    location.reload();
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
    });
</script>
<?php
$subscription = $args['subscription'];
$levering = $args['levering']

/**
 * Gets subscription totals table template
 * @param WC_Subscription $subscription A subscription object
 * @since 2.2.19
 */

?>
<div class="abonnement">
    <div>
        <p id="id">#<?php echo $subscription->get_id(); ?></p>
        <p id="overskrift">Din Måltidskasse</p>
    </div>
    <div>
        <?php if ($subscription->get_status() == 'cancelled') : ?>
            <div class="statusboksafmeldt">Afmeldt</div>
        <?php elseif ($subscription->get_status() == 'on-hold') : ?>
            <div class="statusbokspause">På pause</div>
        <?php elseif ($subscription->get_status() == 'active') : ?>
            <div class="statusboksaktiv">Aktiv</div>
        <?php endif ?>
    </div>
    <div style="text-align:right">
        <i class="fas fa-chevron-down"></i>
    </div>
</div>
<div class="collapsible">
    <div class="grid104545">
        <i class="fas fa-box"></i>
        <p class="noticelabel">Måltidskassen</p>
        <p class="noticevalue"><?php echo $subscription->get_item_count(); ?> Varer </p>
        <i class="fas fa-chevron-down"></i>
    </div>
    <div id="collapsiblecontent">
        <div class="button" id="addbutton">Tilføj</div>
        <?php get_template_part('templates/addproducts', null, array(
            'subscription' => $subscription,
        ));
        ?>
        <div class="kort">
            <?php foreach ($subscription->get_items() as $item_id => $item) { ?>
                <div class="product">
                    <div>
                        <?php echo $item->get_name(); ?>
                    </div>
                    <div style="text-align:center">
                        <?php echo $item->get_quantity(); ?>
                    </div>
                    <div style="text-align:center">
                        <?php echo $item->get_subtotal_tax() + $item->get_subtotal(); ?>,-
                    </div>
                    <div style="text-align:center">
                        <div data-productid="<?php echo $item_id ?>" class="removeprod">X</div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="collapsible">
    <div class="grid104545">
        <i class="fas fa-truck"></i>
        <p class="noticelabel">Næste kasse</p>
        <p class="noticevalue">
            <?php
            echo date('Y-m-d', strtotime($levering . ' + 4 days'));
            ?>
        </p>
        <i class="fas fa-chevron-down"></i>
    </div>

    <div id="collapsiblecontent">
        <hr>
        <p class="contentheading">Leveres<i class="fas fa-pen" id="openintervalmodal"></i></p>
        <div class="text-center">
            <?php
            if ($subscription->get_billing_interval() == '1') : ?>
                <p>Hver uge</p>
            <?php elseif ($subscription->get_billing_interval() == '2') : ?>
                <p>Hver 2. uge</p>
            <?php elseif ($subscription->get_billing_interval() == '4') : ?>
                <p>Hver 4. uge</p>
            <?php endif ?>
        </div>
        <hr>
        <p class="contentheading">Leveringsadresse<i class="fas fa-pen" id="openaddressmodal"></i></p>
        <div class="text-center">
            <?php
            echo $subscription->get_formatted_shipping_address();
            ?>
        </div>
        <hr>
        <p class="contentheading">Leveringsnote<i class="fas fa-pen" id="opennotemodal"></i></p>
        <div class="text-center">
            <?php echo $subscription->get_customer_note(); ?>
        </div>
    </div>
</div>
<div class="collapsible">
    <div class="grid104545">
        <i class="fas fa-credit-card"></i>
        <p class="noticelabel">Betaling</p>
        <p class="noticevalue">
            <?php
            echo $subscription->get_formatted_order_total();
            ?>,-
        </p>
        <i class="fas fa-chevron-down"></i>
    </div>
    <div id="collapsiblecontent">
        <hr>
        <div class="inline">
            Subtotal
        </div>
        <div class="float-right">
            <?php
            echo $subscription->get_subtotal_to_display();
            ?>
        </div>
        <hr>
        <div class="inline">
            Forsendelse
        </div>
        <div class="float-right">
            <?php
            echo $subscription->get_shipping_total() + $subscription->get_shipping_tax();
            ?>,-
        </div>
        <hr>
        <div *ngIf="details.coupon_lines.length > 0">
            <div class="inline">
                Rabat
            </div>
            <div class="float-right">
                <?php
                echo $subscription->get_discount_total();
                ?>,-
            </div>
            <hr>
        </div>
        <div class="inline">
            Total
        </div>
        <div class="float-right inline">
            <?php
            echo $subscription->get_formatted_order_total();
            ?>,-
        </div>
    </div>
</div>
<p class="contentheading">Handlinger</p>
<?php if ($subscription->get_status() == 'cancelled') : ?>
    <div class="button" data-subscription="<?php echo $subscription->get_id(); ?>" data-status="wc-active" id="changestatus">Genaktivér</div>
<?php elseif ($subscription->get_status() == 'on-hold') : ?>
    <div class="button" data-subscription="<?php echo $subscription->get_id(); ?>" data-status="wc-active" id="changestatus">Aktivér</div>
    <div class="button" data-subscription="<?php echo $subscription->get_id(); ?>" data-status="wc-cancelled" id="changestatus">Afmeld</div>
<?php elseif ($subscription->get_status() == 'active') : ?>
    <div class="button" data-subscription="<?php echo $subscription->get_id(); ?>" data-status="wc-on-hold" id="changestatus">Sæt på pause</div>
    <div class="button" data-subscription="<?php echo $subscription->get_id(); ?>" data-status="wc-cancelled" id="changestatus">Afmeld</div>
<?php endif ?>
<div class="button" data-subscription="<?php echo $subscription->get_id(); ?>" id="opendatemodal">Ryk næste levering</div>
<div id="intervalmodal" class="changemodal">
    <p class="modalheading">Hvor ofte vil du have leveret?</p>
    <div class="button" data-subscription="<?php echo $subscription->get_id(); ?>" data-interval="1" id="billinginterval">Hver uge</div>
    <div class="button" data-subscription="<?php echo $subscription->get_id(); ?>" data-interval="2" id="billinginterval">Hver 2. uge</div>
    <div class="button" data-subscription="<?php echo $subscription->get_id(); ?>" data-interval="4" id="billinginterval">Hver 4. uge</div>
</div>
<div id="addressmodal" class="changemodal">
    <p class="modalheading">Hvor vil du have leveret?</p>
    <label for="fname">Fornavn:</label>
    <input type="text" id="fname" name="fname">
    <label for="lname">Efternavn:</label>
    <input type="text" id="lname" name="lname">
    <label for="fname">Vejnavn & nr:</label>
    <input type="text" id="address1" name="address1">
    <label for="fname">Etage, dør, mm:</label>
    <input type="text" id="address2" name="address2">
    <label for="fname">Postnummer:</label>
    <input type="text" id="postcode" name="postcode">
    <label for="fname">By:</label>
    <input type="text" id="city" name="city" placeholder="By">
    <div class="button" data-subscription="<?php echo $subscription->get_id(); ?>" id="changeaddress">Bekræft</div>
</div>
<div id="notemodal" class="changemodal">
    <p class="modalheading">Har du en kommentar til levering?</p>
    <label for="note">Leveringsnote:</label>
    <input type="textarea" id="note" name="note" placeholder="note">
    <div class="button" data-subscription="<?php echo $subscription->get_id(); ?>" id="changenote">Bekræft</div>
</div>
<div id="datemodal" class="changemodal">
    <p class="modalheading">Hvornår vil du have næste levering?</p>
    <label for="note">Leveringsdag:</label>
    <input type="text" id="deliverydate" name="date">
    <div class="button" data-subscription="<?php echo $subscription->get_id(); ?>" id="changedate">Bekræft</div>
</div>