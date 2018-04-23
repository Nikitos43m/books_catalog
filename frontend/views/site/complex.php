<?php
use yii\helpers\Html;
?>


<section class="complex-page">
    <div class="container" >
        <div class="text-center">
            <h2 class="main-complex view">Жилые комплексы Вашего города</h2>
            
            <?php
                $session = Yii::$app->session;
                $session->open();
            
                $fimg="";
                $path = 'uploads/city-'.$session['my_city'];
                if(is_dir ($path)){
                    $images = scandir($path);
                }else{
                    $images = null;
                }
               
            ?>
            
              <?php if ($images != null): ?>
            
             <? else: ?>
             <div class="row">
                <h4>Пока по данному разделу информация отсутствует.</h4>
             </div>
             <div class="row">
                 
             </div>
              <? endif;?>
            
        </div>
    </div>
</section>