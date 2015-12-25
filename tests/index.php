<?php

    define('BASE_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR . '../');

    require(BASE_DIR.'vendor/autoload.php');
    require('vnpay.php');

    use Vnpay\SoapClient\Exception\VnPayException;
    try {

        $vnPay = new Vnpay();

        //------------------------- HelloWorld -------------------------
        /*$helloWorld = $vnPay->helloWorld();
        echo "\nPass Hello World >>>>>> $helloWorld <<<<<<<";*/

        //------------------------- GetBalance -------------------------
        $getBalance = $vnPay->getBalance();
        echo "\nPass Get Balance >>>>>>";
        echo "\n>>>>>> Status Code: ".$getBalance->getStatusCode()." <<<<<<<";
        echo "\n>>>>>> Balance: ".$getBalance->getMessage()." <<<<<<<\n";

        //------------------------- TopupMobile ------------------------- Gởi thông tin yêu cầu nạp tiền điện thoại tới VnPay
        /*$mobileNo = '';
        $amount = '10000';
        $topupMobile = $vnPay->topupMobile($mobileNo, $amount);
        echo "\nPass Topup Mobile >>>>>>";
        echo "\n>>>>>> Status Code: ".$topupMobile->getStatusCode()." <<<<<<<";
        echo "\n>>>>>> Topup Mobile: ".$topupMobile->getMessage()." <<<<<<<\n";*/

        //------------------------- GetCard ------------------------- Gởi thông tin yêu cầu mua mã thẻ Viettel, Vinaphone, Mobifone tới VnPay
        /*$productCode = 'VT';
        $amount = 10000;
        $getCard = $vnPay->getCard($productCode, $amount);
        echo "\nPass Get Card >>>>>>";
        echo "\n>>>>>> Status Code: ".$getCard->getStatusCode()." <<<<<<<";
        echo "\n>>>>>> Card: ".$getCard->getMessage()." <<<<<<<\n";*/

        //------------------------- GetCardToMobile -------------------------
        /*$productCode = 'MB';
        $amount = 10000;
        $mobileNo = '';
        $getCardToMobile = $vnPay->getCardToMobile($productCode, $amount, $mobileNo);
        echo "\nPass Get Card To Mobile >>>>>>";
        echo "\n>>>>>> Status Code: ".$getCardToMobile->getStatusCode()." <<<<<<<";
        echo "\n>>>>>> Card To Mobile: ".$getCardToMobile->getMessage()." <<<<<<<\n";*/

        //------------------------- getTransaction -------------------------
        /*$trace = '165590';
        $getTransaction = $vnPay->getTransaction($trace);
        echo "\nPass Get Transaction >>>>>>";
        echo "\n>>>>>> Transaction: ".$getTransaction->getMessage()." <<<<<<<\n";*/

        //------------------------- getTransactionCard -------------------------
        /*$trace = '114430';
        $getTransactionCard = $vnPay->getTransactionCard($trace);
        echo "\nPass Get Transaction Card >>>>>>";
        echo "\n>>>>>> Transaction Card: ".$getTransactionCard->getMessage()." <<<<<<<\n";*/

        //------------------------- getMaxTrace -------------------------
        /*$getMaxTrace = $vnPay->getMaxTrace();
        echo "\nPass Get Max Trace >>>>>>";
        echo "\n>>>>>> Max Trace: ".$getMaxTrace->getMessage()." <<<<<<<\n";*/

        //------------------------- checkCardList -------------------------
        /*$product = '097';
        $total = 10;
        $unitCode = 10;
        $checkCardList = $vnPay->checkCardList($product, $total, $unitCode);
        echo "\nPass Check Card List >>>>>>";
        echo "\n>>>>>> Status Code: ".$checkCardList->getStatusCode()." <<<<<<<";
        echo "\n>>>>>> Message: ".$checkCardList->getMessage()." <<<<<<<\n";*/

        //------------------------- getCardList -------------------------
        /*$product = '097';
        $total = 10;
        $unitCode = 10;
        $getCardList = $vnPay->getCardList($product, $total, $unitCode);
        echo "\nPass Get Card List >>>>>>";
        echo "\n>>>>>> Status Code: ".$getCardList->getStatusCode()." <<<<<<<";
        echo "\n>>>>>> Message: ".$getCardList->getMessage()." <<<<<<<\n";*/

        //$salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        //echo uniqid();die;

    } catch (VnPayException $ex) {
        echo("\nErr = " . $ex->getVnPayExceptionErrorCode());
        echo("\nMes = " . $ex->getVnPayExceptionMessage());
    }
    catch (\Exception $ex) {
        //echo openssl_error_string();
        echo("\nFinal error: ".$ex->getMessage());
    }
