<head>
	<!-- [IND_TITLE] -->
	<title>{$seo|head_title}</title>
	<!-- [/IND_TITLE] -->

	<meta name="description" content="{$seo['description']|attribute}">
	<meta name="keywords" content="{$seo['keywords']|attribute}" />

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="{$view->base}/static/styles/style.css?{$smarty.const.SVN_REVISION}">

	{* Favicon*}
	<link rel="apple-touch-icon" sizes="180x180" href="{$view->base}/static/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="{$view->base}/static/favicon/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="{$view->base}/static/favicon/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="{$view->base}/static/favicon/manifest.json">
	<link rel="mask-icon" href="{$view->base}/static/favicon/safari-pinned-tab.svg" color="#383838">
	<link rel="shortcut icon" href="{$view->base}/static/favicon/favicon.ico">
	<meta name="msapplication-config" content="{$view->base}/static/favicon/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">

	{* Social share *}
	<meta property="og:title" content="{'social.title'|dico}">
	<meta property="og:description" content="{'social.description'|dico}">
	<meta property="og:image" content="{$view->base}/static/images/social-share.jpg">
	<meta property="og:type" content="website">

	{* GOOGLE ANALYTICS *}
	{if {'analytics'|block}}
		{literal}
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
						(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', '{/literal}{'analytics'|block}{literal}', 'auto');
			ga('send', 'pageview');
		</script>
		{/literal}
	{/if}
</head>
