<form action="" class="quotation" data-quotation-uuid="<?php echo !empty($_GET['uuid'])?$_GET['uuid']:NULL; ?>">

<?php

get_template_part('pages/quotations/form/select', 'project');

get_template_part('pages/quotations/form/table');

?>


</form>