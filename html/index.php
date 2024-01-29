<?php

error_reporting(E_ALL);

if (isset($_GET['source'])) {
    highlight_file(__FILE__);
    die();
}

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Calculation\Calculation;

?>
<html>
<head>
    <link href="css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN">
    <script src="js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"></script>
    <style>
        body {
            background-color: #68adf1;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card bg-light mb-3 mt-3" style="border-radius: 15px;">
                <div class="card-body">
                    <h5 class="card-title">Quadratic Equation Solver</h5>
                    <p>Enter the coefficients for the Ax<sup>2</sup> + Bx + C = 0</p>

                    <?php if (isset($error)){
                       echo "<div class='alert alert-danger' role='alert'>$error</div>";
                    }?>

                    <form method="POST">

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="labelA">A</span>
                            <input type="text" class="form-control" name="A" aria-describedby="labelA" aria-label="A"
                                   value="<?php echo (isset($_POST['A'])) ? htmlentities($_POST['A']) : ''; ?>">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="labelB">B</span>
                            <input type="text" class="form-control" name="B" aria-describedby="labelB" aria-label="B"
                                   value="<?php echo (isset($_POST['B'])) ? htmlentities($_POST['B']) : ''; ?>">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="labelC">C</span>
                            <input type="text" class="form-control" name="C" aria-describedby="labelC" aria-label="C"
                                   value="<?php echo (isset($_POST['C'])) ? htmlentities($_POST['C']) : ''; ?>">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a class="btn btn-light" href="/?source" role="button">View Source</a>
                            <button name="submit" type="submit" class="btn btn-primary">Calculate</button>
                        </div>

<?php
if (isset($_POST['submit'])) {
    if (empty($_POST['A']) || empty($_POST['B']) || empty($_POST['C'])) {
        echo "<div class='alert alert-danger mt-3' role='alert'>Error: Missing vars...</div>";
    }
    elseif ($_POST['A'] == 0) {
        echo "<div class='alert alert-danger mt-3' role='alert'>Error: The equation is not quadratic</div>";
    } else {
        // Calculate and Display the results
        echo "<div class='alert alert-info mt-3' role='alert'>";
        echo '<b>Roots:</b><br>';

        $discriminantFormula = '=POWER(' . $_POST['B'] . ',2) - (4 * ' . $_POST['A'] . ' * ' . $_POST['C'] . ')';

        $discriminant = Calculation::getInstance()->calculateFormula($discriminantFormula);

        $r1Formula = '=IMDIV(IMSUM(-' . $_POST['B'] . ',IMSQRT(' . $discriminant . ')),2 * ' . $_POST['A'] . ')';
        $r2Formula = '=IF(' . $discriminant . '=0,"Only one root",IMDIV(IMSUB(-' . $_POST['B'] . ',IMSQRT(' . $discriminant . ')),2 * ' . $_POST['A'] . '))';

        echo Calculation::getInstance()->calculateFormula($r1Formula);
        echo Calculation::getInstance()->calculateFormula($r2Formula);
        echo "</div>";
    }
}
?>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>