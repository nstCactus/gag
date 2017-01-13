<?php

class AppError extends ErrorHandler
{
    function error404($params)
    {
        $this->globalCatch($params);

        //parent::error404($params);
    }

    function globalCatch($params)
    {
        $this->controller->beforeFilter();

        parent::error404($params);
    }

    function missingController($params)
    {
        $this->globalCatch($params);

        //parent::missingController($params);
    }

    function missingView($params)
    {
        $this->globalCatch($params);

        //parent::missingView($params);
    }
}
