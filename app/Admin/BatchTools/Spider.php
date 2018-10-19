<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/23
 * Time: 下午2:33
 */

namespace App\Admin\BatchTools;

use Encore\Admin\Grid\Tools\BatchAction;
class Spider extends  BatchAction
{

    protected $action;

    public function __construct($action = 2)
    {
        $this->action = $action;
    }

    public function script()
    {

        return "
            $('{$this->getElementClass()}').on('click', function() {
            var data = selectedRows();
            if(data.length <= 0 ){
                toastr.success('请选择');
               
                return false;
            }
            $.ajax({
                method: 'post',
                url: '{$this->resource}/spliderStart',
                data: {
                    _token:LA.token,
                    ids: selectedRows(),
                    action: {$this->action}
                },
                success: function (res) {
                toastr.success(res.msg);
                $.pjax.reload('#pjax-container');
                   
                }
            });
        });
        ";

    }



}