<?php

namespace app\api\controller\v1;

use app\api\model\ThemeModel;
use app\api\validate\IDCollection;
use app\api\validate\IDPositiveIntValidate;
use app\lib\exception\ThemeNotFoundException;

class Theme {
    /*
     * @url /themes?id=id1,id2,..,idn
     * @return themes array
     * */
    public function getSimpleThemes($ids = '') {
        (new IDCollection())->validate();
        //老师写的,其实简单的查询代码可以写在这里
        //用select 查询所有的
        $result = ThemeModel::with(['topicImg', 'headImg'])->select($ids);
//我写的
//        $themes = ThemeModel::getThemes();
        if (!$result) {
            throw new ThemeNotFoundException();
        }
        return $result;
    }

    /*
     * @url /theme/:id
     * */
    public function getThemeWithProducts($id = '') {
        (new IDPositiveIntValidate())->validate();
        $result = ThemeModel::with(['products', 'topicImg', 'headImg'])->find($id);
        if (!$result) {
            throw new ThemeNotFoundException();
        }
        return $result;
    }
}
