<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="<?= base_url(); ?>css/normalize.css">
        <link rel="stylesheet" href="<?= base_url(); ?>css/admin.css">
        <link rel="stylesheet" href="<?= base_url(); ?>css/jquery-ui.min.css">

        
        <script src="<?= base_url(); ?>js/vendor/modernizr.min.js"></script>

        <script src="<?= base_url(); ?>js/vendor/jquery.min.js"></script>
        <script src="<?= base_url(); ?>js/vendor/jquery-ui.min.js"></script>
         <script src="<?= base_url(); ?>js/vendor/underscore-min.js"></script>
        <script src="<?= base_url(); ?>js/vendor/tinymce/tinymce.min.js"></script>

        
     
        <script src="<?= base_url(); ?>js/plugins.js"></script>
        <script src="<?= base_url(); ?>js/main.js"></script>

    </head>
    <body>
        <div id="topBar">
            <div class="floatRight enlaceBlanco marginRight_01"> desconectar </div>
        </div>

        <section id="main" class="bordeGris layoutContainer caja backgroundBlanco bordesRedondeados10">

                <?= $sidebar; ?>

                <article id="developArea" class="inlineBlock">
                    
                    <nav id="breadCrumb" class="bordeGrisBottom fuente08 padding-02"><?= $breadcrumb; ?></nav>
                    
                    <h3 class="azul_0777eb"><?= $titular; ?></h3>
            


