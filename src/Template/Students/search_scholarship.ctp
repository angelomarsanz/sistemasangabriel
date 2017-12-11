<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Becar alumno</h2>
        </div>
        <?= $this->Form->create() ?>
            <fieldset>
                <?php
                    echo $this->Form->input('parentsandguardian_id', ['type' => 'text', 'label' => 'Familia']);                
                ?>
            </fieldset>
        <?= $this->Form->end() ?>
</div>
<script>
    function toShow(id) 
    {
        $.redirect('../students/enableScholarship', { idParent : id }); 
    }
    $('#parentsandguardian-id').autocomplete({
        source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?>',
        minLength: 3,
        select: function( event, ui ) {
            toShow(ui.item.id);
          }
    });
</script>