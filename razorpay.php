<?php
include "globals/header.php";
// $data = entryformreciept();
// pr($data);
ini_set('display_errors', 1);
$table = "filmincubator_expert_callslots_payment";
require('../razorpay/config.php');
// $keyId = 'rzp_test_JvimU64sGnhGmV';
// $keySecret = 'w467VoMiwdhTv5V75CQv7kkB';
// $displayCurrency = 'INR';
require('../razorpay/razorpay-php/Razorpay.php');
// session_start();
// print_r($_SESSION);
// die();
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
// print_r($_SESSION);
// die();
$api = new Api($keyId, $keySecret);
//$api = new Api('rzp_test_HeOyh0t92Fzihr', 'idPpjY662OBz8jeGqgSFGE69'); // test key
if (!empty($_POST['razorpay_payment_id'])) {
    // print_r($_POST);
    // die();
    $payment_id = $_SESSION['payment_id'] = $_POST['razorpay_payment_id'];
    $payment = $api->payment->fetch($payment_id);
    $amount = $payment->amount;
    $amount = $_SESSION['amount'] = $amount / 100;
    $currency = $payment->currency;
    $organization = $payment->description;
    $card_id = $payment->card_id;
    // print_r($payment->notes);
    $name = $_SESSION['name'] = $payment->notes->name;
    $email = $_SESSION['email'] = $payment->notes->email;
    $mobile = $_SESSION['mobile'] = $payment->notes->mobile;
    $date = $_SESSION['date'] = date('d-m-Y');
    crud("filmincubator_expert_callslots", "u", ["is_booked" => 1], $payment->notes->record_id);
    crud($table, 'c', [
        "expert_id" => $payment->notes->expert_id,
        "user_id" => $payment->notes->user_id,
        "slot_id" => $payment->notes->record_id,
        "amount" => $amount,
        "pay_id" => $payment_id,
    ]);
    // die();
$expertData = crud("filmincubator_expert_registration","ro",null,$payment->notes->expert_id);
    $popup = [
        "bakcolor" => "#d1eaaa",
        "color" => "#88B04B",
        "text" => "Success",
        "textln" => "We received your purchase request we'll be in touch shortly!",
        "sign" => "✓",
    ];
} else {
    $msg = "Transaction cancelled";
    $popup = [
        "bakcolor" => "#f9d1d1",
        "color" => "#e61a1a",
        "text" => "Failed",
        "textln" => "Please Try Again",
        "sign" => "x",
    ];
}
mail($email, "MINIBOXOFFICE", "Thank You for the payment");
?>
<style>
    #customers {
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        color: #000;
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #222222;
        color: #d8b069;
    }

    .img-replace {
        /* replace text with an image */
        display: inline-block;
        overflow: hidden;
        text-indent: 100%;
        color: transparent;
        white-space: nowrap;
    }

    .bts-popup {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        -webkit-transition: opacity 0.3s 0s, visibility 0s 0.3s;
        -moz-transition: opacity 0.3s 0s, visibility 0s 0.3s;
        transition: opacity 0.3s 0s, visibility 0s 0.3s;
    }

    .bts-popup.is-visible {
        z-index: 9;

        opacity: 1;
        z-index: 9;
        visibility: visible;
        -webkit-transition: opacity 0.3s 0s, visibility 0s 0s;
        -moz-transition: opacity 0.3s 0s, visibility 0s 0s;
        transition: opacity 0.3s 0s, visibility 0s 0s;
    }

    .bts-popup-container {
        position: relative;
        width: 90%;
        max-width: 400px;
        margin: 4em auto;
        background: #fff;
        border-radius: none;
        text-align: center;
        box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
        -webkit-transform: translateY(-40px);
        -moz-transform: translateY(-40px);
        -ms-transform: translateY(-40px);
        -o-transform: translateY(-40px);
        transform: translateY(-40px);
        /* Force Hardware Acceleration in WebKit */
        -webkit-backface-visibility: hidden;
        -webkit-transition-property: -webkit-transform;
        -moz-transition-property: -moz-transform;
        transition-property: transform;
        -webkit-transition-duration: 0.3s;
        -moz-transition-duration: 0.3s;
        transition-duration: 0.3s;
    }

    .bts-popup-container img {
        padding: 20px 0 0 0;
    }

    .bts-popup-container p {
        color: white;
        padding: 10px 40px;
    }

    .bts-popup-container .bts-popup-button {
        padding: 5px 25px;
        border: 2px solid white;
        display: inline-block;
        margin-bottom: 10px;
    }

    .bts-popup-container a {
        color: white;
        text-decoration: none;
        text-transform: uppercase;
    }






    .bts-popup-container .bts-popup-close {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 30px;
        height: 30px;
    }

    .bts-popup-container .bts-popup-close::before,
    .bts-popup-container .bts-popup-close::after {
        content: '';
        position: absolute;
        top: 12px;
        width: 16px;
        height: 3px;
        background-color: #000;
    }

    .bts-popup-container .bts-popup-close::before {
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
        left: 8px;
    }

    .bts-popup-container .bts-popup-close::after {
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
        -o-transform: rotate(-45deg);
        transform: rotate(-45deg);
        right: 6px;
        top: 13px;
    }

    .is-visible .bts-popup-container {
        -webkit-transform: translateY(0);
        -moz-transform: translateY(0);
        -ms-transform: translateY(0);
        -o-transform: translateY(0);
        transform: translateY(0);
    }

    @media only screen and (min-width: 1170px) {
        .bts-popup-container {
            margin: 8em auto;
        }
    }

    .card {
        background: white;
        padding: 60px 0;
        border-radius: 4px;
        display: inline-block;
        margin: 0 auto;
    }

    .card h1 {
        color: <?= $popup['color']; ?>;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }

    .card p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    .card i {
        color: <?= $popup['color']; ?>;
        font-size: 100px;
        line-height: 200px;
        margin-left: -15px;
    }

    table {
        margin: 50px;
        padding: 50px;
    }
</style>
<div class="bts-popup" role="alert">
    <div class="bts-popup-container">
        <div class="card">
            <div style="border-radius:200px; height:200px; width:200px; background: <?= $popup['bakcolor']; ?>; margin:0 auto;">
                <i class="checkmark"><?= $popup['sign']; ?></i>
            </div>
            <h1><?= $popup['text']; ?></h1>
            <p><?= $popup['textln']; ?></p>
        </div>
        <a href="#0" class="bts-popup-close img-replace">Close</a>
    </div>
</div>

<!--Founded in 2007-->
<section class="uk-section-small detail-page-bg">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-7">
                <div id="printDiv">
                    <table id="customers">
                        <tr>
                            <th class="text-center" colspan="2">Transaction <?= $popup['text']; ?></th>
                        </tr>
                        <?php if (isset($_SESSION)) { ?>

                            <tr>
                                <td> Payment Id : </td>
                                <td> <?= $_SESSION['payment_id']; ?></td>
                            </tr>
                            <tr>
                                <td>Amount : </td>
                                <td>Rs <?= $_SESSION['amount']; ?></td>
                            </tr>
                            <tr>
                                <td>Name : </td>
                                <td><?= $_SESSION['name']; ?></td>
                            </tr>
                            <tr>
                                <td>Email :</td>
                                <td><?= $_SESSION['email']; ?></td>
                            </tr>
                            <tr>
                                <td>Mobile : </td>
                                <td><?= $_SESSION['mobile']; ?></td>
                            </tr>

                            <br>

                        <?php } ?>

                    </table>
                    <button class="uk-button" type="submit" value="Print" id="doPrint" style="float: left; background: #222; margin: 20px; padding: 10px; color: #d8b052;">Print or Download</button>
                    <!-- <button class="uk-button" type="submit" value="Download" id="doDownload" style="float: right;background: #222;">Download</button> -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script> -->

<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>

<?php include "globals/footer.php"; ?>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    jQuery(document).ready(function($) {
        document.getElementById("doPrint").addEventListener("click", function() {
            var container = $("body").html();
            var myel = $(this);
            myel.remove();
            window.print();
            $("#printDiv").append(myel);
        });
        var doc = new jsPDF();
        $('#doDownload').click(function() {
            doc.fromHTML($('#printDiv').html(), 15, 15, {
                'width': 170,
                'elementHandlers': true
            });
            doc.save('entry-form-detial.pdf');
        });
        window.onload = function() {
            $(".bts-popup").delay(1000).addClass('is-visible');
        }
        //open popup
        $('.bts-popup-trigger').on('click', function(event) {
            event.preventDefault();
            $('.bts-popup').addClass('is-visible');
        });
        //close popup
        $('.bts-popup').on('click', function(event) {
            if ($(event.target).is('.bts-popup-close') || $(event.target).is('.bts-popup')) {
                event.preventDefault();
                $(this).removeClass('is-visible');
            }
        });
        //close popup when clicking the esc keyboard button
        $(document).keyup(function(event) {
            if (event.which == '27') {
                $('.bts-popup').removeClass('is-visible');
            }
        });
    });
</script>
