<html>
<head>
    <title><?php echo $cfg["pagetitle"] ?></title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="themes/<?php echo $cfg["theme"]; ?>/style.css" />
    <meta http-equiv="pragma" content="no-cache" charset="<?php echo _CHARSET; ?>" />
	<script type="text/javascript" src="/js/mootools-core-1.4.5-full-nocompat-yc.js"></script>
	<script type="text/javascript" src="/js/main.js"></script>
	<script language="javascript">
		var ol_closeclick = "1";
		var ol_close = "<font color=#ffffff><b>X</b></font>";
		var ol_fgclass = "fg";
		var ol_bgclass = "bg";
		var ol_captionfontclass = "overCaption";
		var ol_closefontclass = "overClose";
		var ol_textfontclass = "overBody";
		var ol_cap = "&nbsp;Torrent Status";
	</script>
	<script src="/js/overlib.js" type="text/javascript"></script>
</head>
<body topmargin="8" bgcolor="<?php echo $cfg["main_bgcolor"] ?>">
	<div id="overDiv" style="position:absolute;visibility:hidden;z-index:1000;"></div>
	<div align="center">
		<?php
		if ($messages != ""){
		?>
			<table border="1" cellpadding="10" bgcolor="#ff9b9b">
				<tr>
					<td><div align="center"><?php echo $messages ?></div></td>
				</tr>
			</table>
			<br><br>
		<?php
		}
		?>
		<table border="0" cellpadding="0" cellspacing="0" width="960">
			<tr>
				<td>
					<table border="1" bordercolor="<?php echo $cfg["table_border_dk"] ?>" cellpadding="4" cellspacing="0" width="100%">
						<tr>
							<td colspan="2" background="themes/<?php echo $cfg["theme"] ?>/images/bar.gif">
							<?php DisplayTitleBar($cfg["pagetitle"]); ?>
							</td>
						</tr>
						<tr>
							<td bgcolor="<?php echo $cfg["table_header_bg"] ?>">
								<table width="100%" cellpadding="3" cellspacing="0" border="0">
									<tr>
										<td>
											<form name="form_file" action="/" method="post" enctype="multipart/form-data">
												<?php echo _SELECTFILE ?>:<br>
												<input type="File" name="upload_file" size="40">
												<input type="Submit" value="<?php echo _UPLOAD ?>">
											</form>
										</td>
									</tr>
									<tr>
										<td>
											<form name="form_url" action="/" method="post">
												<hr>
												<?php echo _URLFILE ?>:<br>
												<input type="text" name="url_upload" size="50">
												<input type="Submit" value="<?php echo _GETFILE ?>">
											</form>
										</td>
									</tr>
								</table>
							</td>
							<td bgcolor="<?php echo $cfg["table_data_bg"] ?>" width="310" valign="top">
								<table width="100%" cellpadding="1" border="0">
									<tr>
										<td valign="top">
											<b><?php echo _TORRENTLINKS ?>:</b>
											<br>
											<?php
											$arLinks = GetLinks();
											if (is_array($arLinks))
											{
												foreach($arLinks as $link)
												{
													echo "<a href=\"".$link['url']."\" target=\"_blank\"><img src=\"images/arrow.gif\" width=9 height=9 title=\"".$link['url']."\" border=0 align=\"baseline\">".$link['sitename']."</a><br>\n";
												}
											}
											echo "</ul></td>";

											$arUsers = GetUsers();
											$arOnlineUsers = array();
											$arOfflineUsers = array();

											for($inx = 0; $inx < count($arUsers); $inx++)
											{
												if(IsOnline($arUsers[$inx]))
												{
													array_push($arOnlineUsers, $arUsers[$inx]);
												}
												else
												{
													array_push($arOfflineUsers, $arUsers[$inx]);
												}
											}

											echo "<td bgcolor=\"".$cfg["table_data_bg"]."\" valign=\"top\">";
											echo "<b>"._ONLINE.":</b><br>";

											for($inx = 0; $inx < count($arOnlineUsers); $inx++)
											{
												echo "<a href=\"message.php?to_user=".$arOnlineUsers[$inx]."\">";
												echo "<img src=\"images/user.gif\" width=17 height=14 title=\"\" border=0 align=\"bottom\">". $arOnlineUsers[$inx];
												echo "</a><br>\n";
											}

											// Does the user want to see offline users?
											if ($cfg["hide_offline"] == false)
											{
												echo "<b>"._OFFLINE.":</b></br>";
												// Show offline users

												for($inx = 0; $inx < count($arOfflineUsers); $inx++)
												{
													echo "<a href=\"message.php?to_user=".$arOfflineUsers[$inx]."\">";
													echo "<img src=\"images/user_offline.gif\" width=17 height=14 title=\"\" border=0 align=\"bottom\">".$arOfflineUsers[$inx];
													echo "</a><br>\n";
												}
											}
											?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor="<?php echo $cfg["table_header_bg"] ?>" colspan="2">
								<?php
									displayDriveSpaceBar($drivespace);
								?>
							</td>
						</tr>
						<tr>
							<td bgcolor="<?php echo $cfg["table_data_bg"] ?>" colspan="2">
								<div align="center">
									<font face="Arial" size="2">
										<a href="/readrss">
										<img src="images/download_owner.gif" width="16" height="16" border="0" title="RSS Torrents" align="absmiddle">RSS Torrents</a>
										 |
										<a href="/drivespace">
										<img src="images/hdd.gif" width="16" height="16" border="0" title="<?php echo $drivespace ?>% Used" align="absmiddle"><?php echo _DRIVESPACE ?></a>
										 |
										<a href="/who">
										<img src="images/who.gif" width="16" height="16" title="" border="0" align="absmiddle"><?php echo _SERVERSTATS ?></a>
										 |
										<a href="/all_services">
										<img src="images/all.gif" width="16" height="16" title="" border="0" align="absmiddle"><?php echo _ALL ?></a>
										 |
										<a href="/dir">
										<img src="images/folder.gif" width="16" height="16" title="" border="0" align="absmiddle"><?php echo _DIRECTORYLIST ?></a>
										 |
										<a href="/dir?dir=<?php echo $cfg["user"] ?>"><img src="images/folder.gif" width="16" height="16" title="My Directory" border="0" align="absmiddle">My Directory</a>
									</font>
								</div>
							</td>
						</tr>
					</table>
					<?php getDirList($cfg["torrent_file_path"]); ?>
					<tr class="btr">
						<td bgcolor="<?php echo $cfg["table_header_bg"] ?>" colspan="6">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td valign="top">
										<div align="center">
											<table>
												<tr>
													<td><img src="images/properties.png" width="18" height="13" title="<?php echo _TORRENTDETAILS ?>"></td>
													<td class="tiny"><?php echo _TORRENTDETAILS ?>&nbsp;&nbsp;&nbsp;</td>
													<td><img src="images/run_on.gif" width="16" height="16" title="<?php echo _RUNTORRENT ?>"></td>
													<td class="tiny"><?php echo _RUNTORRENT ?>&nbsp;&nbsp;&nbsp;</td>
													<td><img src="images/kill.gif" width="16" height="16" title="<?php echo _STOPDOWNLOAD ?>"></td>
													<td class="tiny"><?php echo _STOPDOWNLOAD ?>&nbsp;&nbsp;&nbsp;</td>
													<?php if ($cfg["AllowQueing"]) { ?>
														<td><img src="images/queued.gif" width="16" height="16" title="<?php echo _DELQUEUE ?>"></td>
														<td class="tiny"><?php echo _DELQUEUE ?>&nbsp;&nbsp;&nbsp;</td>
													<?php } ?>
													<td><img src="images/seed_on.gif" width="16" height="16" title="<?php echo _SEEDTORRENT ?>"></td>
													<td class="tiny"><?php echo _SEEDTORRENT ?>&nbsp;&nbsp;&nbsp;</td>
													<td><img src="images/delete_on.gif" width="16" height="16" title="<?php echo _DELETE ?>"></td>
													<td class="tiny"><?php echo _DELETE ?></td>
													<?php if ($cfg["enable_torrent_download"]) { ?>
														<td>&nbsp;&nbsp;&nbsp;<img src="images/down.gif" width="9" height="9" title="Download Torrent meta file"></td>
														<td class="tiny">Download Torrent</td>
													<?php } ?>
												</tr>
											</table>
											<table width="100%" cellpadding="5">
												<tr>
													<td width="33%">
														<div class="tiny">
															<?php
															if(checkQManager() > 0){
																 echo "<img src=\"images/green.gif\" align=\"absmiddle\" title=\"Queue Manager Running\" align=\"absmiddle\"> Queue Manager Running<br>";
																 echo "<strong>".strval(getRunningTorrentCount())."</strong> torrent(s) running and <strong>".strval(getNumberOfQueuedTorrents())."</strong> queued.<br>";
																 echo "Total torrents server will run: <strong>".$cfg["maxServerThreads"]."</strong><br>";
																 echo "Total torrents a user may run: <strong>".$cfg["maxUserThreads"]."</strong><br>";
																 echo "* Torrents are queued when limits are met.<br>";
															} else {
																echo "<img src=\"images/black.gif\" title=\"Queue Manager Off\" align=\"absmiddle\"> Queue Manager Off<br><br>";
															}
															?>
														</div>
													</td>
													<td width="33%" valign="bottom">
														<div align="center" class="tiny">
															<?php
															if($drivespace >= 98) {
																echo "\n\n<script  language=\"JavaScript\">\n alert(\""._WARNING.": ".$drivespace."% "._DRIVESPACEUSED."\")\n </script>";
															}

															if (!array_key_exists("total_download",$cfg)) $cfg["total_download"] = 0;
															if (!array_key_exists("total_upload",$cfg)) $cfg["total_upload"] = 0;
															?>
														</div>
													</td>
													<td valign="top" width="33%" align="right">
														<table>
															<tr>
																<td class="tiny" align="right"><?php echo _CURRENTDOWNLOAD ?>:</td>
																<td class="tiny"><strong><?php echo number_format($cfg["total_download"], 2); ?></strong> kB/s</td>
															</tr>
															<tr>
																<td class="tiny" align="right"><?php echo _CURRENTUPLOAD ?>:</td>
																<td class="tiny"><strong><?php echo number_format($cfg["total_upload"], 2); ?></strong> kB/s</td>
															</tr>
															<tr>
																<td class="tiny" align="right"><?php echo _FREESPACE ?>:</td>
																<td class="tiny"><strong><?php echo formatFreeSpace($cfg["free_space"]) ?></strong></td>
															</tr>
															<tr>
																<td class="tiny" align="right"><?php echo _SERVERLOAD ?>:</td>
																<td class="tiny">
																	<?php
																	if ($cfg["show_server_load"] && @isFile($cfg["loadavg_path"])) {
																		$loadavg_array = explode(" ", exec("cat ".escapeshellarg($cfg["loadavg_path"])));
																		$loadavg = $loadavg_array[2];
																		echo "<strong>".$loadavg."</strong>";
																	} else {
																		echo "<strong>n/a</strong>";
																	}
																	?>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<?php
				echo DisplayTorrentFluxLink();
				// At this point Any User actions should have taken place
				// Check to see if the user has a force_read message from an admin
				if (IsForceReadMsg()) {
					// Yes, then warn them
				?>
					<script  language="JavaScript">
						if (confirm("<?php echo _ADMINMESSAGE ?>")) {
							document.location = "readmsg.php";
						}
					</script>
				<?php
				}
				?>
			</td>
		</tr>
	</table>
</body>
</html>
