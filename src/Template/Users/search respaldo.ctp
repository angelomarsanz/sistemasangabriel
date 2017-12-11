<?php
use Cake\Routing\Router;
use Cake\View\Helper\UrlHelper;

  echo $this->Html->script('//code.jquery.com/jquery-1.10.2.js');
  echo $this->Html->script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
  echo $this->Html->css('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');

  echo $this->Form->create('Users');
  echo $this->Form->input('user_id', ['type' => 'text']);
  echo $this->Form->end();

?>

<script>
    jQuery('#user-id').autocomplete({
        source:'<?php echo Router::url(array("controller" => "Users", "action" => "search")); ?>',
        minLength: 3
    });
</script>