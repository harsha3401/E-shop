function changeView() {

    var signUpBox = document.getElementById("signUpBox");
    var signInBox = document.getElementById("signInBox");

    signUpBox.classList.toggle("d-none");
    signInBox.classList.toggle("d-none");
}

function signUp() {
    var f = document.getElementById("f");
    var l = document.getElementById("l");
    var e = document.getElementById("e");
    var p = document.getElementById("p");
    var m = document.getElementById("m");
    var g = document.getElementById("g");

    var form = new FormData();

    form.append("f", f.value);
    form.append("l", l.value);
    form.append("e", e.value);
    form.append("p", p.value);
    form.append("m", m.value);
    form.append("g", g.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                changeView();
            } else {
                document.getElementById("msg").innerHTML = text;
                document.getElementById("msgdiv").className = "d-block";
            }

        }
    }

    request.open("POST", "signUpProcess.php", true);
    request.send(form);

}


function signIn() {
    var email = document.getElementById("email2");
    var password = document.getElementById("password2");
    var rememberme = document.getElementById("rememberme");

    var f = new FormData();
    f.append("e", email.value);
    f.append("p", password.value);
    f.append("r", rememberme.checked);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;

            if (text == "Success") {
                window.location = "home.php";
            } else {
                document.getElementById("msg2").innerHTML = text;
            }


        }
    }

    request.open("POST", "signInProcess.php", true);
    request.send(f);

}

var bm;
function forgotPassword() {

    var email = document.getElementById("email2");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                alert("Verification code has sent to your email. Please check your inbox");
                var m = document.getElementById("forgotPasswordModal");
                bm = new bootstrap.Modal(m);
                bm.show();
            } else {
                alert(text);
            }
        }
    }
    

    request.open("GET", "forgotPasswordProcess.php?e=" + email.value, true);
    request.send();

}


function showPassword() {

    var i = document.getElementById("npi");
    var eye = document.getElementById("e1");

    if (i.type == "password") {
        i.type = "text";
        eye.className = "bi bi-eye-fill";
    } else {
        i.type = "password";
        eye.className = "bi bi-eye-slash-fill";
    }

}

function reTypePasswordShow() {
    var i = document.getElementById("rtpi");
    var eye = document.getElementById("e2");

    if (i.type == "password") {
        i.type = "text";
        eye.className = "bi bi-eye-fill";
    } else {
        i.type = "password";
        eye.className = "bi bi-eye-slash-fill";
    }
}

function resetpw() {

    var email = document.getElementById("email2");
    var np = document.getElementById("npi");
    var rtp = document.getElementById("rtpi");
    var vcode = document.getElementById("vc");

    var form = new FormData();
    form.append("e", email.value);
    form.append("p", np.value);
    form.append("r", rtp.value);
    form.append("v", vcode.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;

            if (text == "Success") {

                bm.hide();
                alert("Password reset Success.");

            } else {
                alert(text);
            }

        }
    }

    request.open("POST", "resetPassword.php", true);
    request.send(form);

}


function signout() {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;

            if (text = "Success") {

                window.location.reload();
            } else {
                alert(text);
            }

        }
    }

    request.open("GET", "signoutProcess.php", true);
    request.send();

}


function changeImage() {

    var view = document.getElementById("viewImg");
    var file = document.getElementById("profileimg");

    file.onchange = function () {
        var file1 = this.files[0];
        var url = window.URL.createObjectURL(file1);

        view.src = url;
    }

}

function updateProfile() {

    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var mobile = document.getElementById("mobile");
    var line1 = document.getElementById("line1");
    var line2 = document.getElementById("line2");
    var province = document.getElementById("province");
    var district = document.getElementById("district");
    var city = document.getElementById("city");
    var pcode = document.getElementById("pcode");
    var image = document.getElementById("profileimg");

    var form = new FormData();
    form.append("fn", fname.value);
    form.append("ln", lname.value);
    form.append("m", mobile.value);
    form.append("l1", line1.value);
    form.append("l2", line2.value);
    form.append("p", province.value);
    form.append("d", district.value);
    form.append("c", city.value);
    form.append("pc", pcode.value);

    if (image.files.length == 0) {

        var confirmation = confirm("Are you sure You don't want to update Profile Image?");

        if (confirmation) {
            alert("You have not selected any image ");
        }

    } else {
        form.append("image", image.files[0]);
    }

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;


            if (text == "Success") {
                window.location = "home.php";
            } else {
                alert(text);
            }

        }
    }

    request.open("POST", "updateProfileProcess.php", true);
    request.send(form);

}

function changeProductImage() {
    var image = document.getElementById("imageuploader");

    image.onchange = function () {

        var file_count = image.files.length;

        if (file_count <= 3) {

            for (var x = 0; x < file_count; x++) {
                var file = this.files[x];
                var url = window.URL.createObjectURL(file);

                document.getElementById("i" + x).src = url;
            }

        } else {
            alert("Please select 3 or less than 3 images.");
        }

    }
}

function addProduct() {
    var category = document.getElementById("category");
    var brand = document.getElementById("brand");
    var model = document.getElementById("model");
    var title = document.getElementById("title");

    var condition = 0;
    if (document.getElementById("b").checked) {
        condition = 1;
    } else if (document.getElementById("u").checked) {
        condition = 2;
    }

    var colour = document.getElementById("clr");
    var colour_input = document.getElementById("clr_in");
    var qty = document.getElementById("qty");
    var cost = document.getElementById("cost");
    var dwc = document.getElementById("dwc");
    var doc = document.getElementById("doc");
    var desc = document.getElementById("desc");
    var image = document.getElementById("imageuploader");

    var f = new FormData();
    f.append("ca", category.value);
    f.append("b", brand.value);
    f.append("m", model.value);
    f.append("t", title.value);
    f.append("con", condition);
    f.append("col", colour.value);
    f.append("col_in", colour_input.value);
    f.append("qty", qty.value);
    f.append("cost", cost.value);
    f.append("dwc", dwc.value);
    f.append("doc", doc.value);
    f.append("desc", desc.value);

    var file_count = image.files.length;

    for (var x = 0; x < file_count; x++) {
        f.append("image" + x, image.files[x]);
    }

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;

            if (text == "Product image saved successfully") {
                window.location.reload();
            } else {
                alert(text);

            }

        }
    }

    request.open("POST", "addProductProcess.php", true);
    request.send(f);

}

function load_brand() {

    var category = document.getElementById("category").value;
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;

            document.getElementById("brand").innerHTML = text;
        }
    }

    request.open("GET", "loadBrand.php?c=" + category, true);
    request.send();

}


function changeStatus(id) {

    var Product_id = id;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;

            if (text == "Deactivated") {

                alert("Product Deactivated");
                window.location.reload();

            } else if (text == "Activated") {

                alert("Product Activated");
                window.location.reload();

            } else {
                alert(text);
            }

        }
    }

    request.open("GET", "changeStatusProcess.php?p=" + Product_id, true);
    request.send();
}


function sort1(x) {

    var search = document.getElementById("s");

    var time = "0";

    if (document.getElementById("n").checked) {
        time = "1";
    } else if (document.getElementById("o").checked) {
        time = "2";
    }

    var qty = "0";

    if (document.getElementById("h").checked) {
        qty = "1";
    } else if (document.getElementById("l").checked) {
        qty = "2";
    }

    var condition = "0";

    if (document.getElementById("b").checked) {
        condition = "1";
    } else if (document.getElementById("u").checked) {
        condition = "2";
    }

    var form = new FormData();
    form.append("s", search.value);
    form.append("t", time);
    form.append("q", qty);
    form.append("c", condition);
    form.append("page", x);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;

            document.getElementById("sort").innerHTML = text;

        }
    }

    request.open("POST", "sortProcess.php", true);
    request.send(form);

}

function clearSort() {
    window.location.reload();
}

function sendId(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                window.location = "updateProduct.php";
            } else {
                alert(text);
            }
        }
    }

    request.open("GET", "sendProductIdProcess.php?id=" + id, true);
    request.send();

}

function updateProduct() {
    var title = document.getElementById("t");
    var qty = document.getElementById("qty");
    var delivery_cost_within_colombo = document.getElementById("dwc");
    var delivery_cost_out_of_colombo = document.getElementById("doc");
    var description = document.getElementById("desc");
    var images = document.getElementById("imageuploader");

    var form = new FormData();
    form.append("t", title.value);
    form.append("qty", qty.value);
    form.append("dwc", delivery_cost_within_colombo.value);
    form.append("doc", delivery_cost_out_of_colombo.value);
    form.append("desc", description.value);

    var image_count = images.files.length;

    for (var x = 0; x < image_count; x++) {
        form.append("i" + x, images.files[x]);
    }

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                window.location = "myProducts.php";
            } else {
                alert(text);
            }
        }
    }

    request.open("POST", "updateProcess.php", true);
    request.send(form);

}

function basicSearch(x) {

    var txt = document.getElementById("basic_search_txt");
    var select = document.getElementById("basic_search_select");

    var form = new FormData();
    form.append("t", txt.value);
    form.append("s", select.value);
    form.append("page", x);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            document.getElementById("basicSearchResult").innerHTML = text;
        }
    }

    request.open("POST", "basicSearchProcess.php", true);
    request.send(form);

}

function advancedSearch(x) {
    var txt = document.getElementById("t");
    var category = document.getElementById("c");
    var brand = document.getElementById("b");
    var model = document.getElementById("m");
    var condition = document.getElementById("co");
    var color = document.getElementById("clr");
    var price_from = document.getElementById("pf");
    var price_to = document.getElementById("pt");
    var sort = document.getElementById("s");

    var form = new FormData();
    form.append("t", txt.value);
    form.append("c", category.value);
    form.append("b", brand.value);
    form.append("m", model.value);
    form.append("co", condition.value);
    form.append("clr", color.value);
    form.append("pf", price_from.value);
    form.append("pt", price_to.value);
    form.append("s", sort.value);
    form.append("page", x);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            document.getElementById("view_area").innerHTML = text;
        }
    }

    request.open("POST", "advancedSearchProcess.php", true);
    request.send(form);
}

function loadMainImg(id) {
    var img = document.getElementById("productImg" + id).src;
    var main = document.getElementById("main-img");

    main.src = img;
}

function checkValue(qty) {
    var input = document.getElementById("qty_input");

    if (input.value <= 0) {
        alert("Quantity must be 1 or more");
        input.value = 1;
    } else if (input.value > qty) {
        alert("Maximum quantity achieved");
        input.value = qty;
    }
}

function qty_inc(qty) {
    var input = document.getElementById("qty_input");
    if (input.value < qty) {
        var newValue = parseInt(input.value) + 1;
        input.value = newValue.toString();
    } else {
        alert("Maximum quantity has achieved");
        input.value = qty;
    }
}

function qty_dec() {
    var input = document.getElementById("qty_input");
    if (input.value > 1) {
        var newValue = parseInt(input.value) - 1;
        input.value = newValue.toString();
    } else {
        alert("Minimum quantity has achieved");
        input.value = 1;
    }
}

var wm;
function addToWatchlist(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "removed") {
                document.getElementById("heart" + id).style.className = "text-dark";
                window.location.reload();
            } else {
                document.getElementById("heart" + id).style.className = "text-danger";

                document.getElementById("viewWatchlist").innerHTML = text;

                var vieWatchlistModel = document.getElementById("viewWatchlist");
                wm = new bootstrap.Modal(vieWatchlistModel);
                wm.show();
            }
        }
    }

    request.open("GET", "addToWatchlistProcess.php?id=" + id, true);
    request.send();
}

function refresh() {
    window.location.reload();
}

function watchlistSearch() {
    var txt = document.getElementById("text").value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "no") {
                window.location.reload();
            } else {
                document.getElementById("view").innerHTML = text;
            }

        }
    }

    request.open("GET", "watchlistSearchProcess.php?t=" + txt, true);
    request.send();
}

function removeFromWatchlist(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                window.location.reload();
            } else {
                alert(text);
            }

        }
    }

    request.open("GET", "removeWatchlistProcess.php?id=" + id, true);
    request.send();

}

var cm;
function addToCart(id) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;

            document.getElementById("viewCart").innerHTML = text;

            var viewCartModel = document.getElementById("viewCart");
            cm = new bootstrap.Modal(viewCartModel);
            cm.show();
        }
    }

    request.open("GET", "addToCartProcess.php?id=" + id, true);
    request.send();
}

// function cartNum(x) {
//     var request = new XMLHttpRequest();

//     request.onreadystatechange = function () {
//         if (request.readyState == 4) {
//             var text = request.responseText;

//             document.getElementById("products").innerHTML = text;
//         }
//     }

//     request.open("GET", "cartNum.php?ca_num=" + x, true);
//     request.send();
// }

function cartSearch() {
    var txt = document.getElementById("search").value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "no") {
                window.location.reload();
            } else {
                document.getElementById("view").innerHTML = text;
            }

        }
    }

    request.open("GET", "cartSearchProcess.php?t=" + txt, true);
    request.send();
}

function deleteFromCart(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                alert("Product removed from cart");
                window.location.reload();
            } else {
                alert(text);
            }

        }
    }

    request.open("GET", "deleteFromCartProcess.php?id=" + id, true);
    request.send();
}

function viewMessages(email) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;

            document.getElementById("chat_box").innerHTML = text;
        }
    }

    request.open("GET", "viewMessagesProcess.php?e=" + email, true);
    request.send();

}

function send_msg() {
    var email = document.getElementById("rmail");
    var txt = document.getElementById("msg_txt");

    var form = new FormData();
    form.append("e", email.innerHTML);
    form.append("t", txt.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                window.location.reload();
            } else {
                alert(text);
            }

        }
    }

    request.open("POST", "sendMsgProcess.php", true);
    request.send(form);
}

function payNow(id) {

    var qty = document.getElementById("qty_input").value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            var obj = JSON.parse(text);

            var mail = obj["mail"];
            var amount = obj["amount"];

            if (text == "1") {
                swal("Good job!", "You clicked the button!", "success");
                // window.location = "index.php";
            } else if (text == "2") {
                wal("Good job!", "You clicked the button!", "success");
                window.location = "userProfile.php";
            } else {

                // Payment completed. It can be a successful failure.
                payhere.onCompleted = function onCompleted(orderId) {

                    console.log("Payment completed. OrderID:" + orderId);

                    saveInvoice(orderId, id, mail, amount, qty);
                    // Note: validate the payment and show success or failure page to the customer
                };

                // Payment window closed
                payhere.onDismissed = function onDismissed() {
                    // Note: Prompt user to pay again or show an error page
                    console.log("Payment dismissed");
                };

                // Error occurred
                payhere.onError = function onError(error) {
                    // Note: show an error page
                    console.log("Error:" + error);
                };

                // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": "1222542",    // Replace your Merchant ID
                    merchant_secret:
            "MzY0MjIzOTkxOTEwMDc0ODY1NTI2NjgxNjMxNjEyNzg3MDU4MDI4", // Replace your Mechant secret
                    "return_url": "http://localhost/eshop/singleProductView.php?id" + id,     // Important
                    "cancel_url": "http://localhost/eshop/singleProductView.php?id" + id,     // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": obj["id"],
                    "items": obj["item"],
                    "amount": amount + ".00",
                    "currency": "LKR",
                    hash: obj["hash"],
                    "first_name": obj["fname"],
                    "last_name": obj["lname"],
                    "email": mail,
                    "phone": obj["mobile"],
                    "address": obj["address"],
                    "city": obj["city"],
                    "country": "Sri Lanka",
                    "delivery_address": obj["address"],
                    "delivery_city": obj["city"],
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": ""
                };

                // Show the payhere.js popup, when "PayHere Pay" is clicked
                // document.getElementById('payhere-payment').onclick = function (e) {
                payhere.startPayment(payment);
                // };

            }

        }
    }

    request.open("GET", "buyNowProcess.php?id=" + id + "&qty=" + qty, true);
    request.send();
}

function saveInvoice(orderId, id, mail, amount, qty) {

    var form = new FormData();
    form.append("o", orderId);
    form.append("i", id);
    form.append("m", mail);
    form.append("a", amount);
    form.append("q", qty);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "1") {
                window.location = "invoice.php?id=" + orderId;
            } else {
                alert(text);
            }
        }
    }

    request.open("POST", "saveInvoice.php", true);
    request.send(form);

}

function printInvoice() {
    var body = document.body.innerHTML;
    var page = document.getElementById("page").innerHTML;
    document.body.innerHTML = page;
    window.print();
    document.body.innerHTML = body;
}

var m;
function addFeedback(id) {

    var feedbackModal = document.getElementById("feedbackModal" + id);
    m = new bootstrap.Modal(feedbackModal);
    m.show();
}

function saveFeedback(id) {
    var type;
    if (document.getElementById("type1").checked == true) {
        type = 1;
    } else if (document.getElementById("type2").checked == true) {
        type = 2;
    } else if (document.getElementById("type3").checked == true) {
        type = 3;
    }

    var feedback = document.getElementById("feed");

    var form = new FormData();
    form.append("t", type);
    form.append("p", id);
    form.append("f", feedback.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text = "1") {
                m.hide();
            } else {
                alert(text);
            }
        }
    }

    request.open("POST", "saveFeedbackProcess.php", true);
    request.send(form);
}

function deleteProduct(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                window.location.reload();
            } else {
                alert(text)
            }
        }
    }

    request.open("GET", "deletePurchaseHistory.php?id=" + id, true);
    request.send();
}

function deleteAllProduct() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                window.location.reload();
            } else {
                alert(text)
            }
        }
    }

    request.open("GET", "deletePurchaseHistory.php", true);
    request.send();
}

var av;
function adminVerification() {
    var email = document.getElementById("e");

    var form = new FormData;
    form.append("e", email.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                var adminVerificationModal = document.getElementById("verificationModal");
                av = new bootstrap.Modal(adminVerificationModal);
                av.show();
            } else {
                alert(text);
            }
        }
    }

    request.open("POST", "adminVerificationProcess.php", true);
    request.send(form);
}

function verify() {
    var Verification = document.getElementById("vcode");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                av.hide();
                window.location = "adminPanel.php";
            } else {
                alert(text);
            }

        }
    }

    request.open("GET", "verificationprocess.php?v=" + Verification.value, true);
    request.send();
}

function blockUser(email) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "blocked") {
                document.getElementById("ub" + email).innerHTML = "Unblock";
                document.getElementById("ub" + email).classList = "btn btn-success";
            } else if (text == "Unblocked") {
                document.getElementById("ub" + email).innerHTML = "Block";
                document.getElementById("ub" + email).classList = "btn btn-danger";
            } else {
                alert(text);
            }
        }
    }

    request.open("GET", "userBlockProcess.php?email=" + email, true);
    request.send();

}

function blockProduct(pid) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "blocked") {
                document.getElementById("ub" + pid).innerHTML = "Unblock";
                document.getElementById("ub" + pid).classList = "btn btn-success";
            } else if (text == "Unblocked") {
                document.getElementById("ub" + pid).innerHTML = "Block";
                document.getElementById("ub" + pid).classList = "btn btn-danger";
            } else {
                alert(text);
            }
        }
    }

    request.open("GET", "productBlockProcess.php?pid=" + pid, true);
    request.send();
}



var pm;
function viewProductModel(id) {
    var m = document.getElementById("viewProductModel" + id);
    pm = new bootstrap.Modal(m);
    pm.show();
}

var cm;
function addNewCategory() {
    var m = document.getElementById("addCategoryModal");
    cm = new bootstrap.Modal(m);
    cm.show();
}

var vc;
var e;
var n;
function verifyCategory() {
    var ncm = document.getElementById("addCategoryVerificationModal");
    vc = new bootstrap.Modal(ncm);

    e = document.getElementById("e").value;
    n = document.getElementById("n").value;

    var form = new FormData();
    form.append("email", e);
    form.append("name", n);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                cm.hide();
                vc.show();
            } else {
                alert(text);
            }

        }
    }

    request.open("POST", "addNewCategoryProcess.php", true);
    request.send(form);
}

function saveCategory() {
    var txt = document.getElementById("txt").value;

    var form = new FormData();
    form.append("t", txt);
    form.append("e", e);
    form.append("n", n);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Category added Success") {
                vc.hide();
                window.location.reload();
            } else {
                alert(text);
            }

        }
    }

    request.open("POST", "SaveCategoryProcess.php", true);
    request.send(form);

}

function changeInvoiceStatus(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == 1) {
                document.getElementById("btn" + id).innerHTML = "Paccking";
                document.getElementById("btn" + id).classList = "btn btn-warning fw-bold mt-1 mb-1";
            } else if (text == 2) {
                document.getElementById("btn" + id).innerHTML = "Dispatch";
                document.getElementById("btn" + id).classList = "btn btn-info fw-bold mt-1 mb-1";
            } else if (text == 3) {
                document.getElementById("btn" + id).innerHTML = "Shipping";
                document.getElementById("btn" + id).classList = "btn btn-primary fw-bold mt-1 mb-1";
            } else if (text == 4) {
                document.getElementById("btn" + id).innerHTML = "Delivered";
                document.getElementById("btn" + id).classList = "btn btn-danger fw-bold mt-1 mb-1 disabled";
            } else {
                alert(text);
            }

        }
    }

    request.open("GET", "changeInvoiceStatusProcess.php?id=" + id, true);
    request.send();
}

function searchInvoiceId() {
    var txt = document.getElementById("searchtxt").value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            document.getElementById("viewArea").innerHTML = text;
        }
    }

    request.open("GET", "searchInvoiceProcess.php?id=" + txt, true);
    request.send();
}

function findSellings() {
    var from = document.getElementById("from").value;
    var to = document.getElementById("to").value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            document.getElementById("viewArea").innerHTML = text;
        }
    }

    request.open("GET", "findSellingsProcess.php?f=" + from + "&t=" + to, true);
    request.send();
}

var mm;

function viewMsgModel(email) {
    var m = document.getElementById("userMsgModel" + email);
    mm = new bootstrap.Modal(m);
    mm.show();

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;

            document.getElementById("chat-box" + email).innerHTML = text;

        }
    }

    request.open("GET", "adminToSendViewMsgProcess.php?e=" + email, true);
    request.send();
}

var cam;

function contactAdmin(email) {
    var m = document.getElementById("contactAdmin");
    cam = new bootstrap.Modal(m);
    cam.show();

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;

            document.getElementById("chat-box").innerHTML = text;

        }
    }

    request.open("GET", "adminViewMsgProcess.php?e=" + email, true);
    request.send();

}

// setInterval(sendAdminMsg2(),500);
function sendAdminMsg2() {
    var txt = document.getElementById("msgtxt").value;

    var form = new FormData();
    form.append("t", txt);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            alert(text);
        }
    }

    request.open("POST", "sendAdminMessageProcess.php", true);
    request.send(form);
}

function sendAdminMsg1(email) {
    var txt = document.getElementById("msgtxt" + email).value;

    var form = new FormData();
    form.append("t", txt);
    form.append("r", email);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            alert(text);
        }
    }

    request.open("POST", "sendAdminMessageProcess.php", true);
    request.send(form);
}

// function getAdminMsg(email){
//     setInterval(function(){
//         viewMsgModel(email);
//         sendAdminMsg1(email)
//     },500);
    
// }