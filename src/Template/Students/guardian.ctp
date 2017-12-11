<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Pago de Inscripción y/o mensualidades</h2>
        </div>
        <?= $this->Form->create($student) ?>
            <fieldset>
                <?php
                    echo $this->Form->input('parentsandguardian_id', ['type' => 'text', 'label' => 'Familia']);                
                ?>
            </fieldset>
            <?= $this->Form->button(__('Facturar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
</div>
<script>
    $('#parentsandguardian-id').autocomplete({
        source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?>',
        minLength: 3
    });
</script>