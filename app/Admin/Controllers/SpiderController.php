<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/23
 * Time: 下午2:33
 */

namespace App\Admin\Controllers;
//use App\Http\Controllers\Controller;

use Encore\Admin\Grid\Tools\BatchAction;
class SpiderController extends  BatchAction
{

    protected $action;

    public function __construct($action = 1)
    {
        $this->action = $action;
    }
    public function script()
    {

        return "
            $('{$this->getElementClass()}').on('click', function() {
            $.ajax({
                method: 'post',
                url: '{$this->resource}/release',
                data: {
                    _token:LA.token,
                    ids: selectedRows(),
                    action: {$this->action}
                },
                success: function () {
                    $.pjax.reload('#pjax-container');
                    toastr.success('操作成功');
                }
            });
        });
        ";

    }



}