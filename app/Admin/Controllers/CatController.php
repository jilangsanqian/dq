<?php
namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Model\WhtBookModel;
use App\Model\WhtTypeModel;
use App\Model\WhtSpiderSettingModel;
use App\Model\WhtBookChapterModel;
use App\Model\WhtSpiderLogModel;
use App\Admin\BatchTools\Book;
use Illuminate\Http\Request;
//use App\Service\SpiderService\BookSpider;
use App\Jobs\BookspiderJob;
use App\Jobs\CategorySpiderJob;
use Carbon\Carbon;//定时
use App\Service\SpiderService\CategorySpider;
use App\Service\SpiderService\BookSpider;

class CatController extends Controller {
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index() {

        return Admin::content(function (Content $content) {
            $content->header('分类列表');
            //$content->description('爬取详细记录');
            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id) {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');
            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create() {
        return Admin::content(function (Content $content) {
            $content->header('小说列表');
            $content->description('小说列表');
            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid() {
        return Admin::grid(WhtSpiderSettingModel::class,function (Grid $grid) {
            $grid->disableCreateButton();//禁用创建按钮
            $grid->disableActions(); //禁用行操作按钮
            $grid->disableExport(); //禁用导出按钮
            //$grid->disableRowSelector();
            //$filter->disableIdFilter();
            $grid->model()->paginate();
            $grid->id('爬虫ID')->sortable();
            $grid->spider_name('爬虫名称');
            $grid->spider_key_word('爬虫别名');
            $grid->page_start('开始页');
            $grid->page_end('结束页码');
            $grid->finsh_page('已爬取数');
            $grid->book_type('类型')->display(function ($book_type) {
               return (new WhtTypeModel)->where(['id' => $book_type])
                    ->select('type_name')->first()->type_name;
            });
            $grid->spider_url('爬取URL');
            $grid->update_time('更新时间');
            $grid->create_time('创建时间');

            //过滤条件
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
               // $filter->equal('status','爬取类型')->select(['0' => '书籍','1' => '分类']);
                //$filter->equal('state','爬取状态')->select(['0' => '失败','1' => '成功']);
            });
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                    $batch->add('采集',new  Book(3));
                });
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form() {
        return Admin::form(WhtBookModel::class,function (Form $form) {
            //连载状态0连载中1已完结2断更
            $directors = [
                '连载中' => 0,
                '已完结' => 1,
                '断更'  => 2,
            ];
            $form->select('is_over','书籍状态')->options($directors);
            //$form->setAction('采集');
        });
    }

    public function spliderStart(Request $request) {
        $ids = $request->get('ids');
        $spiderSettingModel = new WhtSpiderSettingModel();
        $list  = $spiderSettingModel->getList($ids);
        foreach ($list as $spiderSetting) {
                //爬取书籍分类
                $temptype = [
                    'pageStart' => $spiderSetting->page_start,
                    'pageEnd' => $spiderSetting->page_end,
                    'finshPage' => $spiderSetting->finsh_page,
                    'spiderUrl' => $spiderSetting->spider_url,
                    'spiderKeyWord' => $spiderSetting->spider_key_word,
                    'pageList' => true
                ];
                //分类爬取
               CategorySpiderJob::dispatch($temptype)->delay(Carbon::now()->addSecond(1))->onQueue(config('queue.categorySpiderQueueName'));
                //( new CategorySpider())->do($temptype);
        }
        return $this->Response();
    }

}
