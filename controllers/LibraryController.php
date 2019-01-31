<?php

namespace app\controllers;

use Yii;
use app\models\Library;
use app\models\LibrarySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
class LibraryController extends Controller
{   
   
    public function actionIndex() {
        $request = Yii::$app->request;

        if($request -> isPost ) {
            $query = $request -> post()['query'];
            $query = '%'.$query.'%';
            $sql = "select * from library where name like :name or auther like :auther ";
            $result = Library::findBySql($sql, array('name' =>$query, 'auther'=>$query)) ->all();
            echo Json::encode($result);
            // return echo Json::encode($result);
            // return $this -> render('index', [ 'arrs' =>  $result]);
        }else {
            $result = Library::find() -> all();
            echo Json::encode($result);
            // return $this -> render('index', [ 'arrs' =>  $result]);
        }
        
    }

    public function actionView($id) {
        $request = Yii::$app->request;
        $sql = "select * from library where id=:id";
        $result = Library::findBySql($sql, array('id' =>$id)) -> asArray() ->all();
        echo Json::encode($result);
        // return 
        // return $this -> render('view', $result[0]);

    }

    public function actionCreate() {
        // 获取参数
        // $request = Yii::$app->request->get();
        $model = new Library();
        // 这种方式需要表单name =library[name] 的方式
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }else {
            return $this -> render('create');
        }
    }


    public function actionUpdate($id) {
        // 获取参数
        $request = Yii::$app->request;
       
        
        if ($request -> isPost) {
            $name = $request -> post()['name'];
            $auther = $request -> post()['auther'];
            $price = $request -> post()['price'];
            $result = Library::updateAll(['name' => $name, 'auther'=> $auther, 'price' => $price], ['id'=> $id]);
            return $this->redirect(['index']);
        }else {
            $request = Yii::$app->request;
            $sql = "select * from library where id=:id";
            $result = Library::findBySql($sql, array('id' =>$id)) -> asArray() ->all();
            return $this -> render('update', $result[0]);
        }
    }


    public function actionDelete($id) {
        $result = Library::find() -> where(['id' => $id]) -> all();
        $result[0] -> delete();
        return $this->redirect(['index']);
    }

}
?>