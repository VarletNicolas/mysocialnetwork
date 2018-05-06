<?php require APPROOT . '/views/inc/header.php';?>
<div class="form-group">
    <?php
    //var_dump($data['messages']);
        foreach($data['messages'] as $arr):
            echo $arr->send_at.' Message: '.$arr->message; //close your tags!!
        endforeach;
    ?>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>