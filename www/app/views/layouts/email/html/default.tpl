{assign var=width value='617'}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<body style="margin:0;padding:0;background-color:#FFFFFF">

<style type="text/css">
	body{ margin:0;padding:0;background-color:#FFFFFF; }
	a, a:link, span.MsoHyperlink, a:active{ color:#27384d !important;text-decoration:none; }
	a:hover{ color:#27384d !important;text-decoration:underline; }
</style>
<center>
	<table cellpadding="0" cellspacing="0" width="{$width}" style="margin-top:18px;margin-bottom:18px;">
		<tr>
			<td width="{$width}" height="22" style="background-color:#ececec"></td>
		</tr>
		<tr>
			<td width="{$width}" height="42" style="background-color:#ececec;padding-left:25px;">
				<img style="display:block;" alt="Logo du Groupement d'Achats du Grésivaudan" border="0" src="{'App.httpHost'|configure}{$view->base}/static/images/email/logo.png" />
			</td>
		</tr>
		<tr>
			<td width="{$width}" height="22" style="background-color:#ececec"></td>
		</tr>
		<tr>
			<td width="{$width}" height="18"></td>
		</tr>
		<tr>
			<td style="background-color:#ececec;padding-left:25px;padding-right:25px;padding-top:18px;padding-bottom:18px;color:#666666;font-size:14px;font-family:arial, sans-serif;line-height: 18px;">
				{$content_for_layout}
			</td>
		</tr>
	</table>
</center>
</body>
</html>
