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
        </div>
        <div id="kassecontent">
            <div class="button" id="addbutton">Tilføj</div>
            <div id="products">
                <div class="productgrid">
<?php
$args = array(
    'posts_per_page' => '-1',
    'product_cat' => 'veganske-maaltider',
    'post_type' => 'product',
    'orderby' => 'title',
);


$query = new WP_Query( $args );
if( $query->have_posts()) : while( $query->have_posts() ) : $query->the_post();
?>
                    <div>
                        <?php the_post_thumbnail('medium'); ?>
                    </div>
                    <?php 
						/*if ( isset($_POST['new-order']) && $_POST['new-order'] === 'Submit' ) {
						    trigger_new_order( get_the_id(), $subscription );
						} else {}*/
    				?>
    <form class="new" method="post">
        <input class="button alt" data-product="<?php get_the_id(); ?>" type="submit" id="button gaia-new-order" name="new-order" value="Submit" >
    </form>
    <script>
    	jQuery(document).ready(function($) {

    		var data = {
    			action: 'gaia_add_to_cart',
    			product: $('#gaia-new-order').attr('data-product');
    		};

			$.ajax({
	          url: "/portal/wp-admin/admin-ajax.php", /** Denne skal ændres til korrekt URL senere **/
	          type: "post",
	          data: data,
	          success: function(resp) {
	            console.log(resp);
	          },
	          error: function(errorThrown) {
	            console.log(errorThrown);
	          }
	        });
    	});
    </script>
    <?
};
endwhile;
endif;
?>
    </div>
</div>
                <div class="kort" >
                    <?php foreach ( $subscription->get_items() as $item_id => $item ) { ?>
                        <div class="product">
                            <div>
                                <?php echo $item->get_name(); ?>
                            </div>
                            <div>
                                <?php echo $item->get_quantity(); ?>
                            </div>
                            <div>
                                <?php echo $item->get_subtotal_tax() + $item->get_subtotal(); ?>,-
                            </div>
                            <div>
                            <a href="<?php echo esc_url( WCS_Remove_Item::get_remove_url( $subscription->get_id(), $item_id ) );?>" class="remove" onclick="return confirm('<?php printf( esc_html( $confirm_notice ) ); ?>');">&times;</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
        </div>
    </div>
    <div class="collapsible">
        <div class="grid154045">
            <i class="fas fa-truck"></i>
            <p class="noticelabel">Næste kasse</p>
            <p class="noticevalue">
                <?php
                echo $levering;
                echo date('Y-m-d', strtotime($levering. ' + 4 days'));
                ?>
            </p>
        </div>
        <div id="leveringscontent">
            <hr>
            <p class="contentheading">Leveres<ion-icon button (click)="frek()" class="edit" size="small" name="pencil"></ion-icon></p>
            <p *ngIf="details.billing_interval==='1'">Hver Uge </p>
            <p *ngIf="details.billing_interval==='2'">Hver 2. Uge</p>
            <p *ngIf="details.billing_interval==='4'">Hver 4. Uge</p>
            <p *ngIf="details.shipping_lines[0].id!=72170" class="contentheading">Leveringsadresse<ion-icon button (click)="adresse()" class="edit" size="small" name="pencil"></ion-icon></p>
            <div class="adresselabel">
                Navn
            </div>
            <div class="adressevalue">
                {{details.shipping.first_name}} {{details.shipping.last_name}}
            </div>
            <hr>
            <div class="adresselabel">
                Adresse
            </div>
            <div class="adressevalue">
                {{details.shipping.address_1}} {{details.shipping.address_2}}
            </div>
            <hr>
            <div class="adresselabel">
                Postnr. og by
            </div>
            <div class="adressevalue">
                {{details.shipping.postcode}} {{details.shipping.city}}
            </div>
            <hr>
            <p class="contentheading">Note<ion-icon button (click)="note()" class="edit" size="small" name="pencil"></ion-icon></p>
            <p>{{ details.customer_note}}</p>
            <p *ngIf="!details.customer_note">Ingen note</p>
        </div>
    </div>
<table class="shop_table order_details">
	<thead>
		<tr>
			<th class="product-remove" style="width: 3em;">&nbsp;</th>
			<th class="product-name">Produkt</th>
			<th class="product-total">Pris</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ( $subscription->get_items() as $item_id => $item ) {
			$_product  = apply_filters( 'woocommerce_subscriptions_order_item_product', $item->get_product(), $item );
			if ( apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $subscription ) ); ?>">
						<td class="remove_item">
							<?php if ( wcs_can_item_be_removed( $item, $subscription ) ) : ?>
								<?php $confirm_notice = apply_filters( 'woocommerce_subscriptions_order_item_remove_confirmation_text', __( 'Are you sure you want remove this item from your subscription?', 'woocommerce-subscriptions' ), $item, $_product, $subscription );?>
								<a href="<?php echo esc_url( WCS_Remove_Item::get_remove_url( $subscription->get_id(), $item_id ) );?>" class="remove" onclick="return confirm('<?php printf( esc_html( $confirm_notice ) ); ?>');">&times;</a>
							<?php endif; ?>
						</td>
					<td class="product-name">
						<?php
						if ( $_product && ! $_product->is_visible() ) {
							echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item['name'], $item, false ) );
						} else {
							echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', sprintf( '<a href="%s">%s</a>', get_permalink( $item['product_id'] ), $item['name'] ), $item, false ) );
						}

						echo wp_kses_post( apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times; %s', $item['qty'] ) . '</strong>', $item ) );

						/**
						 * Allow other plugins to add additional product information here.
						 *
						 * @param int $item_id The subscription line item ID.
						 * @param WC_Order_Item|array $item The subscription line item.
						 * @param WC_Subscription $subscription The subscription.
						 * @param bool $plain_text Wether the item meta is being generated in a plain text context.
						 */
						do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $subscription, false );

						wcs_display_item_meta( $item, $subscription );

						/**
						 * Allow other plugins to add additional product information here.
						 *
						 * @param int $item_id The subscription line item ID.
						 * @param WC_Order_Item|array $item The subscription line item.
						 * @param WC_Subscription $subscription The subscription.
						 * @param bool $plain_text Wether the item meta is being generated in a plain text context.
						 */
						do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $subscription, false );
						?>
					</td>
					<td class="product-total">
						<?php echo wp_kses_post( $subscription->get_formatted_line_subtotal( $item ) ); ?>
					</td>
				</tr>
				<?php
			}

			if ( $subscription->has_status( array( 'completed', 'processing' ) ) && ( $purchase_note = get_post_meta( $_product->id, '_purchase_note', true ) ) ) {
				?>
				<tr class="product-purchase-note">
					<td colspan="3"><?php echo wp_kses_post( wpautop( do_shortcode( $purchase_note ) ) ); ?></td>
				</tr>
				<?php
			}
		}
		?>
	</tbody>
		<tfoot>
		<?php
        $totals                     = $subscription->get_order_item_totals();
		foreach( $totals as $key => $total ) : ?>
			<tr>
				<th scope="row" colspan="2"><?php echo esc_html( $total['label'] ); ?></th>
				<td><?php echo wp_kses_post( $total['value'] ); ?></td>
			</tr>
		<?php endforeach; ?>
	</tfoot>
</table>
<?php echo $subscription->get_subtotal(); ?>
<?php echo $subscription->get_subtotal_to_display(); ?>
<?php echo $subscription->get_total(); ?>
<?php echo $subscription->get_shipping_method(); ?>
<table class="shop_table subscription_details">
	<tbody>
		<tr>
			<td><?php esc_html_e( 'Status', 'woocommerce-subscriptions' ); ?></td>
			<td><?php echo esc_html( wcs_get_subscription_status_name( $subscription->get_status() ) ); ?></td>
		</tr>
		<?php do_action( 'wcs_subscription_details_table_before_dates', $subscription ); ?>
		<?php
		$dates_to_display = apply_filters( 'wcs_subscription_details_table_dates_to_display', array(
			'start_date'              => _x( 'Start date', 'customer subscription table header', 'woocommerce-subscriptions' ),
			'last_order_date_created' => _x( 'Last order date', 'customer subscription table header', 'woocommerce-subscriptions' ),
			'next_payment'            => _x( 'Next payment date', 'customer subscription table header', 'woocommerce-subscriptions' ),
			'end'                     => _x( 'End date', 'customer subscription table header', 'woocommerce-subscriptions' ),
			'trial_end'               => _x( 'Trial end date', 'customer subscription table header', 'woocommerce-subscriptions' ),
		), $subscription );
		foreach ( $dates_to_display as $date_type => $date_title ) : ?>
			<?php $date = $subscription->get_date( $date_type ); ?>
			<?php if ( ! empty( $date ) ) : ?>
				<tr>
					<td><?php echo esc_html( $date_title ); ?></td>
					<td><?php echo esc_html( $subscription->get_date_to_display( $date_type ) ); ?></td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php do_action( 'wcs_subscription_details_table_after_dates', $subscription ); ?>
		<?php if ( WCS_My_Account_Auto_Renew_Toggle::can_user_toggle_auto_renewal( $subscription ) ) : ?>
			<tr>
				<td><?php esc_html_e( 'Auto renew', 'woocommerce-subscriptions' ); ?></td>
				<td>
					<div class="wcs-auto-renew-toggle">
						<?php

						$toggle_classes = array( 'subscription-auto-renew-toggle', 'subscription-auto-renew-toggle--hidden' );

						if ( $subscription->is_manual() ) {
							$toggle_label     = __( 'Enable auto renew', 'woocommerce-subscriptions' );
							$toggle_classes[] = 'subscription-auto-renew-toggle--off';

							if ( WC_Subscriptions::is_duplicate_site() ) {
								$toggle_classes[] = 'subscription-auto-renew-toggle--disabled';
							}
						} else {
							$toggle_label     = __( 'Disable auto renew', 'woocommerce-subscriptions' );
							$toggle_classes[] = 'subscription-auto-renew-toggle--on';
						}?>
						<a href="#" class="<?php echo esc_attr( implode( ' ' , $toggle_classes ) ); ?>" aria-label="<?php echo esc_attr( $toggle_label ) ?>"><i class="subscription-auto-renew-toggle__i" aria-hidden="true"></i></a>
						<?php if ( WC_Subscriptions::is_duplicate_site() ) : ?>
								<small class="subscription-auto-renew-toggle-disabled-note"><?php echo esc_html__( 'Using the auto-renewal toggle is disabled while in staging mode.', 'woocommerce-subscriptions' ); ?></small>
						<?php endif; ?>
					</div>
				</td>
			</tr>
		<?php endif; ?>
		<?php do_action( 'wcs_subscription_details_table_before_payment_method', $subscription ); ?>
		<?php if ( $subscription->get_time( 'next_payment' ) > 0 ) : ?>
			<tr>
				<td><?php esc_html_e( 'Payment', 'woocommerce-subscriptions' ); ?></td>
				<td>
					<span data-is_manual="<?php echo esc_attr( wc_bool_to_string( $subscription->is_manual() ) ); ?>" class="subscription-payment-method"><?php echo esc_html( $subscription->get_payment_method_to_display( 'customer' ) ); ?></span>
				</td>
			</tr>
		<?php endif; ?>
		<?php do_action( 'woocommerce_subscription_before_actions', $subscription ); ?>
		<?php $actions = wcs_get_all_user_actions_for_subscription( $subscription, get_current_user_id() ); ?>
		<?php if ( ! empty( $actions ) ) : ?>
			<tr>
				<td><?php esc_html_e( 'Actions', 'woocommerce-subscriptions' ); ?></td>
				<td>
					<?php foreach ( $actions as $key => $action ) : ?>
						<a href="<?php echo esc_url( $action['url'] ); ?>" class="button <?php echo sanitize_html_class( $key ) ?>"><?php echo esc_html( $action['name'] ); ?></a>
					<?php endforeach; ?>
				</td>
			</tr>
		<?php endif; ?>
		<?php do_action( 'woocommerce_subscription_after_actions', $subscription ); ?>
	</tbody>
</table>

<?php if ( $notes = $subscription->get_customer_order_notes() ) : ?>
	<h2><?php esc_html_e( 'Subscription updates', 'woocommerce-subscriptions' ); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate comment note">
			<div class="woocommerce-OrderUpdate-inner comment_container">
				<div class="woocommerce-OrderUpdate-text comment-text">
					<p class="woocommerce-OrderUpdate-meta meta"><?php echo esc_html( date_i18n( _x( 'l jS \o\f F Y, h:ia', 'date on subscription updates list. Will be localized', 'woocommerce-subscriptions' ), wcs_date_to_time( $note->comment_date ) ) ); ?></p>
					<div class="woocommerce-OrderUpdate-description description">
						<?php echo wp_kses_post( wpautop( wptexturize( $note->comment_content ) ) ); ?>
					</div>
	  				<div class="clear"></div>
	  			</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>
