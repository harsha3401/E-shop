<?php

session_start();
require "connection.php";

if (isset($_SESSION["u"])) {
    if (isset($_GET["id"])) {

        $email = $_SESSION["u"]["email"];
        $pid = $_GET["id"];

        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id`='" . $pid . "' AND `user_email`='" . $email . "' ");
        $cart_num = $cart_rs->num_rows;

        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "'");
        $product_data = $product_rs->fetch_assoc();
        $product_qty = $product_data["qty"];

        if ($cart_num == 1) {

            $cart_data = $cart_rs->fetch_assoc();
            $current_qty = $cart_data["qty"];
            $new_qty = (int)$current_qty + 1;

            if ($product_qty >= $new_qty) {

                Database::iud("UPDATE `cart` SET `qty`='" . $new_qty . "' WHERE `product_id`='" . $pid . "' AND `user_email`='" . $email . "' ");

                $ca_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email . "' ");
                $ca_num = $ca_rs->num_rows;
?>

                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>A new item has been added to your <b>Shopping Cart</b>. You have now <b><?php echo ($ca_num); ?></b> items in your Shopping Cart.</span>
                        </div>
                        <div class="modal-footer">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-5 d-grid">
                                        <a href="cart.php" class="btn btn-danger fs-6">View Shopping Cart</a>
                                    </div>
                                    <div class="col-5 d-grid">
                                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close" onclick="cartNum(<?php $ca_num ?>);">Continue Shopping</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php

            } else {
                echo ("Invalid quantity");
            }
        } else {

            Database::iud("INSERT INTO `cart`(`product_id`,`user_email`,`qty`) VALUES ('" . $pid . "','" . $email . "','1') ");

            $c_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email . "' ");
            $c_num = $c_rs->num_rows;
            ?>

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span>A new item has been added to your <b>Shopping Cart</b>. You have now <b><?php echo ($c_num); ?></b> items in your Shopping Cart.</span>
                    </div>
                    <div class="modal-footer">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-5 d-grid">
                                    <a href="cart.php" class="btn btn-danger fs-6">View Shopping Cart</a>
                                </div>
                                <div class="col-5 d-grid">
                                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close" onclick="cartNum(<?php $c_num ?>);">Continue Shopping</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php

        }
    } else {
        echo ("Something went wrong");
    }
} else {
    echo ("Please Sign In or Register.");
}

?>