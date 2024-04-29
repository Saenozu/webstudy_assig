<?php
include('./config.php');
include('./db.php');
include('./filter.php');

//Paging
if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
else {
	$page = 1;
}

$search_target = $_GET['target'];
$search_keyword = $_GET['keyword'];
?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
	<title> 2022 자유게시판 </title>
	<style>
		
	</style>
	<link href="style" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="#">
</head>
	<body>
		<div id="wrap">
			<div id="header">
				<div class="header_side"></div>
				<div class="header_center"><a href='./' id="header_title">2022 SAENOZU FREEBOARD</a></div>
				<div class="header_side">
					<?php
						if ($_SESSION['is_login']) {
							echo "<a href='profile.php' class='link_login'>".$_SESSION['user_name']."&nbsp;님</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
							echo "<a href='logout.php' class='link_login'> LOGOUT </a>";
						}
						else { echo "<a href='login.php' class='link_login'> LOGIN </a>"; }
					?>
				</div>
			</div>
			<div id='contents'>
				<div id='contents_wrap'>
					<div id='post_wrap'>
						<?php
							if(!isset($_SESSION['is_login'])) {
								echo "<div id='anonymous_img'></div>
								<p id='anonymous_text'>게시글을 보려면 로그인이 필요합니다.</p>";
							} else { 
								if ($_GET['type']=='list' || !($_GET['type'])) {
						?>
						<div id='post_header'>
							<!--search(S)-->
							<form id='post_search_form' method='get' action='./?type=list'>
								<input type='hidden' value='list' name='type'/>
								<div id='post_search_wrap'>
									<select class='search_target' name='target'>
										<option value>전체</option>
										<option value='title' <?php if($search_target=='title') {echo "selected";} ?>>제목</option>
										<option value='content' <?php if($search_target=='content') {echo "selected";} ?>>내용</option>
										<option value='user' <?php if($search_target=='user') {echo "selected";} ?>>작성자</option>
									</select>
									<input type='text' class='search_keyword' name='keyword' value='<?php echo $search_keyword; ?>'/>
									<button type='submit' class='btn_submit'>
										<span class='btn_text'>검색</span>
									</button>
								</div>
							</form>
							<!--search(E)-->
						</div>
						<!--post list(S)-->
						<div id='post_list_wrap'>
							<table id='post_list_table'>
								<tr>
									<th class='post_list_no'>No.</th>
									<th class='post_list_title'>제목</th>
									<th class='post_list_user'>작성자</th>
									<th class='post_list_date'>작성일</th>
									<th class='post_list_hit'>조회</th>
									<th class='post_list_like'>좋아요</th>
								</tr>
								<?php
									if (isset($search_keyword)) {
										$search_keyword = mysqli_real_escape_string($conn, $search_keyword);
										if ($search_target == 'title' || $search_target == 'content' || $search_target == 'user') {
											$query = "SELECT * FROM FreeBoard_Post WHERE $search_target LIKE '%$search_keyword%' ORDER BY re_no DESC, no ASC, depth ASC";
										}
										else
											$query = "SELECT * FROM FreeBoard_Post WHERE title LIKE '%$search_keyword%' OR content LIKE '%$search_keyword%' OR user LIKE '%$search_keyword%' ORDER BY re_no DESC, no ASC, depth ASC";
									} else {
										$query = "SELECT * FROM FreeBoard_Post ORDER BY re_no DESC, no ASC, depth ASC";
									}
									
									if ($result = mysqli_query($conn, $query)) {
										$total_posts = mysqli_num_rows($result);

										$list = 10; //number of posts displayed per page

										$paging_block_cnt = 5; //number of paging buttons displayed per page
										$paging_block_num = ceil($page/$paging_block_cnt); //if 1 = 1~5, if 2 = 6~10
										$paging_block_start = (($paging_block_num - 1)*$paging_block_cnt)+1; //if 1~5 = 1, if 6~10 = 6
										$paging_block_end = $paging_block_start+$paging_block_cnt-1; //if 1~5 = 5, if 6~10 = 10

										$total_page = ceil($total_posts/$list);
										if ($paging_block_end > $total_page) {
											$paging_block_end = $total_page;
										}
										$total_block = ceil($total_page/$paging_block_cnt);
										$page_start = ($page - 1) * $list;

										//게시글 목록
										if (isset($search_keyword)) {
											if ($search_target == 'title' || $search_target == 'content' || $search_target == 'user')
												$query = "SELECT * FROM FreeBoard_Post WHERE $search_target LIKE '%$search_keyword%' ORDER BY re_no DESC, no ASC, depth ASC LIMIT $page_start, $list";
											else
												$query = "SELECT * FROM FreeBoard_Post WHERE title LIKE '%$search_keyword%' OR content LIKE '%$search_keyword%' OR user LIKE '%$search_keyword%' ORDER BY re_no DESC, no ASC, depth ASC LIMIT $page_start, $list";
										}
										else {
											$query = "SELECT * FROM FreeBoard_Post ORDER BY re_no DESC, no ASC, depth ASC LIMIT $page_start, $list";
										}
										
										if ($result = mysqli_query($conn, $query)) {
											$con_no = $total_posts - ($page - 1) * $list;
											if ($con_no >  $total_posts) {
												$con_no = $total_posts;
											}
											while($row = mysqli_fetch_array($result)) {
												$date = strtotime(strval($row['date']));
												$date = date('Y-m-d',$date);
												$reply_query = "SELECT * FROM FreeBoard_Reply WHERE con_no=".$row['no'];
												if (mysqli_num_rows($reply_result = mysqli_query($conn, $reply_query))) {
													$reply_cnt = mysqli_num_rows($reply_result);
												} else {
													$reply_cnt = 0;
												}

												unset($_SESSION['post_hit_'.$row['no']]);
												unset($_SESSION['access_chk_'.$row['no']]);

												if ($row['lock_flag']) {
													echo "
													<tr>
														<td class='post_list_no'><a href='?type=post&no=".$row['no']."'>".$con_no."</a></td>
														<td class='post_list_title'>
															<a href='?type=post&no=".$row['no']."' style='padding-left: calc(10px*".$row['depth'].");'>";
																if($row['depth'] > 0)
																	echo "<span style='color: #555BD9;'>RE:</span>";
																echo $row['title']."
																<p>(".$reply_cnt.")</p><img src='Images/lock_contents_icon.png' alt='locked' class='locked_contents'>
															</a>
														</td>
														<td class='post_list_user'><a href='?type=post&no=".$row['no']."'>".$row['user']."</a></td>
														<td class='post_list_date'><a href='?type=post&no=".$row['no']."'>".$date."</a></td>
														<td class='post_list_hit'><a href='?type=post&no=".$row['no']."'>".$row['hit']."</a></td>
														<td class='post_list_like'><a href='?type=post&no=".$row['no']."'>".$row['up']."</a></td>
													</tr>
													";
												} else {
													echo "
													<tr>
														<td class='post_list_no'><a href='?type=post&no=".$row['no']."'>".$con_no."</a></td>
														<td class='post_list_title'>
															<a href='?type=post&no=".$row['no']."' style='padding-left: calc(10px*".$row['depth'].");'>";
																if($row['depth'] > 0)
																	echo "<span style='color: #555BD9;'>RE:</span>";
																echo $row['title']."
																<p>(".$reply_cnt.")</p>
															</a>
														</td>
														<td class='post_list_user'><a href='?type=post&no=".$row['no']."'>".$row['user']."</a></td>
														<td class='post_list_date'><a href='?type=post&no=".$row['no']."'>".$date."</a></td>
														<td class='post_list_hit'><a href='?type=post&no=".$row['no']."'>".$row['hit']."</a></td>
														<td class='post_list_like'><a href='?type=post&no=".$row['no']."'>".$row['up']."</a></td>
													</tr>
													";
												}
												$con_no -= 1;
											}
										}
								?>
							</table>
						</div>
						<!--post list(E)-->	
						<!--write post(S)-->
						<div class='btn_wrap'>
							<button type='button' class='btn_submit' onclick="location.href='write.php'">
								<span class='btn_text'>글쓰기</span>
							</button>
						</div>
						<!--write post(E)-->
						<!--paging(S)-->
						<div id='paging_wrap'>
							<ul class='paging_pages'>
								<?php //페이징
									if ($page <= 1) {
										echo "
										<li class='first-page disable'>
											<a>«</a>
										</li>
										<li class='prev-page disable'>
											<a>‹</a>
										</li>
										";
									}
									else {
										$prev_page = $page - 1;
										echo "
										<li class='first-page'>
											<a href='?type=list&page=1'>«</a>
										</li>
										<li class='prev-page'>
											<a href='?type=list&page={$prev_page}'>‹</a>
										</li>
										";
									}
									for ($i = $paging_block_start; $i <= $paging_block_end; $i++) {
										if ($page == $i) {
											echo "
											<li class='active'>
												<a onclick='return false'>$i</a>
											</li>
											";
										}
										else {
											echo "
											<li>
												<a href='./?type=list&page=$i'>$i</a>
											</li>
											";
										}
									}
									if ($page >= $total_page) {
										echo "
										<li class='next-page disable'>
											<a>›</a>
										</li>
										<li class='last-page disable'>
											<a>»</a>
										</li>
										";
									}
									else {
										$next_page = $page + 1;
										echo "
										<li class='next-page'>
											<a href='?type=list&page={$next_page}'>›</a>
										</li>
										<li class='last-page'>
											<a href='?type=list&page=$total_page'>»</a>
										</li>
										";
									}
								} ?>
							</ul>
						</div>
						<!--paging(E)-->
						<?php } else if ($_GET['type']=='post') {
								include_once('./read.php');?>
						<?php } ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</body>
</html>
