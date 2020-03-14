<?php
class NewsController
{
    public function actionIndex()
    {
        echo 'news list';
        return true;
    }
    public function actionView()
    {
        echo 'one news';
        return true;
    }
}