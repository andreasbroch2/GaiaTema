<?php
/**
* Template Name: Info
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
get_header(); 
?>
<h1 style="text-align:center"><?php the_title_attribute(); ?></h1>
<h2 style="text-align:center">Hoved/Frokostretter</h2>
<?php
function bbloomer_echo_product_ids_belong_to_cat2($cat) {
$args = array(
    'status' => array( 'publish' ),  
    'limit' => 100,
    'visibility' => 'catalog',
    'category' => array( $cat ),
    'orderby' => 'title', 
    'order' => 'ASC'
);
$products = wc_get_products($args);
?>
<div class="gridinfo">
	<?php
        foreach ( $products as $product ) :
           if($product->get_id() == '2565593911949' || $product->get_id() == '3168' || $product->get_id() == '3164'){

           } else{
            ?>
            
            <button type="button" class="collapsible" id="<?php echo $product->get_id(); ?>"><?php echo $product->get_title() ?></button>
            <div class="content">
              <div class="cardgrid">
                <div class="imageinfo left">
                  <?php echo $product->get_image(); ?>
                </div>
                <div class="imageinfo right">
                  <h3>Fryseegnet?</h3>
                  <?php 
                  $categorytags = $product->get_tag_ids();
                  if (in_array('4622', $categorytags)) {
                    echo 'Ja';
                  } else {
                    echo 'Nej';
                  }
                  ?>
                  <h3>Glutenfri?</h3>
                  <?php 
                  $categoryids = $product->get_category_ids();
                  if (in_array('37', $categoryids)) {
                    echo 'Ja';
                  } else {
                    echo 'Nej';
                  }
                  ?>
                  <h3>Co2e</h3>
                  <?php echo $product->get_attribute( 'co2' )?>
                </div>
              </div>
              <div class="nutrigrid">
                  <p class="nutri">kcal</p>
                  <p class="nutri">protein</p>
                  <p class="nutri">fedt</p>
                  <p class="nutri">kulhydrat</p>
                  <p class="nutri"><?php echo $product->get_attribute('kcal')?></p>
                  <p class="nutri"><?php echo $product->get_attribute('protein')?></p>
                  <p class="nutri"><?php echo $product->get_attribute('fedt')?></p>
                  <p class="nutri"><?php echo $product->get_attribute('kulhydrat')?></p>
              </div>
              <p id="guide" class="nutri">Tilberedningsguide:</p>
              <?php echo $product->get_meta('vejledning'); ?>
              <p id="ingredienser" class="nutri">Ingredienser:</p>
              <?php echo $product->get_meta('ingredienser'); ?>
            </div>
        <?php
           }
        endforeach; 
    }
    bbloomer_echo_product_ids_belong_to_cat2('veganske-maaltider');
?>
</div>
<h2 style="text-align:center">Pålæg/Tilbehør</h2>
<?php
    bbloomer_echo_product_ids_belong_to_cat2('tilbehor-og-snacks	');
?>
<h2 style="text-align:center">Morgenmad</h2>
<?php
    bbloomer_echo_product_ids_belong_to_cat2('morgenmad');
?>
<style>
  .cardgrid {
    display: grid;
    grid-template-columns: 1fr 1fr;
  }
  .nutrigrid {
    display:grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    text-align: center;
    margin-top: 10px;
  }
  .nutri{
    font-weight: bold;
    margin-bottom: 10px;
    text-align: center;
  }
  .imageinfo {
    text-align: center; 
  }
  .left{
    float: left;
  }
  .rigth{
    float: right;
  }
  h3 {
    margin-bottom: 0;
  }
/* Style the button that is used to open and close the collapsible content */
.collapsible {
  background-color: #eee;
  color: #063;
  cursor: pointer;
  padding: 15px;
  width:90%;
  margin: 5px 5%;
  border: none;
  text-align: center;
  outline: none;
  font-size: 15px;
  font-weight: bold;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
.active, .collapsible:hover {
  background-color: #063;
  color:#fff;
}

/* Style the collapsible content. Note: hidden by default */
.content {
  padding: 18px;
  display: none;
  overflow: hidden;
  margin: 5px;
  background-color: #f1f1f1;
  border-radius: 20px;
}
@media (min-width: 800px){
.cardgrid {
  width: 50%;
  float: left; 
}
.nutrigrid {
  width:48%; 
}
#ingredienser{
  width: 100%;
}
}
</style>
<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
window.onload = function() {
  var url = new URL(window.location.href);
  var action = url.searchParams.get('action');
  if (action) {
    document.getElementById(action).scrollIntoView();
    document.getElementById(action).click();
  }
}
</script>