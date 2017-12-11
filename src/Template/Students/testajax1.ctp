<script>
  $(document).ready(function(){

    $("#place").click(function(event){
      $("#place").load('/students/jax', function(){
        alert("load successful");
      });
    });

  });

</script>
<div id="place">pepito</div>
