<div class="box">
    <div class="box-body">
        <table class="table-striped table-hover table">
            <tbody>
                <?php 
                foreach ($list as $key => $o) {
                        echo "<tr>";
                        echo "<td>$o->nombre</td>";
                        echo "<td>$o->fecha</td>";
                        echo "<td><button class='btn btn-primary frm-open' data-info='$o->info_id'><i class='fa fa-paperclip'></i></button></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
detectarForm()
</script>