<?php
$subscription = $args['subscription'];
?>
<div id="products">
    <div class="fullmodalhead">
        <div>
            Tilføj varer
        </div>
        <div style="text-align:right">
            <i class="fas fa-chevron-down"></i>
        </div>
    </div>
    <div class="category kassekasse hovedretter">
        <div class="grid104545">
            <i class="fas fa-box"></i>
            <p>Hoved/Frokostretter</p>
            <p></p>
            <i class="fas fa-chevron-down"></i>
        </div>
        <?php
        get_template_part('templates/productcategory', null, array(
            'category' => 'veganske-maaltider',
            'subscription' => $subscription,
        ));
        ?>
    </div>
    <div class="category kassekasse morgenmad">
        <div class="grid104545">
            <i class="fas fa-box"></i>
            <p>Morgenmad</p>
            <p></p>
            <i class="fas fa-chevron-down"></i>
        </div>
        <?php
        get_template_part('templates/productcategory', null, array(
            'category' => 'morgenmad',
            'subscription' => $subscription,
        ));
        ?>
    </div>
    <div class="category kassekasse paalaeg">
        <div class="grid104545">
            <i class="fas fa-box"></i>
            <p>Pålæg</p>
            <p></p>
            <i class="fas fa-chevron-down"></i>
        </div>
        <?php
        get_template_part('templates/productcategory', null, array(
            'category' => 'paalaeg',
            'subscription' => $subscription,
        ));
        ?>
    </div>
    <div class="category kassekasse snacks">
        <div class="grid104545">
            <i class="fas fa-box"></i>
            <p>Tilbehør og Snacks</p>
            <p></p>
            <i class="fas fa-chevron-down"></i>
        </div>
        <?php
        get_template_part('templates/productcategory', null, array(
            'category' => 'tilbehor-og-snacks',
            'subscription' => $subscription,
        ));
        ?>
    </div>
    <div class="category kassekasse drikkevarer">
        <div class="grid104545">
            <i class="fas fa-box"></i>
            <p>Drikkevarer</p>
            <p></p>
            <i class="fas fa-chevron-down"></i>
        </div>
        <?php
        get_template_part('templates/productcategory', null, array(
            'category' => 'juice',
            'subscription' => $subscription,
        ));
        ?>
    </div>
</div>