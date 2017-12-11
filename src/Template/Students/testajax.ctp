<?php
    use Cake\Routing\Router; 
?>
<div>
    <p>Click the button to trigger a function that will output "Hello World" in a p element with id="demo".</p>
<button onclick="updateResult()">Click me</button>
</div>

<script>
    var tab = new Array();
    function updateResult(){
            $.ajax({
                type:"POST",
                url:"<?php echo Router::url(array('controller'=>'Students','action'=>'viewresult')); ?>",
                dataType: 'text',
                async:false,
                success: function(tab){
                    alert('success');
                },
                error: function (tab) {
                    alert('error');
                }
            });
    }
</script>