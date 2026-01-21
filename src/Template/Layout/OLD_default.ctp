<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'San Gabriel Arcángel';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate" />
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['jquery-ui.min', 'bootstrap.min', 'style2', 'csga.css?ver='.time(), '/webroot/js_csga/main-style.css?ver='.time() ]) ?>

    <?= $this->Html->script(['jquery-3.1.1.min', 'jquery-ui.min', 'bootstrap.min', 'jquery.redirect', 'jquery.numeric.min', 'jquery.table2excel.min', 'signature_pad.umd.min', 'csga.js?ver='.time(), 'xlsx.full.min' ]) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body style="padding-top: 50px;" onafterprint="imprimir()">
    <?= $this->element('menu') ?>

    <?= $this->Flash->render() ?>
    <div class="container">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
        <div id="alertaSatisfactorio" class="row noVerEnPantalla noVerImpreso">
            <div class="col-xs-12 col-sm-12 col-md-12 alert alert-success alert-dismissible" style="position: fixed; bottom: 0; text-align: center;">
                <a href="#" class="alertasGenerales close" data-dismiss="success" aria-label="close">&times;</a>
                <span id="mensajeAlertaSatisfactorio"></span>
            </div>
        </div>
        <div id="alertaAdvertencia" class="row noVerEnPantalla noVerImpreso">
            <div class="col-xs-12 col-sm-12 col-md-12 alert alert-warning alert-dismissible" style="position: fixed; bottom: 0; text-align: center;">
                <a href="#" class="alertasGenerales close" data-dismiss="warning" aria-label="close">&times;</a>
                <span id="mensajeAlertaAdvertencia"></span>
            </div>
        </div>
        <div id="alertaPeligro" class="row noVerEnPantalla noVerImpreso">
            <div class="col-xs-12 col-sm-12 col-md-12 alert alert-danger alert-dismissible" style="position: fixed; bottom: 0; text-align: center;">
                <a href="#" class="alertasGenerales close" data-dismiss="danger" aria-label="close">&times;</a>
                <span id="mensajeAlertaPeligro"></span>
            </div>
        </div>
    </footer>
</body>
<?= $this->Html->script('/webroot/js_csga/main-script.js?ver='.time()) ?>
</html>