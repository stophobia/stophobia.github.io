<?php
if(!defined('__GRSHOP__')) exit();
?>

<div id="shopInfo" class="infoBox">
<strong>GR Shop 관리자 화면에 오신 것을 환영합니다.</strong><br />
GR Shop 은 <a href="http://sirini.net" title="클릭하시면 시리니넷으로 이동합니다.">시리니넷</a>에서 만든 GR Core, GR Board 와 연동하여 동작하는 작고 빠른 쇼핑몰 입니다.<br />
현재 설치되어 있는 환경과 관리자님 브라우저의 정보는 아래와 같습니다.<br />
<ul>
	<li>서버 운영체제: <?php echo PHP_OS; ?></li>
	<li>PHP 버젼: <?php echo PHP_VERSION; ?></li>
	<li>MySQL 버젼: <?php echo $core->db->server_info; ?></li>
	<li>GR Core 버젼: <?php echo $core->version; ?></li>
	<li>GR Shop 버젼: <?php echo $shop->version; ?></li>
	<li>관리자님 브라우저: <span id="browserInfo"></span></li>
</ul>
이 페이지에서는 GR Shop 관리를 위한 몇가지 간단한 도움말을 제공합니다. 처음 사용하시거나, 아직 익숙하지 않은 분들은<br />
반드시 이 페이지를 정독하셔서 GR Shop 을 능숙하게 다루실 수 있도록 해주세요.<br />
(※ 팁: 모닝몰 등의 타 쇼핑몰 솔루션을 이미 사용해보신 경험이 있다면 이해가 더 빨리 되실 겁니다.)<br />
<br />
GR Shop 첫화면으로 가고자 할 경우 <a href="../" title="클릭하시면 GR Shop 첫화면으로 이동합니다.">[GR Shop 첫화면 가기]</a> 를 클릭해 주세요.
</div>

<div id="infoHelp" class="main">
<h2 class="line">1. 쇼핑몰 구축 시작하기</h2>
우리는 이제부터 GR Shop 을 이용해서 실제로 쇼핑몰을 구축해 보려고 합니다.<br />
처음 접하시거나 혹은 아직 익숙치 않은 분들은 실제로 GR Shop 이 어떻게 동작하는지 잘 몰라서<br />
헷갈리거나 괜히 어렵게 느껴질 수 있습니다. 그러나 기본 동작원리만 파악할 수 있다면<br />
GR Shop 을 이용해서 손쉽게 쇼핑몰을 운영하고, 또 관리하실 수 있으실 겁니다.<br />
<br />
이미 GR Board, GR Core, GR Shop 순서로 설치를 해내신 여러분들은<br />
아래의 기본 지식을 가지고 있다고 가정하고 설명을 진행하도록 하겠습니다.<br />
<ul>
	<li>GR Board 의 설치 및 게시판 생성/관리 기본 능력 (고수: GR Board 를 이용해서 웹사이트를 만들어본 적 있는 분)</li>
	<li>GR Core 의 설치 및 설정 능력 (고수: GR Core 의 동작원리까지 정확히 알 수 있는 분)</li>
	<li>GR Shop 의 설치 능력 (고수: GR Shop 의 동작원리와 응용방법까지 아시는 분 → 이 페이지는 안보셔도 됩니다.)</li>
	<li>알FTP, 파일질라 등의 FTP 프로그램으로 파일 업/다운로드를 할 수 있는 능력 (고수: 퍼미션의 개념까지 이해하는 분)</li>
	<li>간단한 사진 이미지 보정 능력 / 간단한 HTML 사용 능력 (고수: 포토샵과 드림위버를 자유자재로 다루는 분)</li>
</ul>
이 밖에 모닝몰등의 타 쇼핑몰 솔류션을 이미 경험해 보신 분들이라면 더 빠르게 이해가 되실 겁니다.<br />
위의 기본 지식들에 만약 부족함이 느껴지신다면, 언제든지 시리니넷에 오셔서 묻고답하기 등을 통해<br />
모르는 점을 물어보세요. (특히 GR Board 활용 기술이 필수적이므로 관련된 정보를 많이 얻어보시길 바랍니다.)<br />

<h2 class="line">2. GR Shop 의 전체적인 동작원리 이해하기</h2>
GR Shop 은 여타의 독립된 쇼핑몰 솔루션이 아닌, GR Board 와 GR Core 가 반드시 필요한 "의존형" 쇼핑몰입니다.<br />
전체적으로는 아래와 같이 동작하게 됩니다.<br />
<ul>
	<li>지금 보시는 관리자 페이지, 그리고 기본적인 기능은 GR Core 의 기능을 이용합니다.</li>
	<li>회원, 게시판 등의 쇼핑몰 기능의 대부분을 차지하는 중심 기능은 GR Board 에 의존합니다.</li>
	<li>그 밖에 GR Shop 에서만 사용하는 기능들은 GR Shop 자체 기능을 이용합니다.</li>
</ul>
쉽게 생각하면 관리 기능은 GR Core 를 통해서, 게시판/회원 관리 등의 중심기능은 GR Board 를 통해서,<br />
그리고 그 밖에 기능은 GR Shop 을 통해서 한다고 생각하시면 됩니다.<br />
<br />
실제 대부분의 기능이 GR Board 를 통해서 이루어지기 때문에 여러분들은 게시판 생성/삭제나<br />
회원 관리 등의 기능을 활용하기 위해서 우측 상단에 있는 "<a href="<?php echo $grboard; ?>/admin.php" title="클릭하시면 GR보드 관리자 페이지로 이동합니다.">GR보드관리</a>" 버튼을 많이 활용하셔야 합니다.<br />
(해당 버튼을 클릭하시면 GR Board 관리자 화면으로 이동합니다. 아마도, 마우스 휠 버튼으로 클릭하여 새 탭으로 여는 게 편하실 겁니다.)<br />

<h2 class="line">3. GR Shop 관리자 화면 설명</h2>
GR Shop 관리화면 상단에 보시면 6개의 버튼이 보이실 겁니다.<br />
그 중 맨 마지막은 방금 설명드린 것처럼 GR Board 관리자 화면으로 이동하는 버튼이며,<br />
나머지 5개 버튼들이 있는데, 간단히 설명드리면 아래와 같은 기능들을 합니다.<br />
(지금 보고 계시는 화면은 GR Shop 내장 도움말입니다.)<br />
<ul>
	<li><a href="./?menu=1" title="클릭하시면 상품분류 페이지로 이동합니다.">상품분류</a>: GR Shop 에서는 상품을 3단계로 구분하는데, 그 중 첫번째 大분류를 정하는 곳입니다.</li>
	<li><a href="./?menu=2" title="클릭하시면 GR Shop 에서 사용할 게시판을 등록하러 갑니다.">게시판등록</a>: 이미 설치하신 GR Board 에서 생성해둔 몇 개의 게시판들 중 실제로 GR Shop 에서 사용할 것들을 설정합니다. (이게 사실상 中분류에 속합니다.)</li>
	<li><a href="./?menu=3" title="클릭하시면 주문관리 페이지로 이동합니다.">주문관리</a>: 실제로 고객이 "구매하기" 버튼을 클릭하여 구매 신청서를 남겼을 때 이 곳에서 "입금확인" 등을 하실 수 있습니다.</li>
	<li><a href="./?menu=4" title="클릭하시면 매장관리 페이지로 이동합니다.">매장관리</a>: 쇼핑몰의 레이아웃 선택부터 홈페이지 제목 등의 설정을 관리하실 수 있습니다.</li>
	<li><a href="./?menu=5" title="클릭하시면 배너관리 페이지로 이동합니다.">배너관리</a>: 쇼핑몰이라면 응당 필요한 "배너" 를 관리하는 곳입니다. 사용하시는 레이아웃에 따라서 배치가 달라지며 요구되는 크기도 다릅니다.</li>
</ul>
해당 페이지로 가시면 다시 또 상세한 도움말이 구석 구석에 배치되어 있습니다.<br />
처음에는 도움말 보는 게 귀찮으시겠지만, 더 능숙한 온라인 상점 관리를 위한 필수 코스이므로<br />
어렵다 생각하지만 말고 차근 차근 이해해 보시면서 활용해 보도록 합시다.<br />

<h2 class="line">4. 예시를 통한 GR Shop 활용방법 익히기</h2>
실제로 뭐든지 예제를 따라해 보면서 익히는 것이 제일 빠르겠죠?<br />
여기서는 사소하게 보일지 모르는 것들까지 하나씩 단계를 설명하면서 어떤 식으로 관리하면 좋을지에 대한<br />
아이디어를 제공해 드립니다. (여기 예시에서는 GR Shop 을 통해 디카/컴퓨터/프린트/노트북 을 판매한다고 가정합니다.)<br />
<ol>
	<li>GR Board 설치 완료</li>
	<li>GR Core 설치 완료</li>
	<li>GR Shop 설치 완료</li>
	<li>GR Shop 폴더 안에 있는 'grboard_skin' 를 받고 열어서 그 안에 있는 폴더들(예: theme)을 모두 GR Board 디렉토리 안에 덮어 씌우기</li>
	<li>GR Shop 관리자로 로그인</li>
	<li>현재 도움말 페이지 숙독</li>
	<li>우측 상단의 "GR보드관리" 클릭</li>
	<li>GR Shop 기본 레이아웃 스킨에서 요구하는 아래의 게시판들을 GR보드 관리화면 "게시판관리" 에서 생성<br />
		- <strong>freeboard</strong> : 자유게시판용<br />
		- <strong>notice</strong> : 이벤트/소식용<br />
		- <strong>qna</strong> : 고객 문의 게시판용<br />
		- <strong>best</strong> : 추천상품 진열용 (테마는 'grshop_only_' 로 시작하는 것을 선택)<br />
		- <strong>dica</strong> : 디카 상품 진열용 (테마는 'grshop_only_' 로 시작하는 것을 선택)<br />
		- <strong>computer</strong> : 컴퓨터 상품 진열용 (테마는 'grshop_only_' 로 시작하는 것을 선택)<br />
		- <strong>print</strong> : 프린트 상품 진열용 (테마는 'grshop_only_' 로 시작하는 것을 선택)<br />
		- <strong>notebook</strong> : 노트북 상품 진열용 (테마는 'grshop_only_' 로 시작하는 것을 선택)<br />
	</li>
	<li>다시 GR Shop 관리화면으로 돌아와서 "상품분류" 클릭</li>
	<li>순서대로 추천상품, 디카, 컴퓨터, 프린트, 노트북 카테고리를 생성</li>
	<li>GR Shop 관리화면 상단 "게시판등록" 을 클릭하고 GR Shop 에서 사용할 게시판들을 아래처럼 등록<br />
		- freeboard 게시판 선택, 대분류 "없음" 선택, 제목 "자유게시판" 입력, 부제목 입력, 설명 입력 → 등록하기 클릭<br />
		- notice 게시판 선택, 대분류 "없음" 선택, 제목 "이벤트/소식" 입력, 부제목 입력, 설명 입력 → 등록하기 클릭<br />
		- qna 게시판 선택, 대분류 "없음" 선택, 제목 "문의게시판" 입력, 부제목 입력, 설명 입력 → 등록하기 클릭<br />
		- best 게시판 선택, 대분류 "추천상품" 선택, 제목 "추천상품" 입력, 부제목 입력, 설명 입력 → 등록하기 클릭<br />
		- dica 게시판 선택, 대분류 "디카" 선택, 제목 "디지털 카메라" 입력, 부제목 입력, 설명 입력 → 등록하기 클릭<br />
		- computer 게시판 선택, 대분류 "컴퓨터" 선택, 제목 "컴퓨터" 입력, 부제목 입력, 설명 입력 → 등록하기 클릭<br />
		- print 게시판 선택, 대분류 "프린트" 선택, 제목 "프린트" 입력, 부제목 입력, 설명 입력 → 등록하기 클릭<br />
		- notebook 게시판 선택, 대분류 "노트북" 선택, 제목 "노트북" 입력, 부제목 입력, 설명 입력 → 등록하기 클릭<br />
	</li>
	<li>GR Shop 첫화면을 관리자 로그인 한 상태로 접속</li>
	<li>우측 하단에 "레이아웃 설정" 클릭</li>
	<li>입력 항목에 맞게 입력하고 저장하기<br />
		(GR Shop 기본 basic 레이아웃을 사용할 시 아래의 입력항목이 나타남)<br />
		- 이벤트/소식 게시판 ID : 여기에는 notice 라고 적기<br />
		- 자유게시판 ID : 여기에는 freeboard 라고 적기<br />
		- 문의게시판 ID : 여기에는 qna 라고 적기<br />
		- 추천상품 게시판 ID : 여기에는 best 라고 적기<br />
	</li>
	<li>저장 후에 첫화면 다시 확인</li>
	<li>각 게시판별 (dica, computer, print, notebook) 로 상품 등록하기 시작</li>
	<li>문의게시판에 고객의 글이 올라오면 답변해주기 시작</li>
	<li>GR Shop 관리화면 → 주문관리 를 주기적으로 확인하기 시작</li>
	<li>주문관리에 올라온 주문신청에 실제 고객이름의 입금 내역 확인시 "입금확인" 클릭, 상품배송 시작</li>
	<li>상품배송 후 "상품배송" 클릭</li>
	<li>새 상품을 각각의 게시판에 맞게 등록, 그 중 눈에 띄는 상품은 best 게시판에 복사하기 (GR Board 관리기능임)</li>
</ol>
위의 예시 순서를 보시면 어떤 식으로 운영하면 될지 파악하실 수 있으실 겁니다.<br />
요지는 GR Board 게시판 생성 → GR Shop 상품분류 → GR Shop 게시판등록 → GR Shop 레이아웃 설정 순서입니다.<br />
실제로 몇 번만 해보시면 위의 과정들이 자연스럽게 이해되실 겁니다.<br />

<h2 class="line">5. FAQ</h2>
이 곳에는 여러분들이 궁금해 하실 사항과 그에 대한 답변을 모아두었습니다.<br />
좀 더 자세한 정보나 혹은 별도로 궁금하신 점들이 있으시면 <a href="http://sirini.net" title="클릭하시면 시리니넷으로 이동합니다.">시리니넷</a> 에 문의해 주세요.<br />
<br />
<strong>Q. GR Shop 을 올바르게 설치하려면 어떤 순서로 설치해야 하나요?</strong><br />
A. 먼저 GR Board 를 설치합니다. 그 후 GR Core 를 설치합니다. 마지막으로 GR Shop 을 설치합니다.<br />
<br />
<strong>Q. 회원 관리 기능이랑 게시판 관리 기능은 어디로 갔죠?</strong><br />
A. GR Board 관리화면을 통해서 해당 기능을 사용하실 수 있습니다. GR Shop 자체에는 해당 기능이 없습니다.<br />
<br />
<strong>Q. GR Shop 은 독립적으로 사용 못하나요? 꼭 GR Board 랑 GR Core 라는 걸 설치해야 하나요?</strong><br />
A. 그렇습니다. 쇼핑몰에서 사용되는 대부분의 기능은 GR Board 의 기능을 그대로 사용하며,<br />
관리기능을 사용하기 위해서는 GR Core 의 라이브러리가 반드시 필요합니다.<br />
GR Shop 만으로는 쇼핑몰을 구성하실 수가 없습니다.<br />
<br />
<strong>Q. GR Shop 에서 상품분류는 어떤 식으로 되죠?</strong><br />
A. GR Shop 에서의 상품분류는 대 → 중 → 소 의 3단계로 구분이 됩니다.<br />
대분류는 GR Shop 관리화면 상단의 "상품분류" 를 통해 등록하실 수 있습니다.<br />
중분류는 GR Shop 관리화면 상단의 "게시판등록" 을 통해서 등록하실 수 있습니다.<br />
소분류는 중분류에서 등록한 게시판들 각각의 카테고리가 소분류가 됩니다.<br />
예를 들어, 대분류에 "디카" 를 등록했고, 중분류에서 "dica_canon(캐논매장)", "dica_nikon(니콘매장)" 이라는 게시판을 "디카" 대분류에<br />
등록했다고 합시다. 그리고 dica_canon 게시판은 "DSLR", "소형", "필름" 이렇게 3가지 분류(카테고리)가 있고
dica_nikon 게시판도 마찬가지로 3가지 분류(카테고리)가 있다고 합시다. 이렇게 되면 순서대로<br />
<strong>디카 (대분류)</strong><br />
&nbsp;&nbsp;&nbsp;&nbsp;└ 캐논매장 (중분류)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ DSLR<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ 소형<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ 필름<br />
&nbsp;&nbsp;&nbsp;&nbsp;└ 니콘매장 (중분류)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ DSLR<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ 소형<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ 필름<br />
위와 같은 형태가 됩니다.<br />
<br />
<strong>Q. 더 궁금한 게 많습니다. 어디에서 물어볼 수 있나요?</strong><br />
A. <a href="http://sirini.net" title="클릭하시면 시리니넷으로 이동합니다.">시리니넷</a> 에 오셔서 문의해 주세요.
</div>