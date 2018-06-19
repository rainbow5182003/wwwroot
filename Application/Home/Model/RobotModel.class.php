<?php

namespace Home\Model;
use Think\Model;
use User\Api\UserApi;

/**
 * 文档基础模型
 */
class RobotModel extends Model{

    /* 用户模型自动完成 */
    protected $_auto = array(
        array('name', '/^[a-zA-Z]\w{0,30}$/', '文档标识不合法', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
        array('sex', 'require', '性别不能为空', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
        array('name', 'require', '名称不能为空', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
        array('age', 'require', '年龄不能为空', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
        array('constellation', 'require', '星座不能为空', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH)
    );
}
