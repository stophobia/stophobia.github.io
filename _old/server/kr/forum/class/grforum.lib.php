<?php
/**
 * GR Forum Library Class (with GR Core)
 * @author sirini
 * @update 2009-08-11
 * @comment GR Forum 라이브러리
 * @warning 이 클래스는 GR Core 가 먼저 선언된 이후에 쓸 수 있다.
 */

class Forum {
	public $core, $prefix, $bbsPrefix, $grboard;
	function __construct($corePtr, $dbFIX, $bbsFIX, $grboard) {
		$this->core = $corePtr;
		$this->prefix = $dbFIX;
		$this->bbsPrefix = $bbsFIX;
		$this->grboard = $grboard;
	}

	function cutString($str, $size) {
		mb_internal_encoding('UTF-8');
		return mb_substr($str, 0, $size);
	}

	function getView($target='') {
		if($target) return $this->core->getData('select var from ' . $this->prefix . 'view where opt = \'' . $target . '\' limit 1');
		else {
			$result = array();
			$list = $this->core->query('select opt, var from ' . $this->prefix . 'view');
			while($opt = $this->core->fetch($list)) $result[$opt['opt']] = stripslashes($opt['var']);
			return $result;
		}
	}

	function getPath($parent=0, $result=array(array()), $count=0) {
		$get = $this->core->getData('select name, parent from ' . $this->prefix . 'category where uid = ' . $parent);
		if(!$get['parent']) {
			arsort($result);
			$html = '<ul><li><a href="./">처음화면</a></li>';
			for($i=count($result)-1; $i>=0; $i--) {
				list($p, $n) = each($result[$i]);
				$html .= '<li><a href="./?parent=' . $p . '&amp;action=view">' . $n . '</a></li>';
			}
			$html .= '</ul>';
			return $html;
		}
		$result[$count][$parent] = stripslashes($get['name']);
		return $this->getPath($get['parent'], $result, ++$count);
	}

	function getChild($parent=0) {
		return $this->core->query('select * from ' . $this->prefix . 'category where parent = ' . $parent . ' order by align asc');
	}

	function getParent($parent=0) {
		return $this->core->getData('select * from ' . $this->prefix . 'category where uid = ' . $parent . ' limit 1');
	}

	function setValid($list) {
		$list['name'] = stripslashes($list['name']);
		$list['title_name'] = $list['name'];
		$list['description'] = stripslashes($list['description']);
		if($list['bbs_id']) $list['name'] = '<a href="' . $this->grboard . '/board.php?id=' . $list['bbs_id'] . '">' . $list['name'] . '</a>';
		elseif($list['out_link']) $list['name'] = '<a href="' . $list['out_link'] . '">' . $list['name'] . '</a>';
		else $list['name'] = '<a href="./?parent=' . $list['uid'] . '&amp;action=view">' . $list['name'] . '</a>';
		return $list;
	}

	function isViewable($catUid, $isPublic) {
		if($isPublic) return true;
		else {
			if($_SESSION['no'] == 1) return true;
			elseif(!$_SESSION['no']) return false;
			else {
				$getMyGroup = $this->core->getData('select group_no from ' . $this->bbsPrefix . 'member_list where no = ' . $_SESSION['no'] . ' limit 1');
				$getPermGroup = $this->core->getData('select mem_group from ' . $this->prefix . 'access where cat_uid = ' . $catUid . ' limit 1');
				if(!$getMyGroup[0] || !$getPermGroup[0] || ($getMyGroup[0] != $getPermGroup[0])) return false;
				else return true;
			}
		}
	}

	function hasChild($catUid) {
		$getChild = $this->core->getData('select uid from ' . $this->prefix . 'category where parent = ' . $catUid . ' limit 1');
		if($getChild['uid']) return true;
		else return false;
	}

	function getStatus($catUid, $date='Y-m-d H:i:s', $cut=20) {
		$result = $this->core->getData('select * from ' . $this->prefix . 'status where cat_uid = ' . $catUid);
		if($result['uid']) {
			$post = $this->core->getData('select no, member_key, name, signdate, subject from ' . $this->bbsPrefix . 'bbs_' . $result['latest_id'] . ' where no = ' . $result['latest_no'] . ' limit 1');
			if(!$post['name']) $post = $this->core->getData('select no, member_key, name, signdate, subject from ' . $this->bbsPrefix . 'bbs_' . $result['latest_id'] . ' order by no desc limit 1');
			$result['latest'] = '<p><a href="' . $this->grboard . '/board.php?id=' . $result['latest_id'] . '&amp;articleNo=' . $post['no'] . '" title="작성시각: ' . date($date, $post['signdate']) . '"> ' . $this->cutString(stripslashes($post['subject']), $cut) . '</a></p><p><span onclick="Skin.getMember(\'' . $post['member_key'] . '\', \'' . $_SESSION['no'] . '\', \'' . $this->grboard . '\', \'' . $result['latest_id'] . '\', event);">by ' . stripslashes($post['name']) . '</span></p>';
		} else {
			$result['post_count'] = 0;
			$result['reply_count'] = 0;
		}
		return $result;
	}

	function isLogin() {
		if($_SESSION['no']) return true;
		else return false;
	}

	function isAdmin() {
		if($_SESSION['no'] == 1) return true;
		else return false;
	}

	function getMemInfo($select) {
		$result = $this->core->getData('select ' . $select . ' from ' . $this->bbsPrefix . 'member_list where no = ' . $_SESSION['no'] . ' limit 1');
		return $result[$select];
	}

	function getNowConnList() {
		$result = '<ul><li>현재 접속중인 회원: </li>';
		$list = $this->core->query('select no, nickname from ' . $this->bbsPrefix . 'member_list where lastlogin > ' . (time()-600) . ' order by lastlogin desc');
		while($now = $this->core->fetch($list)) {
			$result .= '<li><span onclick="Skin.getMember(\'' . $now['no'] . '\', \'' . $_SESSION['no'] . '\', \'' . $this->grboard . '\', \'\', event);">' . stripslashes($now['nickname']) . '</span></li>';
			$isLooped = true;
		}
		if($isLooped) $result .= '</ul>';
		else $result .= '<li class="notFound">접속중인 회원이 없습니다.</li></ul>';
		return $result;
	}

	function getTotalStatus() {
		$result['post'] = end($this->core->getData('select count(*) from ' . $this->bbsPrefix . 'total_article'));
		$result['reply'] = end($this->core->getData('select count(*) from ' . $this->bbsPrefix . 'total_comment'));
		$result['member'] = end($this->core->getData('select count(*) from ' . $this->bbsPrefix . 'member_list'));
		$member = $this->core->getData('select no, nickname from ' . $this->bbsPrefix . 'member_list order by no desc limit 1');
		$result['latest_member'] = '<span onclick="Skin.getMember(\'' . $member['no'] . '\', \'' . $_SESSION['no'] . '\', \'' . $this->grboard . '\', \'\', event);">' . stripslashes($member['nickname']) . '</span>';
		$bbs = $this->core->query('select bbs_id from ' . $this->prefix . 'category where bbs_id != \'\'');
		return $result;
	}

	function getBBSList($select='id') {
		return $this->core->query('select ' . $select . ' from ' . $this->bbsPrefix . 'board_list');
	}
}
?>