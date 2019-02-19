<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>HIS Theptarin Patient Data From AS400</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>ทะเบียนข้อมูลผู้รับบริการโรงพยาบาลเทพธารินทร์ (JsonRPC)</h1>
            </div>
            <?php echo isset($grid_html) ? $grid_html : ''; ?>
            <br />
        </div>
    </body>
</html>
