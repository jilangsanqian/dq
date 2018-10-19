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

class BookController extends Controller {
	use ModelForm;

	/**
	 * Index interface.
	 *
	 * @return Content
	 */
	public function index() {

		return Admin::content(function (Content $content) {
			$content->header('小说列表');
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
		return Admin::grid(WhtBookModel::class,function (Grid $grid) {
			$grid->disableCreateButton();//禁用创建按钮
			$grid->disableActions(); //禁用行操作按钮
			$grid->disableExport(); //禁用导出按钮
			//$grid->disableRowSelector();
			$grid->model()->paginate();
			$grid->id('bookId')->sortable();
			$grid->book_name('书籍名称');
			$grid->book_auther('作者');
			$grid->book_type('书籍类型')->display(function ($bookType) {
				return WhtTypeModel::where(['id' => $bookType])->select('type_name')->first()->type_name;
			});
			$grid->sort('书籍排序')->sortable()->editable();;
			$grid->nav_recommend('首页推荐')->editable('select',[1 => '是',0 => '否']);
			$grid->new_chapter('最新章节名称');
			$grid->is_over('状态')->display(function ($isOver) {
				$l = [
					0 => '连载中',
					1 => '完结',
					2 => '断更',
				];
				return isset($l[$isOver]) ? $l[$isOver] : '未知';
			});
			$grid->is_display('是否显示')->editable('select',[1 => '显示',0 => '不显示']);
			$grid->update_time('更新时间');
			$grid->create_time('创建时间');
			//			//过滤条件
			//			$grid->filter(function ($filter) {
			//				$filter->disableIdFilter();
			//				$filter->equal('status','爬取类型')->select(['0' => '书籍','1' => '分类']);
			//				$filter->equal('state','爬取状态')->select(['0' => '失败','1' => '成功']);
			//			});
			$grid->tools(function ($tools) {
				$tools->batch(function ($batch) {
					$batch->disableDelete();
					$batch->add('更新章节',new  Book(3));
				});
			});
			//过滤条件
			$grid->filter(function ($filter) {
				$filter->disableIdFilter();
				$filter->like('bookName','书籍名称');
				$filter->like('book_auther','作者');
				$directors = [
					'连载中',
					'已完结',
					'断更',
				];
				$filter->equal('is_over','书籍状态')->select($directors);
				$filter->equal('is_display','是否显示')->select(['0' => '不显示','1' => '显示']);
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
		$spiderLogInfo = (new WhtSpiderLogModel())->getSpiderLists($ids);
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
					//'pageStart' => $spiderSetting->page_start,
					//'pageEnd' => $spiderSetting->page_end,
					//'finshPage' => $spiderSetting->finsh_page,
					// 'spiderUrl' => [$spiderSetting->spider_url,
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

	//信息修改
	public function updateInfo(Request $request,$id) {
		$fileName = $request->get('name');
		$value = $request->get('value');
		$result = (new WhtBookModel)->updateInfo(['id' => $id],[$fileName => $value]);
		$msg  = [];
		if(!$result){
			$msg = ['code' => 0,'msg' => 'msg'];
		}
		return $this->Response($msg);
	}

	public function details($id) {

	}
}
