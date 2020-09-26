<?php

namespace app\store\controller\content;

use app\store\controller\Controller;
use app\store\model\ArticleLog as ArticleModel;
use app\store\model\article\Category as CategoryModel;
use think\Db;

/**
 * 文章管理控制器
 * Class article
 * @package app\store\controller\content
 */
class ArticleLog extends Controller
{
    /**
     * 文章列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = Db::name('article_log')->alias('a')->join('salesman s','s.salesman_id = a.salesman_id')->field('a.*,s.real_name')->where('a.is_delete',0)->paginate(15);
        return $this->fetch('index', compact('list'));
    }

    /**
     * 添加文章
     * @return array|mixed
     */
    public function add()
    {
        $model = new ArticleModel;
        if (!$this->request->isAjax()) {
            // 文章分类
            $catgory = CategoryModel::getAll();
            return $this->fetch('add', compact('catgory'));
        }
        // 新增记录
        if ($model->add($this->postData('article'))) {
            return $this->renderSuccess('添加成功', url('content.article/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 更新文章
     * @param $article_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($article_id)
    {
        // 文章详情
        $model = ArticleModel::detail($article_id);
        if (!$this->request->isAjax()) {
            // 文章分类
            $catgory = CategoryModel::getAll();
            return $this->fetch('edit', compact('model', 'catgory'));
        }
        // 更新记录
        if ($model->edit($this->postData('article'))) {
            return $this->renderSuccess('更新成功', url('content.article/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除文章
     * @param $article_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($id)
    {
        // 文章详情
        $id = input('id');
        $model = Db::name('article_log')->where('id',$id)->update(['is_delete'=>1]);
        if (!$model) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}