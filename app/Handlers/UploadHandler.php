<?php

namespace App\Handlers;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\Response;

class UploadHandler
{
    protected $allowed_ext_image = ["png", "jpg", "gif", 'jpeg'];
    protected $allowed_ext_voice = ["mp3", "wav", 'ogg'];
    protected $allowed_ext_video = ["mp4", "mov", 'wmv', 'avi', 'flv', 'rm'];
    protected $suffix = 'image';

    public function save($file, $folder = 'image', $type, $max_width = false)
    {
        try{
            $this->suffix = $type;
            switch ($type) {
                case 'image':
                case 'file':
                    return $this->saveImage($file, $folder, $type=='image' ? $max_width : false);
                case 'video':
                case 'voice':
                    return $this->saveImage($file, $folder, $type=='image' ? $max_width : false);
                //return $this->saveVideo($file);
                default:
                    break;
            }
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }catch (\Error $error){
            throw new \Exception($error->getMessage(),Response::HTTP_BAD_REQUEST);
        }

    }

    private function saveImage($file, $folder, $max_width = false)
    {

        // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
        // 文件夹切割能让查找效率更高。
        $folder_name = "uploads/$folder/" . date("Ymd", time()) .'/';

        // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径。
        // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/201709/21/
        $upload_path = public_path() . '/' . $folder_name;

        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的 ID
        // 值如：1_1493521050_7BVc9v9ujP.png
        $filename = time() . '_'  . uniqid() . str_random(3) . '.' . $extension;

        // 如果上传的不是图片将终止操作
        if ($this->suffix != 'file' && ! in_array($extension, $this->getAllowedExt())) {
            return false;
        }

        // 将图片移动到我们的目标存储路径中
        $file->move($upload_path, $filename);

        // 如果限制了图片宽度，就进行裁剪
        if ($max_width && $this->suffix == 'image' && $extension != 'gif') {

            // 此类中封装的函数，用于裁剪图片
            $this->reduseSize($upload_path . $filename, $max_width);
        }

        return  "/$folder_name$filename";
    }

    private function saveVideo($file, $disk='public') {

        if (! $file->isValid()) {
            return false;
        }

        $fileExtension = $file->getClientOriginalExtension();

        if(! in_array($fileExtension,$this->getAllowedExt())) {
            return false;
        }

        $tmpFile = $file->getRealPath();

        $filename = 'uploads/' . time() . '_'  . uniqid() . str_random(3) . '.' . $fileExtension;

        if (Storage::disk($disk)->put($filename, file_get_contents($tmpFile)) ){
            return Storage::url($filename);
        }
    }
    public function reduseSize($file_path, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
    }

    private function getAllowedExt()
    {
        switch ($this->suffix) {
            case 'image':
                return $this->allowed_ext_image;
            case 'video':
                return $this->allowed_ext_video;
            case 'voice':
                return $this->allowed_ext_voice;
            case 'file':
                return $this->allowed_ext_image;
                break;
            default:
                return $this->allowed_ext_image;
                break;
        }
    }
}
