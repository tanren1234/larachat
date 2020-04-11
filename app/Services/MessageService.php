<?php
namespace App\Services;
use App\Handlers\ImageUploadHandler;
use App\Handlers\UploadHandler;
use App\Model\Message;
use App\Model\MessageNotification;
use App\Traits\SetsParticipants;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: tanliang
 * Date: 2019/9/4
 * Time: 20:44
 */
class MessageService
{
    use SetsParticipants;

    protected $body = '';
    protected $type = 'text';
    protected $url = '';
    protected $cover_pic = '';
    protected $extra = '';

    public function __construct(Message $message, Request $request)
    {
        $this->message = $message;
        $this->request = $request;
        $this->type = $request->type?:'text';
    }

    public function getBody()
    {
        return $this->body?:'';
    }
    public function getType()
    {
        return $this->type;
    }

    public function getUrl()
    {
        return $this->url?:'';
    }

    public function getCoverPic()
    {
        return $this->cover_pic?:'';
    }

    public function getExtra()
    {
        return $this->extra?:'';
    }

    /**
     * 设置message
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        if (is_object($message)) {
            $this->message = $message;
        }else{
            $this->body = $message;
        }
        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type?:'text';

        return $this;
    }

    /**
     * 上传文件
     * @param UploadHandler $uploader
     * @throws \Exception
     */
    protected function uploadContent(UploadHandler $uploader)
    {
        /* text 文本  image 图片    voice 语音    video 视频    file 文件   location 位置*/
        $type = $this->type;
        switch ($type) {
            case 'image':
            case 'video':
            case 'voice':
            case 'file':
                if ($this->request->hasFile('upload_file')) {

                    $this->url = $uploader->save($this->request->file('upload_file'), $type, $type);
                }else{

                    $this->url = $this->request->post('upload_file')?:'';
                }
                break;
            case 'location':
                break;
            default:
                break;
        }
    }

    public function send()
    {

        if (!$this->from) {
            throw new \Exception('Message sender has not been set');
        }

        if (!$this->body && $this->type == 'text') {
            throw new \Exception('Message body has not been set');
        }
        // 会话对象
        if (!$this->to) {
            throw new \Exception('Message receiver has not been set');
        }
        // 上传文件
        $this->uploadContent(new UploadHandler());

        // 消息记录
        $message = Message::send($this->to, $this, $this->from, $this->type);

        // 消息通知记录
        MessageNotification::make($message, $this->to);

        // push服务推送消息
        PushService::pushMessage($message, $this->to);

        return $message;
    }
}
