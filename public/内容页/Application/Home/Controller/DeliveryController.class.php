<?php
namespace Home\Controller;

use DDP\BaseController;
use Home\Model\DeliveryModel;

//提货记录
class DeliveryController extends BaseController
{
    public function index()
    {
        $this->breadcrumb = array("首页" => "/", "订单管理" => "/Order/index", "提货记录" => "");
        $this->addJS(array("webuploader/webuploader.min.js", "dataTable_extend.js", "date-time/bootstrap-datetimepicker.js", "date-time/locales/bootstrap-datetimepicker.zh-CN.js", "jquery.dataTables.min.js", "moment.js", "delivery/jquery.delivery.js"));
        $this->addCss(array("order/order.css" => "all", "bootstrap-datetimepicker.min.css" => "all", "jquery.datatables.paginate.css" => "all", "webuploader/webuploader.css" => "all"));

        //初始化查询条件
        $type = isset($_SESSION['type']) ? session('type') : json_encode(array('style' => 0, 'orderCode' => -110, 'orderState' => -110, 'startTime' => date("Y-m-d%20H:i:s", strtotime("-90 day")), 'endTime' => date("Y-m-d%20H:i:s", time()), 'pageNo' => 1, 'pageSize' => 30));
        //var_dump($type);exit;
        //var_dump((new DeliveryModel())->find());exit;
        //$this->assign("style",  session('style'));
        $this->assign("search", $type);
        $this->display();
    }

    public function tch()
    {
        $this->breadcrumb = array("首页" => "/", "订单管理" => "/Order/index", "提货记录" => "");
        $this->addJS(array("webuploader/webuploader.min.js", "dataTable_extend.js", "date-time/bootstrap-datetimepicker.js",
            "date-time/locales/bootstrap-datetimepicker.zh-CN.js", "jquery.dataTables.min.js", "moment.js", "order/jquery.tch.js"));
        $this->addCss(array("order/order.css" => "all", "bootstrap-datetimepicker.min.css" => "all", "jquery.datatables.paginate.css" => "all", "webuploader/webuploader.css" => "all"));

        //初始化查询条件
        $type = isset($_SESSION['type']) ? session('type') : json_encode(array('orderCode' => -110, 'orderState' => -110, 'startTime' => date("Y-m-d%20H:i:s", strtotime("-90 day")), 'endTime' => date("Y-m-d%20H:i:s", time()), 'pageNo' => 1, 'pageSize' => 30));
//        var_dump($type);exit;
//        $this->assign("style",  session('style'));
        $this->assign("search", $type);
        $this->display();
    }

    //获取列表详情
    public function ajaxDeliveryList()
    {
        $pageInfo = $this->getDataTablePage();
        switch ($_POST['style']) {
            case 1: //按收货人查询
                $result = $this->getResultByStyle1($pageInfo);
                //var_dump($result);exit;
                break;
            case 0: //按订单查询
                $result = $this->getResultByStyle0($pageInfo);
                break;
        }
        $this->ajaxReturn($result, 'json');
    }

    Private function getResultByStyle1($pageInfo)
    {
        //获取过滤条件--收货人
        $deliveryModel = new DeliveryModel();
        $where = array();
        if ($_POST['accName'] == '-110' && $_POST['accTel'] == '-110') {
            if ($_POST['startTime'] && $_POST['endTime']) {
                $where['create_time'] = array('between', array($_POST['startTime'], $_POST['endTime']));
                $totalRecord = $deliveryModel->where($where)->count();
            } else {
                $totalRecord = $deliveryModel->count();
                //var_dump($totalRecord);exit;
            }

            //var_dump($totalRecord);exit;
        } elseif ($_POST['accName'] != '-110' && $_POST['accTel'] == '-110') {
            //echo$_POST['accName'];exit;
            if ($_POST['startTime'] && $_POST['endTime']) {
                $where['create_time'] = array('between', array($_POST['startTime'], $_POST['endTime']));
                $where['name'] = array('LIKE', '%' . $_POST['accName'] . '%');
            } else {
                $where['name'] = array('LIKE', '%' . $_POST['accName'] . '%');
                //var_dump($where);exit;
            }
            $totalRecord = $deliveryModel->where($where)->count();
        } elseif ($_POST['accTel'] != '-110' && $_POST['accName'] == '-110') {
            if ($_POST['startTime'] && $_POST['endTime']) {
                $where['create_time'] = array('between', array($_POST['startTime'], $_POST['endTime']));
                $where['phone'] = array('EQ', $_POST['accTel']);
                //var_dump($where);exit;
            } else {
                $where['phone'] = array('EQ', $_POST['accTel']);
                //var_dump($where);exit;
            }

            $totalRecord = $deliveryModel->where($where)->count();
            //var_dump($totalRecord);exit;
        } elseif ($_POST['accName'] != '-110' && $_POST['accTel'] != '-110') {
            if ($_POST['startTime'] && $_POST['endTime']) {
                $where['create_time'] = array('between', array($_POST['startTime'], $_POST['endTime']));
                $where['name'] = array('LIKE', '%' . $_POST['accName'] . '%');
                $where['phone'] = array('EQ', $_POST['accTel']);
            } else {
                $where['name'] = array('LIKE', '%' . $_POST['accName'] . '%');
                $where['phone'] = array('EQ', $_POST['accTel']);
            }
            $totalRecord = $deliveryModel->where($where)->count();
        }
        //默认返回值
        $_res = array(
            "draw" => $_POST["draw"],
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array()
        );
        //总数不为空
        if ($totalRecord > 0) {
            //分页计算
            $pageSize = $pageInfo['pageSize'];
            $pageNo = $pageInfo['pageIndex'];
            //查询SQL
            $result = $deliveryModel->where($where)->order('create_time desc')->page($pageNo, $pageSize)->select();
            // var_dump($result);exit;
            //查询结果存在
            if (count($result) > 0) {
                //增加额外字段“action”
                foreach ($result as &$res) {
                    $res['action'] = '<div>del</div>';
                }
                $_res = array(
                    "draw" => $_POST["draw"],
                    "recordsTotal" => $totalRecord,
                    "recordsFiltered" => $totalRecord,
                    "data" => $result
                );
                foreach ($_res['data'] as &$v) {
                    $pay_type = [1 => '微信', 2 => '支付宝', 3 => '云牛券'];
                    $v['pay_money'] = $v['pay_money'] / 100;
                    $v['pay_type'] = $pay_type[$v['pay_type']];
                    $str = 'YN18006542371110';
                    for($i = 1; $i<= $v['id'];$i++){
                        $v['order_id'] = $str.$v['id'];
                    }
                    $arr_state = array(0 => '待支付', 1 => '已支付未发货', 2 => '已支付已发货', 3 => '已退货',
                                        4 => '已完成待评价', 5 => '已完成');
                    if ($v['state'] == 1) {
                        $condition = '<span><a href="#" class="setOrders"  data-toggle="modal" data-target="#Modal" data_id="'.$v['id'].'">(设置订单)</a></span><span><a href="#" class="delete"  data-toggle="modal" data-target="#delModal" data_id="'.$v["id"].'">(取消)</a></span>';
                        //$condition = '<span><a class="setOrders" data_id=".$v["id"].">(设置订单)</a></span><!--.<span class="delete" data_id=".$v["id"].">(取消)</span>-->';
                        $v['state'] = $arr_state[$v['state']] . $condition;
                    } elseif ($v['state'] == 2) {
                        $condition = '<td><a href="#" class="setOrders"  data-toggle="modal" data-target="#Modal" t_express_name="'.$v['express_name'].'" t_express_code="'.$v['express_num'].'" data_id="'.$v['id'].'">(修改订单)</a></td>';
                        $v['state'] = $arr_state[$v['state']] . $condition ;
                    } else {
                        $v['state'] = $arr_state[$v['state']];
                    }
                }
                unset($v);
            }
        }
        return $_res;
    }

    //获取过滤条件--按订单查询
    Private function getResultByStyle0($pageInfo)
    {
        //echo $_POST['startTime'];exit;
        $deliveryModel = new DeliveryModel();
        $where = array();
        if ($_POST['orderCode'] == '-110' && $_POST['orderState'] == '-110') {
            if ($_POST['startTime'] && $_POST['endTime']) {
                $where['create_time'] = array('between', array($_POST['startTime'], $_POST['endTime']));
                //var_dump($where);exit;
            }
            $totalRecord = $deliveryModel->count();
        } elseif ($_POST['orderState'] !== null && in_array($_POST['orderState'], [0, 1, 2, 3, 4, 5])) {
            if ($_POST['startTime'] && $_POST['endTime']) {
                $where['create_time'] = array('between', array($_POST['startTime'], $_POST['endTime']));
                $where['state'] = array('EQ', $_POST['orderState']);
            } else {
                $where['state'] = array('EQ', $_POST['orderState']);
            }

            //var_dump($where);exit;
        } elseif ($_POST['orderCode'] && $_POST['orderCode'] != '-110') {
            if ($_POST['startTime'] && $_POST['endTime']) {
                $where['create_time'] = array('between', array($_POST['startTime'], $_POST['endTime']));
                $where['order_id'] = array('EQ', $_POST['orderCode']);
                //var_dump($where);exit;
            } else {
                $where['order_id'] = array('EQ', $_POST['orderCode']);
            }

        }
        if (!empty($where)) {
            $totalRecord = $deliveryModel->where($where)->count();
            //var_dump($totalRecord);exit;
        } else {
            $totalRecord = $deliveryModel->count();
        }
        //默认返回值
        $_res = array(
            "draw" => $_POST["draw"],
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array()
        );
        //总数不为空
        if ($totalRecord > 0) {
            //分页计算
            $pageSize = $pageInfo['pageSize'];
            // $start .= $_GET['start'];
            $pageNo = $pageInfo['pageIndex'];
            //查询sQL
            $result = $deliveryModel->where($where)->order('create_time desc')->page($pageNo, $pageSize)->select();
            //查询结果存在
            if (count($result) > 0) {
                //增加额外字段“action”
                foreach ($result as &$res) {
                    $res['action'] = '<div>del</div>';
                }
                $_res = array(
                    "draw" => $_POST["draw"],
                    "recordsTotal" => $totalRecord,
                    "recordsFiltered" => $totalRecord,
                    "data" => $result
                );
                //var_dump($_res['data']);exit;
                foreach ($_res['data'] as &$v) {
                    $pay_type = [1 => '微信', 2 => '支付宝', 3 => '云牛券'];
                    $v['pay_money'] = $v['pay_money'] / 100;
                    $v['pay_type'] = $pay_type[$v['pay_type']];
                    $str = 'YN18006542371110';
                    for($i = 1; $i<= $v['id'];$i++){
                        $v['order_id'] = $str.$v['id'];
                    }
                    $arr_state = array(0 => '待支付', 1 => '已支付未发货', 2 => '已支付已发货', 3 => '已退货',
                        4 => '已完成待评价', 5 => '已完成');
                    if ($v['state'] == 1) {

                        $condition = '<span><a href="#" class="setOrders"  data-toggle="modal" data-target="#Modal" data_id="' . $v['id'] . '">(设置订单)</a></span><span><a href="#" class="delete"  data-toggle="modal" data-target="#delModal" data_id="'.$v["id"].'">(取消)</a></span>';
                        //$condition = '<span><a class="setOrders" data_id=".$v["id"].">(设置订单)</a></span><!--.<span class="delete" data_id=".$v["id"].">(取消)</span>-->';
                        $v['state'] = $arr_state[$v['state']] . $condition;
                    } elseif ($v['state'] == 2) {
                        $condition = '<td><a href="#" class="setOrders"  data-toggle="modal" data-target="#Modal" t_express_name="'.$v['express_name'].'" t_express_code="'.$v['express_num'].'" data_id="'.$v['id'].'">(修改订单)</a></td>';
                        //$condition = '<span class="modifyOrders" data_id=".$v["id"].">(修改订单)</span>';
                        $v['state'] = $arr_state[$v['state']] . $condition ;
                    } else {
                        $v['state'] = $arr_state[$v['state']];
                    }
                }
                unset($v);
            }
        }
        return $_res;
    }

    //设置订单物流单号
    public function ajaxSetOrder()
    {
        $deliveryModel = new DeliveryModel();
        //$where = array();
        if ($_POST['expressName'] && $_POST['expressCode']) {
            $id = $_POST["id"];
            $update = array('express_name' => $_POST['expressName'], 'express_num' => $_POST['expressCode']);
            $result = $deliveryModel->where("id = '{$id}'")->save($update);
            echo $result;
            //var_dump($result);exit;
            $state = 0;
            if ($result > 0) {
                $state = $deliveryModel->where("id = '{$id}'")->save(array('state' => 2));
            }
            echo $state;exit;
        }
    }

    //取消订单,恢复状态为 '已退货'
    public function ajaxDelOrder(){
        $deliveryModel = new DeliveryModel();
        $id = $_POST['id'];
        $res = $deliveryModel->where("id = '{$id}'")->save(array('state' => 3));
        echo $res;
    }

    //修改订单
    public function ajaxModOrder(){
        $deliveryModel = new DeliveryModel();
        if ($_POST['expressName'] && $_POST['expressCode']) {
            $id = $_POST["id"];
            $update = array('express_name' => $_POST['expressName'], 'express_num' => $_POST['expressCode']);
            $result = $deliveryModel->where("id = '{$id}'")->save($update);
            return $result;
            $state = 0;
            if ($result > 0) {
                $state = $deliveryModel->where("id = '{$id}'")->save(array('state' => 2));
            }
            echo $state;exit;

        }

    }


    //excel获取所有数据
    Private function getResultByStyle2()
    {
        //获取过滤条件--按订单查询
        $deliveryModel = new DeliveryModel();
        $where = array();
        if ($_GET['orderCode'] == '-110' && $_GET['orderState'] == '-110') {
            if ($_GET['startTime'] && $_GET['endTime']) {
                $where['create_time'] = array('between', array($_GET['startTime'], $_GET['endTime']));
            } else {
                $totalRecord = $deliveryModel->count();
            }

        } elseif ($_GET['orderState'] !== null && in_array($_GET['orderState'], [0, 1, 2, 3, 4, 5])) {
            if ($_GET['startTime'] && $_GET['endTime']) {
                $where['create_time'] = array('between', array($_GET['startTime'], $_GET['endTime']));
                $where['state'] = array('EQ', $_GET['orderState']);
            } else {
                $where['state'] = array('EQ', $_GET['orderState']);
            }

        } elseif ($_GET['orderCode'] and  $_GET['orderCode'] != '-110') {
            if ($_GET['startTime'] && $_GET['endTime']) {
                $where['create_time'] = array('between', array($_GET['startTime'], $_GET['endTime']));
                $where['order_id'] = array('LIKE', '%' . $_GET['orderCode'] . '%');
            } else {
                $where['order_id'] = array('LIKE', '%' . $_GET['orderCode'] . '%');
            }
        }
        if (!empty($where)) {
            $totalRecord = $deliveryModel->where($where)->count();
        } else {
            $totalRecord = $deliveryModel->count();
        }
        //默认返回值
        $_res = array(
            "draw" => $_GET["draw"],
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array()
        );
        //总数不为空
        if ($totalRecord > 0) {
            //查询sQL
            $result = $deliveryModel->where($where)->select();
            //查询结果存在
            if (count($result) > 0) {
                //增加额外字段“action”
                foreach ($result as &$res) {
                    $res['action'] = '<div>del</div>';
                }
                $_res = array(
                    "draw" => $_GET["draw"],
                    "recordsTotal" => $totalRecord,
                    "recordsFiltered" => $totalRecord,
                    "data" => $result
                );
                foreach ($_res['data'] as &$v) {
                    $v['pay_money'] = $v['pay_money'] / 100;
                }
                unset($v);
                $arr_state = array(0 => '待支付', 1 => '已支付未发货', 2 => '已支付已发货', 3 => '已退货',
                    4 => '已完成待评价', 5 => '已完成');
                foreach ($_res['data'] as &$v) {
                    $v['state'] = $arr_state[$v['state']];
                }
                unset($v);
                $pay_type = [1 => '微信', 2 => '支付宝', 3 => '云牛券'];
                foreach ($_res['data'] as &$v) {
                    $v['pay_type'] = $pay_type[$v['pay_type']];
                }
                unset($v);
            }
        }
        return $_res;
    }

    public function ajaxDeliveryExcel()
    {
        ini_set("max_execution_time", "300");

        $_Status = array(0 => '待支付', 1 => '已支付未发货', 2 => '已支付已发货', 3 => '已退货', 4 => '已完成待评价', 5 => '已完成');
        $paras["startTime"] = date("Y-m-d%2000:00:00", empty($_GET["startTime"]) ? strtotime(obtainMonthDate('-', 3)) + 86400 : strtotime($_GET["startTime"]));
        $paras["endTime"] = date("Y-m-d%2023:59:59", empty($_GET["endTime"]) ? time() : strtotime($_GET["endTime"]));
        $deliveryModel = new DeliveryModel();

        switch ($_GET['style']) {

            case 1: //按收货人查询
                $result = $this->getResultByStyle3();
                break;
            case 0: //按订单查询
                $result = $this->getResultByStyle2();
                break;
        }

        $k = 0;
        //$data = new \stdClass();
        $data = [];
        foreach ($result['data'] as $value) {
            $data[$k]->order_id = $value['order_id'];
            $data[$k]->create_time = $value['create_time'];
            $data[$k]->address_details = $value['address_details'];
            $data[$k]->name = $value['name'];
            $data[$k]->phone = $value['phone'];
            $data[$k]->state = $value['state'];
            $data[$k]->num = $value['num'];
            $data[$k]->pay_money = $value['pay_money'];
            $data[$k]->remark = $value['remark'];
            $data[$k]->pay_type = $value['pay_type'];
            $data[$k]->express_name = $value['express_name'];
            $data[$k]->express_num = $value['express_num'];
            $k++;

        }
        $xlsName = "提货记录数据"; //设置标题
        $xlsCell = array(
            array('order_id', '订单号'),
            array('create_time', '下单时间'),
            array('address_details', '收货地址'),
            array('name', '收货人姓名'),
            array('phone', '收货人电话'),
            array('state', '发货状态'),
            array('num', '提取数量'),
            array('pay_money', '运费'),
            array('remark', '备注'),
            array('pay_type', '支付类型'),
            array('express_name', '快递公司名称'),
            array('express_num', '快递单号')
        );
        $this->exportExcel($xlsName, $xlsCell, $data);

    }

    Private function getResultByStyle3()
    {
        //获取过滤条件--收货人
        $deliveryModel = new DeliveryModel();
        $where = array();
        if ($_GET['accName'] == '-110' && $_GET['accTel'] == '-110') {
            if ($_GET['startTime'] && $_GET['endTime']) {
                $where['create_time'] = array('between', array($_GET['startTime'], $_GET['endTime']));
                $totalRecord = $deliveryModel->where($where)->count();
            } else {
                $totalRecord = $deliveryModel->count();
            }
            //var_dump($totalRecord);exit;
        } elseif ($_GET['accName'] != '-110' && $_GET['accTel'] == '-110') {
            if ($_GET['startTime'] && $_GET['endTime']) {
                $where['create_time'] = array('between', array($_GET['startTime'], $_GET['endTime']));
                $where['name'] = array('EQ', $_GET['accName']);
                $totalRecord = $deliveryModel->where($where)->count();
            } else {
                $where['name'] = array('EQ', $_GET['accName']);
                $totalRecord = $deliveryModel->where($where)->count();
            }
        } elseif ($_GET['accTel'] != '-110' && $_GET['accName'] == '-110') {
            if ($_GET['startTime'] && $_GET['endTime']) {
                $where['create_time'] = array('between', array($_GET['startTime'], $_GET['endTime']));
                $where['phone'] = array('LIKE', '%' . $_GET['accTel'] . '%');
                $totalRecord = $deliveryModel->where($where)->count();
            } else {
                $where['phone'] = array('LIKE', '%' . $_GET['accTel'] . '%');
                $totalRecord = $deliveryModel->where($where)->count();
            }
        } elseif ($_GET['accName'] != '-110' && $_GET['accTel'] != '-110') {
            if ($_GET['startTime'] && $_GET['endTime']) {
                $where['create_time'] = array('between', array($_GET['startTime'], $_GET['endTime']));
                $where['name'] = array('LIKE', '%' . $_GET['accName'] . '%');
                $where['phone'] = array('EQ', $_GET['accTel']);
                $totalRecord = $deliveryModel->where($where)->count();
            } else {
                $where['name'] = array('LIKE', '%' . $_GET['accName'] . '%');
                $where['phone'] = array('EQ', $_GET['accTel']);
                $totalRecord = $deliveryModel->where($where)->count();
            }
        }
        //默认返回值
        $_res = array(
            "draw" => $_GET["draw"],
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array()
        );
        //总数不为空
        if ($totalRecord > 0) {

            //查询SQL
            $result = $deliveryModel->where($where)->select();
            // var_dump($result);exit;
            //查询结果存在
            if (count($result) > 0) {
                //增加额外字段“action”
                foreach ($result as &$res) {
                    $res['action'] = '<div>del</div>';
                }
                $_res = array(
                    "draw" => $_POST["draw"],
                    "recordsTotal" => $totalRecord,
                    "recordsFiltered" => $totalRecord,
                    "data" => $result
                );
                foreach ($_res['data'] as &$v) {
                    $v['pay_money'] = $v['pay_money'] / 100;
                }
                unset($v);
                $arr_state = array(0 => '待支付', 1 => '已支付未发货', 2 => '已支付已发货', 3 => '已退货',
                    4 => '已完成待评价', 5 => '已完成');
                foreach ($_res['data'] as &$v) {
                    $v['state'] = $arr_state[$v['state']];
                }
                unset($v);
                $pay_type = [1 => '微信', 2 => '支付宝', 3 => '云牛券'];
                foreach ($_res['data'] as &$v) {
                    $v['pay_type'] = $pay_type[$v['pay_type']];
                }
                unset($v);
            }
        }
        return $_res;
    }

    public function exportExcel($expTitle, $expCellName, $expTableData)
    {
        $xlsTitle = $expTitle; //文件名称
        $fileName = date('_YmdHis'); //or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("phpexcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1'); //合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . '    导出时间:' . date('Y-m-d H:i:s'));
        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]); //分配表头
        }
        // Miscellaneous glyphs, UTF-8
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet(0)->setCellValueExplicit($cellName[$j] . ($i + 3), $expTableData[$i]->$expCellName[$j][0], \PHPExcel_Cell_DataType::TYPE_STRING); //非配内容
            }
        }
        /* $objPHPExcel->getActiveSheet()->setCellValue("F".($dataNum+3), '=SUM(F3:F'.($dataNum+2).')');
         $objPHPExcel->getActiveSheet()->setCellValue("G".($dataNum+3), '=SUM(G3:G'.($dataNum+2).')');*/
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls"); //attachment新窗口打印inline本窗口打印
        vendor("Excel.PHPExcel.IOFactory");
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

    }


}

?>