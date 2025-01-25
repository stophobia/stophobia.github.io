<?
$excelHeader = "
<html xmlns:o='urn:schemas-microsoft-com:office:office'
xmlns:x='urn:schemas-microsoft-com:office:excel'
xmlns='http://www.w3.org/TR/REC-html40'>

<head>
<meta http-equiv=Content-Type content='text/html; charset=ks_c_5601-1987'>
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content='Microsoft Excel 11'>
<link rel=File-List href='zzz.files/filelist.xml'>
<link rel=Edit-Time-Data href='zzz.files/editdata.mso'>
<link rel=OLE-Object-Data href='zzz.files/oledata.mso'>
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>today</o:Author>
  <o:LastAuthor>today</o:LastAuthor>
  <o:LastPrinted>2009-03-10T05:42:06Z</o:LastPrinted>
  <o:Created>2009-03-10T05:12:59Z</o:Created>
  <o:LastSaved>2009-03-10T07:25:02Z</o:LastSaved>
  <o:Version>11.9999</o:Version>
 </o:DocumentProperties>
</xml><![endif]-->
<style>
<!--table
	{mso-displayed-decimal-separator:'\.';
	mso-displayed-thousand-separator:'\,';}
@page
	{margin:1.0in .75in 1.0in .75in;
	mso-header-margin:.5in;
	mso-footer-margin:.5in;}
tr
	{mso-height-source:auto;
	mso-ruby-visibility:none;}
col
	{mso-width-source:auto;
	mso-ruby-visibility:none;}
br
	{mso-data-placement:same-cell;}
.style0
	{mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	white-space:nowrap;
	mso-rotate:0;
	mso-background-source:auto;
	mso-pattern:auto;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움, monospace;
	mso-font-charset:129;
	border:none;
	mso-protection:locked visible;
	mso-style-name:표준;
	mso-style-id:0;}
td
	{mso-style-parent:style0;
	padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움, monospace;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:locked visible;
	white-space:nowrap;
	mso-rotate:0;}
.xl24
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt hairline windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl25
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt hairline windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl26
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl27
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt hairline windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;}
.xl28
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt hairline windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl29
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl30
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt hairline windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:1.0pt solid windowtext;
	background:#FFFFCC;
	mso-pattern:auto none;}
.xl31
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:.5pt hairline windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	background:#FFFFCC;
	mso-pattern:auto none;}
.xl32
	{mso-style-parent:style0;
	mso-number-format:'Short Date';
	text-align:center;
	border-top:none;
	border-right:.5pt hairline windowtext;
	border-bottom:.5pt hairline windowtext;
	border-left:1.0pt solid windowtext;}
.xl33
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt hairline windowtext;
	border-bottom:.5pt hairline windowtext;
	border-left:none;}
.xl34
	{mso-style-parent:style0;
	mso-number-format:'\#\,\#\#0_ ';
	text-align:right;
	border-top:none;
	border-right:.5pt hairline windowtext;
	border-bottom:.5pt hairline windowtext;
	border-left:none;}
.xl35
	{mso-style-parent:style0;
	font-weight:700;
	mso-number-format:'Short Date';
	text-align:center;
	border-top:none;
	border-right:.5pt hairline windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:#CCFFFF;
	mso-pattern:auto none;}
.xl36
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:.5pt hairline windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:#CCFFFF;
	mso-pattern:auto none;}
.xl37
	{mso-style-parent:style0;
	mso-number-format:'\#\,\#\#0_ ';
	text-align:right;
	border-top:none;
	border-right:.5pt hairline windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:#CCFFFF;
	mso-pattern:auto none;}
.xl38
	{mso-style-parent:style0;
	font-size:20.0pt;
	font-style:italic;
	font-family:HY헤드라인M, serif;
	mso-font-charset:129;
	text-align:center;}
.xl39
	{mso-style-parent:style0;
	text-align:right;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;}
.xl40
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt hairline windowtext;
	background:#FFFFCC;
	mso-pattern:auto none;}
.xl41
	{mso-style-parent:style0;
	text-align:center;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid black;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	background:#FFFFCC;
	mso-pattern:auto none;}
.xl42
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt hairline windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt hairline windowtext;
	background:#CCFFFF;
	mso-pattern:auto none;}
.xl43
	{mso-style-parent:style0;
	text-align:center;
	border-top:.5pt hairline windowtext;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:#CCFFFF;
	mso-pattern:auto none;}
.xl44
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:none;
	border-bottom:.5pt hairline windowtext;
	border-left:.5pt hairline windowtext;}
.xl45
	{mso-style-parent:style0;
	text-align:center;
	border-top:none;
	border-right:1.0pt solid black;
	border-bottom:.5pt hairline windowtext;
	border-left:none;}
ruby
	{ruby-align:left;}
rt
	{color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움, monospace;
	mso-font-charset:129;
	mso-char-type:none;
	display:none;}
-->
</style>
<!--[if gte mso 9]><xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>Sheet1</x:Name>
    <x:WorksheetOptions>
     <x:DefaultRowHeight>270</x:DefaultRowHeight>
     <x:Print>
      <x:ValidPrinterInfo/>
      <x:PaperSizeIndex>9</x:PaperSizeIndex>
      <x:Scale>68</x:Scale>
      <x:HorizontalResolution>600</x:HorizontalResolution>
      <x:VerticalResolution>600</x:VerticalResolution>
     </x:Print>
     <x:ShowPageBreakZoom/>
     <x:PageBreakZoom>85</x:PageBreakZoom>
     <x:Selected/>
     <x:Panes>
      <x:Pane>
       <x:Number>3</x:Number>
       <x:ActiveRow>4</x:ActiveRow>
       <x:ActiveCol>1</x:ActiveCol>
      </x:Pane>
     </x:Panes>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
    <x:PageBreaks>
     <x:ColBreaks>
      <x:ColBreak>
       <x:Column>8</x:Column>
       <x:RowStart>1</x:RowStart>
       <x:RowEnd>34</x:RowEnd>
      </x:ColBreak>
     </x:ColBreaks>
    </x:PageBreaks>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>Sheet2</x:Name>
    <x:WorksheetOptions>
     <x:DefaultRowHeight>270</x:DefaultRowHeight>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>Sheet3</x:Name>
    <x:WorksheetOptions>
     <x:DefaultRowHeight>270</x:DefaultRowHeight>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
  <x:WindowHeight>10050</x:WindowHeight>
  <x:WindowWidth>17880</x:WindowWidth>
  <x:WindowTopX>240</x:WindowTopX>
  <x:WindowTopY>30</x:WindowTopY>
  <x:ProtectStructure>False</x:ProtectStructure>
  <x:ProtectWindows>False</x:ProtectWindows>
 </x:ExcelWorkbook>
 <x:ExcelName>
  <x:Name>Print_Area</x:Name>
  <x:SheetIndex>1</x:SheetIndex>
  <x:Formula>=Sheet1!\$A\$1:{printArea}</x:Formula>
 </x:ExcelName>
 <x:ExcelName>
  <x:Name>Print_Titles</x:Name>
  <x:SheetIndex>1</x:SheetIndex>
  <x:Formula>=Sheet1!\$7:\$8</x:Formula>
 </x:ExcelName>
</xml><![endif]-->
</head>

<body link=blue vlink=purple>

<table x:str border=0 cellpadding=0 cellspacing=0 width=982 style='border-collapse:
 collapse;table-layout:fixed;width:737pt'>
 <col width=103 style='mso-width-source:userset;mso-width-alt:2929;width:77pt'>
 <col width=254 style='mso-width-source:userset;mso-width-alt:7224;width:191pt'>
 <col width=165 style='mso-width-source:userset;mso-width-alt:4693;width:124pt'>
 <col width=92 span=5 style='mso-width-source:userset;mso-width-alt:2616;
 width:69pt'>
 <tr height=18 style='height:13.5pt'>
  <td height=18 width=103 style='height:13.5pt;width:77pt'></td>
  <td width=254 style='width:191pt'></td>
  <td width=165 style='width:124pt'></td>
  <td width=92 style='width:69pt'></td>
  <td width=92 style='width:69pt'></td>
  <td width=92 style='width:69pt'></td>
  <td width=92 style='width:69pt'></td>
  <td width=92 style='width:69pt'></td>
 </tr>
 <tr height=34 style='height:25.5pt'>
  <td colspan=8 height=34 class=xl38 style='height:25.5pt'>{bank} 상세내역</td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td height=19 colspan=8 style='height:14.25pt;mso-ignore:colspan'></td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 colspan=4 style='height:18.0pt;mso-ignore:colspan'></td>
  <td class=xl24>작성</td>
  <td class=xl25>검토</td>
  <td class=xl25>검토</td>
  <td class=xl26>승인</td>
 </tr>
 <tr height=67 style='mso-height-source:userset;height:50.25pt'>
  <td height=67 colspan=4 style='height:50.25pt;mso-ignore:colspan'></td>
  <td class=xl27>　</td>
  <td class=xl28>　</td>
  <td class=xl28>　</td>
  <td class=xl29>　</td>
 </tr>
 <tr height=18 style='height:13.5pt'>
  <td height=18 colspan=8 style='height:13.5pt;mso-ignore:colspan'></td>
 </tr>
 <tr height=32 style='mso-height-source:userset;height:24.0pt'>
  <td height=32 colspan=4 style='height:24.0pt;mso-ignore:colspan'></td>
  <td colspan=4 class=xl39>기간 : {sDate}</td>
 </tr>
 <tr height=32 style='mso-height-source:userset;height:24.0pt'>
  <td height=32 class=xl30 style='height:24.0pt'>일자</td>
  <td class=xl31>내용</td>
  <td class=xl31>계정과목</td>
  <td class=xl31>입금액</td>
  <td class=xl31 style='border-top:none'>출금액</td>
  <td class=xl31 style='border-top:none'>잔액</td>
  <td colspan=2 class=xl40 style='border-right:1.0pt solid black;border-left:
  none'>계좌</td>
 </tr>
";

$excelBody = "
 <tr height=35 style='mso-height-source:userset;height:26.25pt'>
  <td height=35 class=xl32 style='height:26.25pt'>{date}</td>
  <td class=xl33>{memo}</td>
  <td class=xl33>{title}</td>
  <td class=xl34 x:num='111'>111 </td>
  <td class=xl34 x:num='222'>222 </td>
  <td class=xl34 x:num='333'>333 </td>
  <td colspan=2 class=xl44 style='border-right:1.0pt solid black;border-left:
  none'>{bank}</td>
 </tr>

 ";

 $excelFooter = "
 <tr height=35 style='mso-height-source:userset;height:26.25pt'>
  <td height=35 class=xl35 style='height:26.25pt'>합 계</td>
  <td class=xl36>-</td>
  <td class=xl36>-</td>
  <td class=xl37 x:num='444'>444 </td>
  <td class=xl37 x:num='555'>555 </td>
  <td class=xl37 x:num='666'>666 </td>
  <td colspan=2 class=xl42 style='border-right:1.0pt solid black;border-left:
  none'>-</td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=103 style='width:77pt'></td>
  <td width=254 style='width:191pt'></td>
  <td width=165 style='width:124pt'></td>
  <td width=92 style='width:69pt'></td>
  <td width=92 style='width:69pt'></td>
  <td width=92 style='width:69pt'></td>
  <td width=92 style='width:69pt'></td>
  <td width=92 style='width:69pt'></td>
 </tr>
 <![endif]>
</table>

</body>

</html>


";