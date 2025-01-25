<?php
// 추가 필드로 작성된 데이터를 취합, 추가할 쿼리문 작성
$addExtendFieldQuery = ",
ext_money_original = '".$_POST['ext_money_original']."',
ext_money_real = '".$_POST['ext_money_real']."',
ext_no_interest = '".$_POST['ext_no_interest']."',
ext_money_save = '".$_POST['ext_money_save']."',
ext_number_get = '".$_POST['ext_number_get']."',
ext_transport_cost = '".$_POST['ext_transport_cost']."',
ext_transport_term = '".$_POST['ext_transport_term']."',
ext_from_made = '".htmlspecialchars(addslashes($_POST['ext_from_made']))."',
ext_exchange_info = '".htmlspecialchars(addslashes($_POST['ext_exchange_info']))."',
ext_product_code = '".htmlspecialchars(addslashes($_POST['ext_product_code']))."',
ext_etc_info = '".htmlspecialchars(addslashes($_POST['ext_etc_info']))."'";
?>