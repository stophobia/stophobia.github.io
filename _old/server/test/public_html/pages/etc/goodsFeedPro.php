<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";



$gf_file = $_FILES[gf_file][name] ? file_upload($_FILES[gf_file],"/odprogram/upfiles/proposal") : "";

$que = "insert into goodsFeed set
				gf_id				=	'".htmlspecialchars($_POST[gf_id])."',
				gf_name			=	'".htmlspecialchars($_POST[gf_name])."',
				gf_tel			=	'".htmlspecialchars($_POST[gf_tel])."',
				gf_hp				=	'".htmlspecialchars($_POST[gf_hp])."',
				gf_email		=	'".htmlspecialchars($_POST[gf_email])."',
				gf_title		=	'".htmlspecialchars($_POST[gf_title])."',
				gf_contents	=	'".htmlspecialchars($_POST[gf_contents])."',
				gf_file			=	'".$gf_file."',
				gf_regidate	=	now()";
$res = mysql_query($que);

	$mailheaders = "From: [$_POST[gf_name]] <$_POST[gf_email]> \n"; 
	$mailheaders .= "Content-Type: text/html; charset=euc-kr";
	
	$to = "$row_company[name]<$row_company[email]>";
	$title = "[$_POST[gf_name]]님께서 추천해주셨습니다.";
	

$body = "<html>
									<head>
										<title></title>
										<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
									</head>
									<body bgcolor='#FFFFFF' leftmargin='10' topmargin='10'>
										<link href='http://".$_SERVER[HTTP_HOST]."/css/style.css' rel='stylesheet' type='text/css'>
										<table width='530' border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
													<tr>
														<td><img src='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_01.jpg' width='530' height='52'></td>
													</tr>
												</table>
													<table width='501' border='0' align='center' cellpadding='0' cellspacing='0'>
														<tr>
															<td valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
																<tr>
																	<td><img src='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_02.jpg' width='229' height='44'></td>
																</tr>
															</table>
																<table width='100%' border='0' cellspacing='0' cellpadding='0'>
																	<tr>
																		<td height='2' bgcolor='#cccccc'></td>
																	</tr>
																</table>
																<table width='100%' border='0' cellspacing='0' cellpadding='0'>
																	<tr>
																		<td height='35' background='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_03.jpg'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
																			<tr>
																				<td width='17'></td>
																				<td width='63'>작성자</td>
																				<td><span class='spb15'>
																					".htmlspecialchars($_POST[gf_name])."
																				</span></td>
																			</tr>
																		</table></td>
																	</tr>
																</table>
																<table width='100%' border='0' cellspacing='0' cellpadding='0'>
																	<tr>
																		<td height='35' background='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_03.jpg'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
																				<tr>
																					<td width='17'></td>
																					<td width='63'>연락처</td>
																					<td><span class='spb15'>
																						".htmlspecialchars($_POST[gf_tel])."
																					</span></td>
																				</tr>
																		</table></td>
																	</tr>
																</table>
																<table width='100%' border='0' cellspacing='0' cellpadding='0'>
																	<tr>
																		<td height='35' background='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_03.jpg'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
																				<tr>
																					<td width='17'></td>
																					<td width='63'>핸드폰</td>
																					<td><span class='spb15'>
																						".htmlspecialchars($_POST[gf_hp])."
																					</span></td>
																				</tr>
																		</table></td>
																	</tr>
																</table>
																<table width='100%' border='0' cellspacing='0' cellpadding='0'>
																	<tr>
																		<td height='35' background='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_03.jpg'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
																				<tr>
																					<td width='17'></td>
																					<td width='63'>첨부파일</td>
																					<td><span class='spb15'>
																						".($gf_file ? "<a href='http://".$_SERVER[HTTP_HOST].$gf_file."'>다운로드</a>" : "없음")."
																					</span></td>
																				</tr>
																		</table></td>
																	</tr>
																</table>
																<table width='100%' border='0' cellspacing='0' cellpadding='0'>
																	<tr>
																		<td height='35' background='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_03.jpg'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
																				<tr>
																					<td width='17'></td>
																					<td width='63'>이메일</td>
																					<td><span class='spb15'>
																						".htmlspecialchars($_POST[gf_email])."
																					</span></td>
																				</tr>
																		</table></td>
																	</tr>
																</table>
																<table width='100%' border='0' cellspacing='0' cellpadding='0'>
																	<tr>
																		<td height='35' background='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_03.jpg'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
																				<tr>
																					<td width='17'></td>
																					<td width='63'>제목</td>
																					<td><span class='spb15'>
																						".htmlspecialchars($_POST[gf_title])."
																					</span></td>
																				</tr>
																		</table></td>
																	</tr>
																</table>
																<table width='100%' border='0' cellspacing='0' cellpadding='0'>
																	<tr>
																		<td height='180' background='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_04.jpg'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
																			<tr>
																				<td width='17'></td>
																				<td width='63'>내용</td>
																				<td><span class='spb15'>
																					".htmlspecialchars($_POST[gf_contents])."
																				</span></td>
																			</tr>
																		</table></td>
																	</tr>
																</table></td>
														</tr>
													</table></td>
											</tr>
										</table>
										</body>
										</html>";


	$to						=	iconv("utf-8","euckr",$to);
	$title				=	iconv("utf-8","euckr",$title);
	$body					=	iconv("utf-8","euckr",$body);
	$mailheaders	=	iconv("utf-8","euckr",$mailheaders);

	$res2 = mail($to,$title,$body,$mailheaders);

if($res2) {
	error_msgall('접수되었습니다. 감사합니다.','close');
}

/*
create table goodsFeed (
gf_idx int auto_increment primary key,
gf_id varchar(100) not null default '',
gf_name varchar(100) not null default '',
gf_tel varchar(100) not null default '',
gf_hp varchar(100) not null default '',
gf_email varchar(100) not null default '',
gf_contents varchar(100) not null default '',
gf_title varchar(100) not null default '',
gf_file varchar(100) not null default '',
gf_regidate datetime not null);
*/

?>