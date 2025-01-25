<?
//-----------------------------------------------------------------------------
// 서브페이지 footer부분
//-----------------------------------------------------------------------------


//-----------------------------------------------------------------------------
// 회원정보수정, 참여점수,주문내역, 포인트적립내역, my쿠폰함, 1:1상담내역, 나의글모음, 회원탈퇴
//-----------------------------------------------------------------------------
if (ereg("od_modify.php|od_ordersearchresult.php", $_SERVER[PHP_SELF]) || "u03b02" == $Pid || "u03b04" == $Pid || "u03b05" == $Pid || "u03b06" == $Pid || "u03b07" == $Pid || "u03b08" == $Pid)
{
            echo "
            <br>
            </td>
        </tr>
    </table>";
}
//-----------------------------------------------------------------------------
// 고객센타, 고객문의, 게시판
//-----------------------------------------------------------------------------
else if ("u02b01" == $Pid || "u02b02" == $Pid || $board)
{
                                                echo "
                                                </td>
                                            </tr>
                                        </table>
                                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                            <tr>
                                                <td height='50'>&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width='262' valign='top'>";


    include $_SERVER[DOCUMENT_ROOT]."/pages/goodFeed.php";

                                    echo "
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>";
}
//-----------------------------------------------------------------------------
// 회사소개, 개인보호정책, 서비스이용약관, 이용안내
//-----------------------------------------------------------------------------
else if ("u04b04" == $Pid || "u04b05" == $Pid || "u04b06" == $Pid || "u04b09" == $Pid)
{
                                    echo "
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width='37' valign='top' background='images/company_img_03.jpg'>&nbsp;</td>
                    </tr>
                </table>
                <table width='853' border='0' align='center' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td><img src='images/company_img_05.jpg' width='853' height='21' /></td>
                    </tr>
                </table>
                <br />
                <br />
                <br />
            </td>
        </tr>
    </table>";
}


?>