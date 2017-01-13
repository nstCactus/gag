<!doctype html>
<!--[if lt IE 10]><html class="no-js lt-ie10" lang="{'Config.langUrl'|configure}"><![endif]-->
<html class="no-js" lang="{'Config.langUrl'|configure}">
    {'layout/html-head'|element}

    <body class="BodyLayout">
        <div class="AppContainer">
            {'layout/header'|element}

            {'breadcrumb'|component:[ 'fields' => [
                'breadcrumbs' => $breadcrumb
            ]]}

            {$content_for_layout}

            {'layout/footer'|element}

            {'menu'|component : [ 'fields' => [
                'menuItems' => $headerMenuItems
            ]]}
        </div>

        {* Compiled scripts *}
        <script src="{$view->base}/static/scripts/script.js?{$smarty.const.SVN_REVISION}"></script>

        {* Cookies kit *}
        <script src="{$view->base}/static/scripts/cnil.min.js?{$smarty.const.SVN_REVISION}" id="cnil-import"></script>
    </body>
</html>
