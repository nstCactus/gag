<!doctype html>
<!--[if lt IE 10]><html class="no-js lt-ie10" lang="{'Config.langUrl'|configure}"><![endif]-->
<html class="no-js" lang="{'Config.langUrl'|configure}">
{'layout/html-head'|element}
<link rel="stylesheet" href="{$view->base}/static/styles/pattern.css?{$smarty.const.SVN_REVISION}">

<body class="BodyLayout lhs_Pattern">
		{$content_for_layout}

		{'component_library_control'|element}

		{* Compiled scripts *}
		<script src="{$view->base}/static/scripts/script.js?{$smarty.const.SVN_REVISION}"></script>

		{* Compiled pattern *}
		<script src="{$view->base}/static/scripts/pattern.js?{$smarty.const.SVN_REVISION}"></script>

		{* Cookies kit *}
		<script src="{$view->base}/static/scripts/cnil.min.js?{$smarty.const.SVN_REVISION}" id="cnil-import"></script>
</body>
</html>