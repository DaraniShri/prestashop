<?php
/* Smarty version 3.1.47, created on 2023-07-11 14:02:06
  from 'C:\xampp\htdocs\shop\themes\classic\templates\_partials\helpers.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64ad138662a6d6_55595106',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bd00a367f0171b0c67f01f7ea7d31b9c67f7e316' => 
    array (
      0 => 'C:\\xampp\\htdocs\\shop\\themes\\classic\\templates\\_partials\\helpers.tpl',
      1 => 1688971969,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64ad138662a6d6_55595106 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
  'renderLogo' => 
  array (
    'compiled_filepath' => 'C:\\xampp\\htdocs\\shop\\var\\cache\\prod\\smarty\\compile\\my_child_themelayouts_layout_full_width_tpl\\bd\\00\\a3\\bd00a367f0171b0c67f01f7ea7d31b9c67f7e316_2.file.helpers.tpl.php',
    'uid' => 'bd00a367f0171b0c67f01f7ea7d31b9c67f7e316',
    'call_name' => 'smarty_template_function_renderLogo_72851538864ad1386623ba5_64241022',
  ),
));
?> 

<?php }
/* smarty_template_function_renderLogo_72851538864ad1386623ba5_64241022 */
if (!function_exists('smarty_template_function_renderLogo_72851538864ad1386623ba5_64241022')) {
function smarty_template_function_renderLogo_72851538864ad1386623ba5_64241022(Smarty_Internal_Template $_smarty_tpl,$params) {
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}
?>

  <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['pages']['index'], ENT_QUOTES, 'UTF-8');?>
">
    <img
      class="logo img-fluid"
      src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['src'], ENT_QUOTES, 'UTF-8');?>
"
      alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');?>
"
      width="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['width'], ENT_QUOTES, 'UTF-8');?>
"
      height="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['height'], ENT_QUOTES, 'UTF-8');?>
">
  </a>
<?php
}}
/*/ smarty_template_function_renderLogo_72851538864ad1386623ba5_64241022 */
}
