<?php
namespace App\Http\Services;

class MediaService
{
    public function CreateMedia($model,$file, $collection= 'images'){
        return $model->addMedia($file)->toMediaCollection($collection);
    }

    public function editMedia($model, $file, $collection = 'images'){
        if($model->getMedia($collection)->isNotEmpty()){
            $model->clearMediaCollection($collection);
        }
        return $this->CreateMedia($model, $file, $collection);
    }

    public function deleteMedia($model, $collection = 'images'){
        if($model->getMedia($collection)->isNotEmpty()){
            $model->clearMediaCollection($collection);
        }
        return true;
    }
}