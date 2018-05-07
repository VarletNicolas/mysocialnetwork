<!-- Par Varlet Nicolas et Duhamel Antoine -->
<?php require APPROOT . '/views/inc/header.php';?>
<div class="form-group">
    <?php
    //var_dump($data['messages']);
    
        foreach($data['messages'] as $arr):
            echo "<div>";
            echo $arr->send_at.' Message: '.$arr->message; //close your tags!!
            echo "</div>";
        endforeach;
    
    ?>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>