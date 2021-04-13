<?php
$category = $args['category'];
$subscription = $args['subscription'];
?>

<div class="productgrid">
    <?php
    $args = array(
        'posts_per_page' => '-1',
        'product_cat' => $category,
        'post_type' => 'product',
        'orderby' => 'title',
        'tax_query'   => array(array(
            'taxonomy'  => 'product_visibility',
            'terms'     => array('exclude-from-catalog'),
            'field'     => 'name',
            'operator'  => 'NOT IN',
        ))
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
    ?>
            <div class="productadd">
                <div class="productaddimg">
                    <?php the_post_thumbnail('thumbnail'); ?>
                </div>

                <div class="input-group">
                    <?php the_title(); ?>
                    <br>
                    <?php echo get_post_meta(get_the_ID(), '_regular_price', true); ?>,-
                    <br>
                    <input type="button" value="-" class="button-minus" data-field="quantity">
                    <input type="number" step="1" max="" value="1" name="quantity" class="quantity-field">
                    <input type="button" value="+" class="button-plus" data-field="quantity">
                    <div class="button gaia-new-order" type="submit" data-subscription="<?php echo $subscription->get_id(); ?>" data-product="<?php echo get_the_id(); ?>">Tilføj</div>
                </div>
            </div>
    <?php
        endwhile;
    endif;
    ?>
</div>