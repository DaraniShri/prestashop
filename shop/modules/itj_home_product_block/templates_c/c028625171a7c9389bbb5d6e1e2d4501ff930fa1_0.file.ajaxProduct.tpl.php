<?php
/* Smarty version 3.1.47, created on 2023-09-18 18:05:24
  from 'C:\xampp\htdocs\shop\modules\itj_home_product_block\view\templates\hook\ajaxProduct.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6508440c4deb69_90950556',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c028625171a7c9389bbb5d6e1e2d4501ff930fa1' => 
    array (
      0 => 'C:\\xampp\\htdocs\\shop\\modules\\itj_home_product_block\\view\\templates\\hook\\ajaxProduct.tpl',
      1 => 1695040099,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6508440c4deb69_90950556 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['blocks']->value, 'single_block', false, 'index');
$_smarty_tpl->tpl_vars['single_block']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['index']->value => $_smarty_tpl->tpl_vars['single_block']->value) {
$_smarty_tpl->tpl_vars['single_block']->do_else = false;
$_smarty_tpl->_assignInScope('products', $_smarty_tpl->tpl_vars['single_block']->value['products']);?>
<div class="block">    
    <div class="right-block">
        <h2 class="section-title text-left"><?php echo $_smarty_tpl->tpl_vars['single_block']->value['title'];?>
</h2>
        <div class="products">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['single_block']->value['products'], 'product');
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
?>
            <div>
            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8702876336508440c4c93e2_24851218', 'product_miniature_item');
?>

            </div>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </div>
    </div>
</div>          
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
/* {block 'product_thumbnail'} */
class Block_4182786346508440c4ca174_54489078 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                            <?php if ($_smarty_tpl->tpl_vars['product']->value['cover']) {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['url'];?>
" class="thumbnail product-thumbnail">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['product']->value['cover']['bySize']['home_default']['url'];?>
" alt="" width="250" height="250"/>
                                </a>
                            <?php }?>
                        <?php
}
}
/* {/block 'product_thumbnail'} */
/* {block 'product_name'} */
class Block_7858583706508440c4cd231_00124471 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                        <h3 class="h3 product-title"><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</a></h3>
                        <?php
}
}
/* {/block 'product_name'} */
/* {block 'product_price_and_shipping'} */
class Block_19280649876508440c4cdf94_68494727 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\htdocs\\shop\\vendor\\smarty\\smarty\\libs\\plugins\\function.math.php','function'=>'smarty_function_math',),));
?>

                            <?php if ($_smarty_tpl->tpl_vars['product']->value['show_price']) {?>
                                <div class="product-price-and-shipping">
                                    <?php if ($_smarty_tpl->tpl_vars['product']->value['has_discount']) {?>
                        
                                        <span class="regular-price" aria-label="Regular price"><?php echo $_smarty_tpl->tpl_vars['product']->value['regular_price'];?>
</span>
                                        <?php if ($_smarty_tpl->tpl_vars['product']->value['discount_type'] === 'percentage') {?>
                                        <span class="discount-percentage discount-product"><?php echo $_smarty_tpl->tpl_vars['product']->value['discount_percentage'];?>
</span>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['product']->value['discount_type'] === 'amount') {?>
                                        <span class="discount-amount discount-product"><?php echo $_smarty_tpl->tpl_vars['product']->value['discount_amount_to_display'];?>
</span>
                                        <?php }?>
                                    <?php }?>  
                                                          
                                    <span class="price" aria-label="Price">
                                        <?php echo $_smarty_tpl->tpl_vars['product']->value['price'];?>

                                    </span>
                                    
                                    <?php if ($_smarty_tpl->tpl_vars['product']->value['discount_type'] === 'percentage') {?>
                                        <span class="percentage">
                                            <?php echo $_smarty_tpl->tpl_vars['product']->value['discount_percentage'];?>

                                        </span>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['product']->value['discount_type'] === 'amount') {?>
                                        <span class="percentage">
                                        -<?php echo smarty_function_math(array('equation'=>"((x-y)/x) * 100",'x'=>$_smarty_tpl->tpl_vars['product']->value['price_without_reduction'],'y'=>$_smarty_tpl->tpl_vars['product']->value['price_amount'],'format'=>"%d"),$_smarty_tpl);?>
%
                                        </span>
                                    <?php }?>                         
                                </div>
                            <?php }?>
                            <?php
}
}
/* {/block 'product_price_and_shipping'} */
/* {block 'product_miniature_item'} */
class Block_8702876336508440c4c93e2_24851218 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'product_miniature_item' => 
  array (
    0 => 'Block_8702876336508440c4c93e2_24851218',
  ),
  'product_thumbnail' => 
  array (
    0 => 'Block_4182786346508440c4ca174_54489078',
  ),
  'product_name' => 
  array (
    0 => 'Block_7858583706508440c4cd231_00124471',
  ),
  'product_price_and_shipping' => 
  array (
    0 => 'Block_19280649876508440c4cdf94_68494727',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                <div class="product top-deals">
                    <article class="product-miniature js-product-miniature" data-id-product="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
" data-id-product-attribute="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
">
                    <div class="thumbnail-container">
                        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4182786346508440c4ca174_54489078', 'product_thumbnail', $this->tplIndex);
?>

                    </div>

                    <div class="product-description">
                        <p class="reference"><?php echo $_smarty_tpl->tpl_vars['product']->value['reference'];?>
</p>
                        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7858583706508440c4cd231_00124471', 'product_name', $this->tplIndex);
?>


                        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19280649876508440c4cdf94_68494727', 'product_price_and_shipping', $this->tplIndex);
?>

                    </div>
                    <div class="highlighted-details">
                        <a  href="<?php echo $_smarty_tpl->tpl_vars['product']->value['url'];?>
" class="btn btn-outline">View more</a>
                    </div> 
                    </article>
                </div>
            <?php
}
}
/* {/block 'product_miniature_item'} */
}
