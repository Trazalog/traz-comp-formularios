
<div id="ban">
</div>

<button class="btn btn-primary" onclick="A()">A</button>
<button class="btn btn-primary" onclick="B()">B</button>
<button class="btn btn-primary" onclick="C()">C</button>

<script>
    function A() {
        $.ajax({
                type:'GET',
                url:'index.php/Test/A',
                success:function(rsp){
                    $('#ban').html(rsp);
                },
                error: function(rsp){  
                    alert('Error: '+ rsp.msj);
                    console.log(rsp.msj);
                }
            });
    }
    function B() {
        $.ajax({
                type:'GET',
                url:'index.php/Test/B',
                success:function(rsp){
                    $('#ban').html(rsp);
                },
                error: function(rsp){  
                    alert('Error: '+ rsp.msj);
                    console.log(rsp.msj);
                }
            });
    }
    function C() {
        $.ajax({
                type:'GET',
                url:'index.php/Test/C',
                success:function(rsp){
                    $('#ban').html(rsp);
                },
                error: function(rsp){  
                    alert('Error: '+ rsp.msj);
                    console.log(rsp.msj);
                }
            });
    }
</script>