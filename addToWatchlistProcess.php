<?php

session_start();
require "connection.php";

if (isset($_SESSION["u"])) {
    if (isset($_GET["id"])) {

        $email = $_SESSION["u"]["email"];
        $pid = $_GET["id"];

        $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `product_id`='" . $pid . "' AND 
        `user_email`='" . $email . "'");
        $watchlist_num = $watchlist_rs->num_rows;

        if ($watchlist_num == 1) {

            $watchlist_data = $watchlist_rs->fetch_assoc();
            $list_id = $watchlist_data["id"];

            Database::iud("DELETE FROM `watchlist` WHERE `id`='" . $list_id . "'");
            echo ("removed");
        } else {
            Database::iud("INSERT INTO `watchlist`(`product_id`,`user_email`) VALUES ('" . $pid . "','" . $email . "')");

            $w_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $email . "' ");
            $w_num = $w_rs->num_rows;
?>

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="refresh();"></button>
                    </div>
                    <div class="modal-body">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span>Added to <b>Watchlist</b>. You have now <b><?php echo ($w_num); ?></b> items in your Watchlist.</span>
                    </div>
                    <div class="modal-footer">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-5 d-grid">
                                    <a href="watchlist.php" class="btn btn-danger fs-6">View Watchlist</a>
                                </div>
                                <div class="col-5 d-grid">
                                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close" onclick="refresh();">Continue Shopping</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php

        }
    } else {
        echo ("Something Went Wrong");
    }
} else {
    echo ("Please Login First");
}

?>