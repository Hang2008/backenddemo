<?php

namespace app\api\controller\v1;

use app\api\model\ThemeModel;
use app\api\validate\IDCollection;

class Theme {
    /*
     * @url /themes?id=id1,id2,..,idn
     * @return themes array
     * */
    public function getSimpleThemes($ids = '') {
        (new IDCollection())->validate();
//        $themes = ThemeModel::getThemes();
//        return $themes;
        return 'OK';
    }
}
