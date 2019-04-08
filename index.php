<!--

Vera Mankongvanichkul
4/7/2019
http://vmankongvanichkul.greenriverdev.com/IT328/cupcakes/index.php

Web page for cupcake fundraiser takes cupcake orders, prints errors or
the successful order, then gives the total for the order.

-->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Cupcake Fundraiser Order Form</title>
</head>
<body>

<div class="container p-5 col-4 mt-4 shadow-lg ">

    <h1>Cupcake Fundraiser</h1>

    <!--cupcake form-->
    <form action="index.php" method="post">

        <!--name-->
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Please enter your name."
                   value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>">
        </div>

        <!--flavor checkboxes-->
        <label>Cupcake Flavors:</label>

        <?php

        //create associative array of flavors
        $flavors = array(
            "grasshopper" => "The Grasshopper",
            "maple" => "Whiskey Maple Bacon",
            "carrot" => "Carrot Walnut",
            "caramel" => "Salted Caramel Cupcake",
            "velvet" => "Red Velvet",
            "lemon" => "Lemon Drop"
        );
        
        //create checkboxes for flavors


        foreach($flavors as $name => $flavor) {
            echo '<div class="form-group form-check"><input type="checkbox" name ="flavors[]" id ="'. $name. '" 
                class="form-check-input" value="'. $name. '"';
            if(isset($_POST['flavors']) && in_array($name, $_POST['flavors'])) {
                echo ' checked';
            }
            echo '>';
            echo '<label for="'. $name . '" class="form-check-label">'. $flavor . '</label></div>';
        }
        ?>

        <!--submit button-->
        <button type="submit" class="btn btn-primary">Order</button>

    </form>
</div>

<?php //php form validation

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = [];

    //check for name
    if (empty($_POST['name'])) {
        $errors[] = 'Please enter your name for the order.';
    }

    //check for at least one flavor selected
    if (!isset($_POST['flavors'])) {
        $errors[] = 'Please select at least one flavor of cupcake.';
    }

    //check if selected flavors are valid
    if (!isset($_POST['flavors'])){
        foreach ($_POST['flavors'] as $value) {
            if (!array_key_exists($value, $flavors)) {
                $errors[] = "Sorry, $value does not exist.";
            }
        }
    }

    //process order
    if (empty($errors)) { //if order is successful
        echo '<div class="container p-5 col-4 my-2 shadow-lg "><p>Thank you for your order '.$_POST['name'].'!<br>';
        //list each flavor selected
        echo 'Order Summary:<br><ul>';
        foreach ($_POST['flavors'] as $flavor) {
            echo "<li> $flavors[$flavor] </li>";
        }
        echo '</ul>';
        //calculate order total
        echo 'Order Total: $' . number_format((count($_POST['flavors']) * 3.50), 2) . '</p></div>';
        exit();

    } else {
        //print errors
        echo '<div class="container p-5 col-4 my-2 shadow-lg"><p>There were problems with your order:<br></p>';
        foreach ($errors as $error) {
            echo "* $error<br>";
        }
        echo '<br><p>Please try again.</p></div>';
    }
}

?>


<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>