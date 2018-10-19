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
use App\Admin\BatchTools\Spider;
use App\Model\WhtSpiderLogModel;
use Illuminate\Http\Request;
//use App\Service\SpiderService\BookSpider;
use App\Jobs\BookspiderJob;
use App\Jobs\CategorySpiderJob;
use Carbon\Carbon;//定时
use App\Service\SpiderService\CategorySpider;
use App\Service\SpiderService\BookSpider;

class NovelController extends Controller {
	use ModelForm;

	/**
	 * Index interface.
	 *
	 * @return Content
	 */
	public function index() {

		return Admin::content(function (Content $content) {


			$content->header('爬取记录列表');
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

			$content->header('爬取记录');
			$content->description('爬取详细记录');
			$content->body($this->form());
		});
	}

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		return Admin::grid(WhtSpiderLogModel::class,function (Grid $grid) {
			$grid->disableCreateButton();//禁用创建按钮
			$grid->disableActions(); //禁用行操作按钮
			$grid->disableExport(); //禁用导出按钮
			//$grid->disableRowSelector();
			$grid->model()->paginate();
			$grid->id('序列号')->sortable();
			$grid->book_id('书籍名称')->display(function ($bookId) {
				if ($bookId <= 0){
					return '无';
				}
				return WhtBookModel::where(['id' => $bookId])->select('book_name')->first()->book_name;
			});
			$grid->book_type('书籍类型')->display(function ($bookType) {

				return WhtTypeModel::where(['id' => $bookType])->select('type_name')->first()->type_name;
			});
			$grid->spider_id('爬虫名称')->display(function ($spiderId) {
				return WhtSpiderSettingModel::where(['id' => $spiderId])->select('spider_name')->first()->spider_name;
			});
			$grid->status('爬取类型')->display(function ($status) {
				return $status == 1 ? '分类' : '单本';
			});
			$grid->state('爬取状态')->display(function ($state) {
				return $state == 1 ? '成功' : '失败';
			});
//			$grid->spider_chapter_id('最新章节')->display(function ($spiderChapterId) {
//				if ($spiderChapterId <= 0){
//					return '暂无最新章节';
//				}
//				$obj = WhtBookChapterModel::where(['chapter_id' => $spiderChapterId])->select('chapter_name')->first();
//				return $obj ? $obj->chapter_name : '暂无最新章节';
//			});
			$grid->spider_url('爬取网址');
			$grid->update_time('更新时间');
			$grid->create_time('创建时间');
			//过滤条件
			$grid->filter(function ($filter) {
				$filter->disableIdFilter();
				$filter->equal('status','爬取类型')->select(['0' => '书籍','1' => '分类']);
				$filter->equal('state','爬取状态')->select(['0' => '失败','1' => '成功']);
			});
			$grid->tools(function ($tools) {
				$tools->batch(function ($batch) {
					$batch->disableDelete();
					$batch->add('采集',new  Spider(1));
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
		return Admin::form(WhtSpiderLogModel::class,function (Form $form) {
			$directors = [
				'成功' => 1,
				'失败' => 0,
			];
			$form->select('status','状态')->options($directors);
			$form->setAction('采集');
		});
	}

	public function spliderStart(Request $request) {

		$ids = $request->get('ids');
		$spiderLogInfo = (new WhtSpiderLogModel())->getSpiderList($ids);
		if (!$spiderLogInfo){
			return $this->Response(['code' => 0,'msg' => '不存在爬取记录']);
		}
		$spiderSettingModel = new WhtSpiderSettingModel();
		foreach ($spiderLogInfo as $obj) {
			$spiderSetting = $spiderSettingModel->getOne($obj->spider_id);
			$temp = $temptype = [];
			if (!$spiderSetting){
				continue;
			}
			//爬书籍
			$temp = [
				'spiderUrl'     => [$obj->spider_url],
				'spiderUrlHash' => $obj->spider_url_hash,
				'spiderKeyWord' => $spiderSetting->spider_key_word,
				'spiderConfig'  => $spiderSetting->spider_config,
				'bookType'      => $obj->book_type,
				'spiderId'      => $obj->spider_id,
				'status'        => $obj->status,
				'bookId'        => $obj->book_id,
			];
			if ($obj->status == 1){
				//爬取书籍分类
				$temptype = [
				//	'pageStart' => $spiderSetting->page_start,
				//	'pageEnd' => $spiderSetting->page_end,
				//	'finshPage' => $spiderSetting->finsh_page,
				//	'spiderUrl' => [$spiderSetting->spider_url],
					'pageList' => false,
				];
				//分类爬取
				CategorySpiderJob::dispatch(array_merge($temp,$temptype))->delay(Carbon::now()->addSecond(1))->onQueue(config('queue.categorySpiderQueueName'));
				//( new CategorySpider())->do(array_merge($temp,$temptype));
				continue;
			}
			//单本书爬虫调用
			BookspiderJob::dispatch($temp)
				->delay(Carbon::now()->addSecond(1))
				->onQueue(config('queue.bookSpiderQueueName'));
			//(new BookSpider)->do($temp);
		}
		return $this->Response();
	}
}
